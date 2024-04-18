<?php
require_once "database.php";

// Pastikan form telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Terima data dari form
    $game_id = $_POST["game_id"];
    $nama_game = $_POST["nama_game"];
    $harga = $_POST["harga"];
    $deskripsi = $_POST["deskripsi"];

    // Validasi input
    if (empty($game_id) || empty($nama_game) || empty($harga) || empty($deskripsi)) {
        echo "<script>alert('Semua bidang harus diisi.');</script>";
        echo "<script>window.location.href = 'admin.php';</script>";
    } else {
        // Lakukan koneksi ke database
        $conn = connectDB();

        // Persiapkan query SQL UPDATE
        $sql = "UPDATE game SET nama_game=?, harga=?, Deskripsi=? WHERE id_game=?";
        $stmt = $conn->prepare($sql);

        // Bind parameter ke query
        $stmt->bind_param("sdsi", $nama_game, $harga, $deskripsi, $game_id);

        // Jalankan query
        if ($stmt->execute()) {
            echo "<script>alert('Data game berhasil diubah.');</script>";
            echo "<script>window.location.href = 'admin.php';</script>";
        } else {
            echo "<script>alert('Gagal mengubah data game: " . $stmt->error . "');</script>";
            echo "<script>window.location.href = 'admin.php';</script>";
        }

        // Tutup statement dan koneksi database
        $stmt->close();
        $conn->close();
    }
}
?>
