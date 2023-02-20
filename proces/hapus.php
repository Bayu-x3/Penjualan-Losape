<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
include '../koneksi.php';
$id = $_GET['id'];

$del = mysqli_query($conn,"DELETE FROM tbl_pembeli WHERE id = '$id' ");

if(mysqli_affected_rows($conn) > 0) {
 $query = "UPDATE tbl_srt SET bought = bought - $del";
 if (mysqli_query($conn, $query)) {
 } else {
 }
 echo "<script>
 alert('Data berhasil di hapus');
 document.location.href= '../index.php';
 </script>";
} else {
 echo "<script>
 alert('Gagal');
 document.location.href= 'index.php';
 </script>";
}
?>