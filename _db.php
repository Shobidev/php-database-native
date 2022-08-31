<?php

// namespace DB\Database;

class Database
{
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "test";
    private $connection;

    function getConnection()
    {
        $this->connection = null;
        try {
            $this->connection = mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
            return $this->connection;
        } catch (PDOException $exception) {
            header("HTTP/1.1 404 Not Found");
        }
    }

    public function setDatabase($db)
    {
        $this->database = $db;
    }

    public function select($query)
    {
        try {
            $this->getConnection();
            $db = $this->connection->prepare($query);
            $db->execute();
            $result = $db->get_result();
            $db->close();
        } catch (Exception $e) {
            $this->failed($e->getMessage());
        }
        return $result;
    }
    public function select_where($query, $type, ...$param)
    {
        try {
            $this->getConnection();
            $db = $this->connection->prepare($query);
            $db->bind_param($type, ...$param);
            $db->execute();
            $result = $db->get_result();
            $db->close();
            $this->connection->close();
        } catch (Exception $e) {
            $this->failed($e->getMessage());
        }
        return $result;
    }

    public function insert_data($query, $type, ...$param)
    {
        try {
            $this->getConnection();
            $db = $this->connection->prepare($query);
            $db->bind_param($type, ...$param);
            $db->execute();
            $result = $db->insert_id;
            $db->close();
            $this->connection->close();
        } catch (Exception $e) {
            $this->failed($e->getMessage());
        }
        return $result;
    }

    public function updel_data($query, $type, ...$param)
    {
        try {
            $this->getConnection();
            $db = $this->connection->prepare($query);
            $db->bind_param($type, ...$param);
            $db->execute();
            $result = $db->affected_rows;
            $db->close();
        } catch (Exception $e) {
            $this->failed($e->getMessage());
        }
        return $result;
    }

    public function select_publish($key)
    {
        try {
            $data = $this->select_where("SELECT publish_label as label, publish_key_label as key_label FROM m_publish WHERE publish_key = ? AND publish_apply = ?", 'si', $key, $this->pub_allow)->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return false;
        }
        return $data;
    }

    public function response($status, $message, $data)
    {
        header('Content-Type: application/json');
        $response = [
            'status'    => $status,
            'message'   => $message,
            'data'      => $data
        ];
        echo json_encode($response);
    }
    public function failed($message)
    {
        header('Content-Type: application/json');
        $response = [
            'status'    => 'failed',
            'message'   => $message,
            'data'      => null
        ];
        echo json_encode($response);
    }
}
