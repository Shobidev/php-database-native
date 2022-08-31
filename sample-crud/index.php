<?php
session_start();
require '../_db.php';
$db         = new Database();
$data       = $db->select("SELECT `id`, `nim`, `name`, `jurusan`, `status` FROM students ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
$alert      = isset($_SESSION['alert']) ? $_SESSION['alert'] : false; 
$message    = isset($_SESSION['message']) ? $_SESSION['message'] : false; 
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container-fluid bg-warning text-center p-2">
        <h5>PHP MYSQL NATIVE</h5>
    </div>
    <div class="container mt-2">
        <div class="row">
            <?php  if ($alert) { ?>
                <div class="alert alert-<?=$alert?>" role="alert">
                    <?=$message?>
                </div>
            <?php }?>
            <div class="col-2 mt-2">
                <button class="btn btn-sm btn-primary" id="btn-tambah" data-toggle="modal"
                    data-target="#formModal">Tambah Data</button>
            </div>
            <div class="col-12">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">NAMA</th>
                            <th scope="col">JURUSAN</th>
                            <th scope="col">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $i => $val) : ?>
                        <tr>
                            <th scope="row"><?= $i+1?></th>
                            <td><?= $val['nim']?></td>
                            <td><?= $val['name']?></td>
                            <td><?= $val['jurusan']?></td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-edit" data-toggle="modal"
                                    data-target="#formModal" data-id="<?=$val['id']?>" data-nim="<?=$val['nim']?>"
                                    data-name="<?=$val['name']?>" data-jurusan="<?=$val['jurusan']?>"
                                    data-status="<?=$val['status']?>">Edit</button>
                                <button class="btn btn-sm btn-danger btn-hapus" data-toggle="modal"
                                    data-target="#formHapusModal" data-id="<?=$val['id']?>">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="label"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="student.php">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nim:</label>
                                        <input type="hidden" class="form-control" name="id" id="id_student">
                                        <input type="text" class="form-control" name="nim" id="nim_student">
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Nama:</label>
                                        <input type="text" class="form-control" name="name" id="name_student">
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Jurusan:</label>
                                        <input type="text" class="form-control" name="jurusan" id="jurusan_student">
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Status:</label>
                                        <select name="status" id="status_student" class="form-control">
                                            <option value="Aktif">Aktif</option>
                                            <option value="Tidak Aktif">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="formHapusModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Hapus Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="student.php">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Apakah Anda Yakin untuk
                                            menghapus data ini ?</label>
                                        <input type="hidden" class="form-control" name="hapus" id="id_hapus">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
    integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function () {
        console.log('hayy');
        $('#btn-tambah').click(function () {
            $('#label').text('Tambah Data');
            $('#id_student').val('');
            $('#nim_student').val('');
            $('#name_student').val('');
            $('#jurusan_student').val('');
        });
        $('.btn-edit').click(function () {
            $('#label').text('Rubah Data');
            $('#id_student').val($(this).data('id'));
            $('#nim_student').val($(this).data('nim'));
            $('#name_student').val($(this).data('name'));
            $('#jurusan_student').val($(this).data('jurusan'));
            $('#status_student').val($(this).data('status'));
        });
        $('.btn-hapus').click(function () {
            $('#id_hapus').val($(this).data('id'));
        });
    })
</script>

</html>