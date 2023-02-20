<?php
  include '../koneksi.php';
  $result = mysqli_query($conn,"SELECT * FROM tbl_srt");
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Form Input Pembelian</title>
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
      <h4>Input Pembelian</h4>
    </div>
    <div class="card-body">
      <form action="" method="POST">
        <div class="form-group row">
          <div class="col-md-3 col-sm-12">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
              </div>
              <input type="text" id="name" name="name" class="form-control" placeholder="Nama" required>
              <br><br>
            </div>
            <br>
          </div>
          <div class="col-md-3 col-sm-12">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
              </div>
              <input type="number" id="beli" name="beli" class="form-control" placeholder="Masukan Jumlah" required>
               <br><br>
            </div>
            <br>
          </div>
          <br>
          <div class="col-md-3 col-sm-12">
            <button class="btn btn-success" name="submit"><i class="fa fa-lock" aria-hidden="true"> Submit</i></button>
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
    <?php
      if (isset($_POST['submit'])) {
        $name = htmlspecialchars($_POST['name']);
        $beli = htmlspecialchars($_POST['beli']);

        $row = mysqli_fetch_assoc($result);
        $stock = $row['stock'];
        $price = $row['price'];

        $total_price = $price * $beli;

        if ($stock >= $beli) {
          $update_query = "UPDATE tbl_srt SET stock = stock - $beli, totals = totals + $total_price WHERE id = 1";
          if (mysqli_query($conn, $update_query)) {
            echo "<script>
    swal('Success!!', 'Berhasil membeli, menambahkan penjualan sebanyak $beli, menambahkan data $name ke dalam data pembeli ', 'success');
    </script>";
          } else {
            echo "<script>
            swal('Error!!', 'Inputkan dengan benar', 'error');
            </script>";
          }
          echo "<br>";
          $query = "UPDATE tbl_srt SET bought = bought + $beli";
          if (mysqli_query($conn, $query)) {
          } else {
          }
          echo "<br>";
          $insert_query = "INSERT INTO tbl_pembeli (name, buying, res) VALUES ('$name', '$beli', '$total_price')";
          if (mysqli_query($conn, $insert_query)) {
          } else {
          }          
        } else {
          echo "<script>
          swal('Error!!', 'Stok barang tidak mencukupi', 'error');
          </script>";
      }
    }
  ?>
</body>
</html>