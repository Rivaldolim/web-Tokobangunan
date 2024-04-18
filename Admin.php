<?php
require_once "database.php";

session_start();

// Periksa apakah pengguna sudah login dan memiliki peran admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Logika untuk menambah game
if ($_SERVER["REQUEST_METHOD"] == "POST") {
}

   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
    .edit-news-form {
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #f8f9fa;
        padding: 10px;
        z-index: 1000;
        transition: bottom 0.3s ease;
    }

    .edit-news-form.open {
        bottom: 0;
    }
  </style>
    <style>
        /* Gaya tambahan */
        body {
            background-color: #f5f5f5; /* Warna latar belakang yang lebih terang */
            font-family: 'Playfair Display', serif; /* Font elegan */
            color: #444;
        }
        .section-heading {
            color: #333; /* Warna judul yang lebih lembut */
            font-size: 36px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .section-subheading {
            color: #666;
            font-size: 24px;
            font-weight: normal;
        }
        .btn-primary {
            background-color: #ffd700; /* Warna tombol utama yang lebih cerah */
            border-color: #ffd700; /* Warna border tombol */
            color: #333;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #ffdf4f; /* Warna tombol utama saat hover */
            border-color: #ffdf4f; /* Warna border tombol saat hover */
            color: #333;
        }
        .btn-secondary {
            background-color: #333; /* Warna tombol sekunder yang lebih gelap */
            border-color: #333; /* Warna border tombol */
            color: #fff;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #444; /* Warna tombol sekunder saat hover */
            border-color: #444; /* Warna border tombol saat hover */
            color: #fff;
        }
        .portfolio-item {
            border: 1px solid #ddd; /* Border untuk setiap item portofolio */
            border-radius: 10px; /* Rounding border */
            overflow: hidden; /* Mengatasi overflow gambar */
            transition: transform 0.3s ease-in-out; /* Efek transisi saat hover */
        }
        .portfolio-item:hover {
            transform: scale(1.05); /* Efek scaling saat hover */
        }
        .portfolio-link {
            position: relative;
            display: block;
        }
        .portfolio-link .portfolio-hover {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .portfolio-link:hover .portfolio-hover {
            opacity: 1;
        }
        .portfolio-hover-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        .portfolio-hover-content i {
            color: #fff;
            font-size: 36px;
            transition: all 0.3s ease;
        }
        .portfolio-link:hover .portfolio-hover-content i {
            font-size: 48px;
        }
        .portfolio-caption {
            padding: 20px;
            text-align: center;
        }
        .portfolio-caption-heading {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .edit-form input[type="text"],
        .edit-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }
        .edit-form input[type="text"]:focus,
        .edit-form textarea:focus {
            outline: none;
            border-color: #ffd700;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-drark bg-warning">
    <div class="container">
      <a class="navbar-brand" href="#">Alat Bangunan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Katalog Produk</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <!-- Konten halaman -->
    <section class="page-section bg-light mb-2" id="alatbangunan">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase mb-4">Katalog Produk</h2>
                <h3 class="section-subheading text-muted">Semua Produk</h3>
            </div>
            <div class="row">
                <?php
                $data = getAllData();
                foreach ($data as $row) {
                    $id = $row['id_game'];
                    $nama_game = $row['nama_game'];
                    $harga = $row['harga'];
                    $deskripsi = $row['Deskripsi'];
                    $gambar = $row['gambar'];
                ?>
                <div class="col-lg-4 col-sm-6 mb-4">
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal<?php echo $id; ?>">
                            <img class="img-fluid" src="data:image/jpeg;base64,<?php echo base64_encode($gambar); ?>" alt="..." />
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading"><?php echo $nama_game; ?></div>
                            <!-- Button group for deleting and editing -->
                            <div class="btn-group">
                                <form action="hapus.php" method="post">
                                    <input type="hidden" name="game_id" value="<?php echo $id; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                                <button class="btn btn-success btn-sm edit-btn" data-gameid="<?php echo $id; ?>">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Hidden edit form -->
                <div class="col-lg-4 col-sm-6 mb-4 edit-form" id="editForm_<?php echo $id; ?>" style="display:none;">
                    <form action="edit.php" method="post">
                        <input type="hidden" name="game_id" value="<?php echo $id; ?>">
                        <input type="text" name="nama_game" placeholder="Nama Game" value="<?php echo $nama_game; ?>"><br>
                        <input type="text" name="harga" placeholder="Harga" value="<?php echo $harga; ?>"><br>
                        <textarea name="deskripsi" placeholder="Deskripsi"><?php echo $deskripsi; ?></textarea><br>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <!-- Button to close the edit form -->
                        <button type="button" class="btn btn-secondary btn-sm close-btn" data-gameid="<?php echo $id; ?>">Tutup</button>
                    </form>
                </div>
                <?php } ?>
            </div>
            <!-- Tombol Tambah -->
            <div class="text-center mt-4">
                <button class="btn btn-primary add-game-button" id="addGameButton">
                    <i class="fas fa-plus"></i> Tambah Game
                </button>
            </div>
        </div>
    </section>

    <!-- Form Tambah Game -->
    <div class="container add-game-form" id="addGameForm" style="display:none;">
        <form action="tambah.php" method="post" enctype="multipart/form-data">
            <!-- Input untuk data game baru -->
            <div class="mb-3">
                <label for="nama_game" class="form-label">Nama Game</label>
                <input type="text" class="form-control" id="nama_game" name="nama_game">
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga">
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="file" class="form-control" id="gambar" name="gambar">
            </div>
            <!-- Tombol untuk menyimpan data -->
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" id="closeAddForm">Tutup</button>
        </form>
    </div>





 <!-- Skrip JavaScript -->
 <script>
    $(document).ready(function(){
        // Ketika tombol Edit diklik, tampilkan form edit
        $(".edit-news-button").click(function(){
            // Dapatkan id berita dari atribut data-newsid
            var newsId = $(this).data("newsid");

            // Set nilai judul dan isi berita pada form edit
            $("#edit-judul").val($("#judul_" + newsId).text());
            $("#edit-isi-berita").val($("#isi_berita_" + newsId).text());

            // Set nilai id berita pada input hidden
            $("#edit-news-id").val(newsId);

            // Tampilkan form edit
            $(".edit-news-form").addClass("open");
        });

        // Ketika tombol Tutup pada form edit diklik, sembunyikan form edit
        $(".close-edit-news-form").click(function(){
            // Sembunyikan form edit
            $(".edit-news-form").removeClass("open");
        });
    });
</script>
<script>
    // Pastikan dokumen HTML telah dimuat sepenuhnya sebelum menjalankan skrip
    $(document).ready(function(){
        // Ketika tombol Edit diklik, tampilkan form edit yang sesuai
        $(".edit-news-button").click(function(){
            // Dapatkan id berita dari atribut data-newsid
            var newsId = $(this).data("newsid");

            // Tampilkan form edit yang sesuai
            $("#editNewsForm_" + newsId).toggle();
        });

        // Ketika tombol Tutup pada form edit diklik, sembunyikan form edit
        $(".close-edit-news-form").click(function(){
            // Dapatkan id berita dari atribut data-newsid
            var newsId = $(this).data("newsid");

            // Sembunyikan form edit yang sesuai
            $("#editNewsForm_" + newsId).hide();
        });
    });
</script>

</script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            // Tampilkan form tambah game ketika tombol Tambah diklik
            $("#addGameButton").click(function(){
                $("#addGameForm").toggle();
            });

            // Ketika tombol Tutup pada form tambah diklik, sembunyikan form tambah
            $("#closeAddForm").click(function(){
                $("#addGameForm").hide();
            });

            // Ketika tombol Edit diklik, tampilkan form edit yang sesuai
            $(".edit-btn").click(function(){
                var gameId = $(this).data("gameid");
                $("#editForm_" + gameId).toggle();
            });

            // Ketika tombol Tutup pada form edit diklik, sembunyikan form edit
            $(".close-btn").click(function(){
                var gameId = $(this).data("gameid");
                $("#editForm_" + gameId).hide();
            });
        });
    </script>
</body>
</html>
