<?php

function connectDB() {
    $servername = "localhost";
    $username = "id22052619_adlo";
    $password = "Aldo123@";
    $dbname = "id22052619_data_bangunan";

    // Membuat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Mendapatkan semua data game
function getAllData() {
    $conn = connectDB();
    $sql = "SELECT * FROM game";
    $result = $conn->query($sql);

    $data = array();
    // Periksa apakah ada data yang ditemukan
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $conn->close();

    return $data;
}

// Mendapatkan semua berita
function getAllNews() {
    $conn = connectDB();
    $sql = "SELECT * FROM berita";
    $result = $conn->query($sql);

    $data = array();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $conn->close();
    return $data;
}

// Fungsi untuk menghapus berita
function deleteNews($idnews) {
    if (empty($idnews)) {
        return "ID berita tidak boleh kosong.";
    }

    $conn = connectDB();
    $query = "DELETE FROM berita WHERE idnews = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idnews);
    if (!$stmt->execute()) {
        return "Gagal menghapus berita: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    return "Berita berhasil dihapus.";
}
