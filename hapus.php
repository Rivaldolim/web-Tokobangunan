<?php
require_once "database.php";

// Pastikan form telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Terima ID game dari form
    $game_id = $_POST["game_id"];

    // Validasi input
    if (empty($game_id)) {
        echo "<script>alert('ID game tidak boleh kosong.');</script>";
        echo "<script>window.location.href = 'admin.php';</script>";
    } else {
        // Lakukan koneksi ke database
        $conn = connectDB();

        // Persiapkan query SQL DELETE
        $sql = "DELETE FROM game WHERE id_game=?";
        $stmt = $conn->prepare($sql);

        // Bind parameter ke query
        $stmt->bind_param("i", $game_id);

        // Jalankan query
        if ($stmt->execute()) {
            echo "<script>alert('Data game berhasil dihapus.');</script>";
            echo "<script>window.location.href = 'admin.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data game: " . $stmt->error . "');</script>";
            echo "<script>window.location.href = 'admin.php';</script>";
        }

        // Tutup statement dan koneksi database
        $stmt->close();
        $conn->close();
    }
}
?>
