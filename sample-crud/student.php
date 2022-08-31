<?php
require '../_db.php';
session_start();
switch ($_SERVER["REQUEST_METHOD"]) {
    case "POST";
        if (isset($_POST['hapus']) && !empty($_POST['hapus'])) {
            return hapus();
        }
        if (isset($_POST['id']) && empty($_POST['id'])) {
            return tambah();
        }
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            return edit();
        }
        break;
    default:
        header("HTTP/1.1 404 URL Not Found");
}

function tambah()
{
    $db  = new Database();
    $insert = $db->insert_data("INSERT INTO students (`nim`, `name`, `jurusan`, `status`) SELECT ?,?,?,? FROM (select 1) a WHERE NOT EXISTS (SELECT id FROM students WHERE nim =?)", 'sssss', $_POST['nim'],$_POST['name'],$_POST['jurusan'],$_POST['status'],$_POST['nim']);
   
   if ($insert) {
    return Alert('success', 'Data Berhasil Dihapus');
   }
   return Alert('danger', 'Data Tidak berhasil dihapus');
}

function edit()
{
    $db  = new Database();
    $uodate = $db->updel_data("UPDATE students SET `nim`=?, `name`=?, `jurusan`=?, `status`=? WHERE id = ?", 'sssss', $_POST['nim'],$_POST['name'],$_POST['jurusan'],$_POST['status'],$_POST['id']);
   
    if ($uodate) {
        return Alert('success', 'Data Berhasil Dihapus');
    }
    return Alert('danger', 'Data Tidak berhasil dihapus');
}

function hapus()
{
    $db  = new Database();
    $del = $db->updel_data("DELETE FROM students where id = ?", 'i', $_POST['hapus']);
    
    if ($del) {
        return Alert('success', 'Data Berhasil Dihapus');
    }
   return Alert('danger', 'Data Tidak berhasil dihapus');

}
function Alert($alert, $message)
{
    $_SESSION['alert']      = $alert;
    $_SESSION['message']    = $message;
    
    header("Location: index.php");
}


?>