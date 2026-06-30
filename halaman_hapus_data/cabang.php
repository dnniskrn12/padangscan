<?php

if (isset($_GET['id'])) {
    // Sanitasi input untuk keamanan
    $id = $mysqli->real_escape_string($_GET['id']);
    
    // Menghapus data dari tabel cabang
    if ($mysqli->query("DELETE FROM cabang WHERE id='$id'")) {
        echo "<script>alert('Cabang berhasil dihapus.')</script>";
        echo "<script>window.location.href='?page=" . $_GET['page'] . "';</script>";
    } else {
        echo "Error: " . $mysqli->error; // Tampilkan error jika ada
    }
} else {
    echo "<script>alert('id tidak ditemukan');</script>";
    echo "<script>window.location.href = '?page=" . $_GET['page'] . "';</script>";
}