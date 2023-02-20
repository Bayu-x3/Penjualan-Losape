<?php
include 'koneksi.php';
$result = mysqli_query($conn,"SELECT * FROM tbl_pembeli");
$result1 = mysqli_query($conn,"SELECT * FROM tbl_pembeli");

$total = 0;
while ($row = mysqli_fetch_assoc($result)) {
  $total += $row['res'];
}

$total_barang = 0;
while ($row = mysqli_fetch_assoc($result1)) {
  $total_barang += $row['buying'];
}
// Ambil kata kunci pencarian dari parameter GET
$s = isset($_GET['s']) ? $_GET['s'] : '';
// Hitung jumlah data
$query_count = "SELECT COUNT(*) AS count FROM tbl_pembeli";
if (!empty($s)) {
  $query_count .= " WHERE name LIKE '%$s%'";
}
$result_count = mysqli_query($conn, $query_count);
$count = mysqli_fetch_assoc($result_count)['count'];
// Konfigurasi pagination
$limit = 5;
$total_pages = ceil($count / $limit);
$current_page = isset($_GET['page']) ? max(1, min($_GET['page'], $total_pages)) : 1;
$offset = ($current_page - 1) * $limit;

$query = "SELECT * FROM tbl_pembeli";
if (!empty($s)) {
  $query .= " WHERE name LIKE '%$s%'";
}
$query .= " LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// ambil nomor halaman dari query string
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// validasi nomor halaman
if ($page < 1 || $page > 2) {
    echo "Halaman tidak tersedia";
    exit;
}

// tampilkan isi halaman yang diminta
if ($page == 1) {
    // tampilkan isi halaman 1
    echo "<table>";
    // ...
    echo "</table>";
} else {
    // tampilkan isi halaman 2
    echo "<table>";
    // ...
    echo "</table>";
}

$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Penjualan Lontong Sayur</title>
    <style>
        /* CSS untuk menambahkan beberapa styling ke halaman */
        body {
            font-family : Arial, sans-serif;
            font-size   : 16px;
            line-height : 1.5;
        }
        ul {
            list-style  : none;
            padding     : 0;
            margin      : 0;
        }
        li {
            margin      : 10px 0;
        }
        table {
            margin      : 0 auto;
        }
        .empty-search-result {
    color: red;
    font-weight: bold;
  }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="index.php"><img src="https://e.top4top.io/p_2605xsqmd1.png" width="80"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link active" href="proces/beli.php"><i class="fas fa-shopping-cart"></i> INPUT PEMBELIAN</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="proces/stok.php"><i class="fas fa-plus-circle"></i> TAMBAH STOCK</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="proces/stok.php"><i class="fas fa-chart-line"></i> KEUNTUNGAN</a>
    </li>
</ul>
      </div>
    </nav>
    <div class="container">
        <div class="col-sm-12">
            <center>
                <h2>DATA PENJUALAN LOSAPE</h2>
                <form method="GET">
                  <div class="form-group">
                  <div class="input-group">
                <input type="text" name="s" class="form-control" placeholder="Cari Nama Pembeli" value="<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>">
              <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
          </div>
        </div>
      </div>
     <?php
if (mysqli_num_rows($result) == 0 && !empty($s)) {
  echo "<h4><tr><td colspan='5' class='text-center empty-search-result'>Tidak ada hasil untuk pencarian: <font color='red'><strong>" . $s . "</font></strong></td></tr></h4>";
} ?>
    </form>
                <form method='POST'>    
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Nama Pembeli</th>
                            <th>Jumlah Di Beli</th>
                            <th>Total Di Dapat</th>
                            <th class="text-center">Action</th>
                        </tr>
                        <?php $i = ($current_page - 1) * $limit + 1; ?>
                        <?php while( $row = mysqli_fetch_assoc($result) ): ?>
                        <tr>
                            <td><?= $i ?></td>    
                            <td><?= $row["name"]; ?></td>  
                            <td><?= $row["buying"]; ?></td>
      <td><?= "Rp " . number_format($row["res"], 0, ',', '.') ?></td>
      <td class="text-center">
  <a href="proces/edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
  <a href="proces/hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
</td>
</tr>
    <?php $i++; ?>
  <?php endwhile; ?>
  <tr>
    <td colspan="4"><b>Total Terjual:</b></td>
    <td><?= $total_barang . " ". "" ?></td>
  </tr>
  <tr>
    <td colspan="4"><b>Pendapatan Penjualan Keseluruhan:</b></td>
    <td><?= "Rp " . number_format($total, 0, ',', '.') ?></td>
  </tr>
</table>
<div class="row">
  <div class="col-md-12">
    <nav>
    <ul class="pagination justify-content-center">
  <?php if ($current_page > 1) : ?>
    <li class="page-item">
      <a class="page-link" href="?page=<?= $current_page - 1 ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
  <?php endif; ?>
  <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
    <li class="page-item <?php if ($i == $current_page) echo 'active'; ?>">
      <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
    </li>
  <?php endfor; ?>
  <?php if ($current_page < $total_pages) : ?>
    <li class="page-item">
      <a class="page-link" href="?page=<?= $current_page + 1 ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  <?php endif; ?>
</ul>
    </nav>
  </div>
</div>

  </div>
    <!-- jQuery dan JavaScript Bootstrap -->
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>