<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $result = mysqli_query($conn, "SELECT * FROM tbl_pembeli WHERE id=$id");
  if ($result) {
    $row = mysqli_fetch_assoc($result);
  } else {
    echo "Ngapain bang?";
    exit();
  }
} else {
  echo "ID not found";
  exit();
}

if($id < 0) {
  echo "Ngapain bang?";
}
if (isset($_POST["update"])) {
  $id = htmlspecialchars($_POST['id']);
  $name = htmlspecialchars($_POST['name']);
  $buying = htmlspecialchars($_POST['buying']);
  $res = $buying * 10000;

  $query = "UPDATE tbl_srt SET bought = bought + $buying";
  if (!mysqli_query($conn, $query)) {
    echo "Ngapain bang?";
    exit();
  }

  $result = mysqli_query($conn, "UPDATE tbl_pembeli SET name='$name', buying=$buying, res=$res WHERE id=$id");
  if ($result) {
    echo "<script>
 alert('Data berhasil di ubah');
 document.location.href= '../index.php';
 </script>";
  } else {
    echo "<script>
    alert('Data gagal di ubah');
    document.location.href= '../index.php';
    </script>";
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Form Edit</title>
      <!-- Load Bootstrap CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
            integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm2rUCgx" crossorigin="anonymous">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    
   </head>
   <body>
   <div class="container mt-4">
  <div class="card">
    <div class="card-header">
      <h4>Edit Pembelian</h4>
    </div>
    <div class="card-body">
      <form action="" method="POST">
        <div class="form-group row">
          <div class="col-md-3 col-sm-12">
            <div class="input-group">
              <div class="input-group-prepend">
		  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
              </div>
              <input type="text" id="name" name="name" class="form-control" value=<?php echo $row["name"];?> required>
              <br><br>
            </div>
            <br>
          </div>
          <div class="col-md-3 col-sm-12">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
              </div>
              <input type="number" id="buying" name="buying" class="form-control" value=<?php echo $row["buying"]; ?> required>
               <br><br>
            </div>
            <br>
          </div>
          <br>
          <div class="col-md-3 col-sm-12">
            <button class="btn btn-success" name="update"><i class="fa fa-lock" aria-hidden="true"> Update</i></button>
          </div>
        </div>
      </form>
      <a href="../index.php" class="btn btn-primary">
  <i class="fa fa-home" aria-hidden="true"> Home</i>
  </a>
    </div>
  </div>
</div>

    <!-- Load Bootstrap JS and jQuery -->
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" 
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" 
            integrity="sha384-ZMP7rVo3mIykV+2mJewEPHiL0JoJQomlSAwiGgR/6ZI1TqUksdQRVvoxMfooAo7o" 
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" 
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIeXvL46Pj8rYfPp7Vj/pQTaI6G/hHTEN/tWyIwwjww/" 
            crossorigin="anonymous"></script>
</body>
</html>
