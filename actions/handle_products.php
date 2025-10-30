<?php
// actions/handle_products.php

require '../includes/auth_check.php'; // WAJIB!
require '../config/database.php';

$action = $_POST['action'] ?? null;

try {
    if ($action == 'create') {
        // --- LOGIKA CREATE ---
        $sku = trim($_POST['sku']);
        $product_name = trim($_POST['product_name']);
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $description = trim($_POST['description']);

        // Validasi sederhana (Anda bisa tambahkan validasi lebih ketat)
        if (empty($sku) || empty($product_name) || !is_numeric($quantity) || !is_numeric($price)) {
            throw new Exception("Data tidak valid. SKU, Nama, Kuantitas, dan Harga wajib diisi.");
        }
        
        // Cek SKU unik (jika perlu, tapi database sudah handle)
        // Kita bisa tambahkan cek di sini agar pesannya lebih ramah
        $stmt = $pdo->prepare("SELECT id FROM products WHERE sku = ?");
        $stmt->execute([$sku]);
        if ($stmt->fetch()) {
             throw new Exception("SKU '$sku' sudah digunakan. Gunakan SKU lain.");
        }

        // Masukkan data
        $stmt = $pdo->prepare(
            "INSERT INTO products (sku, product_name, quantity, price, description) 
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$sku, $product_name, $quantity, $price, $description]);
        
        $_SESSION['success_msg'] = "Produk baru berhasil ditambahkan.";

    } elseif ($action == 'update') {
        // --- LOGIKA UPDATE ---
        $id = $_POST['id'];
        $sku = trim($_POST['sku']);
        $product_name = trim($_POST['product_name']);
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $description = trim($_POST['description']);

        if (empty($id) || empty($sku) || empty($product_name) || !is_numeric($quantity) || !is_numeric($price)) {
            throw new Exception("Data tidak valid. Semua field wajib diisi.");
        }
        
        // Cek SKU unik (pastikan tidak dipakai oleh produk LAIN)
        $stmt = $pdo->prepare("SELECT id FROM products WHERE sku = ? AND id != ?");
        $stmt->execute([$sku, $id]);
        if ($stmt->fetch()) {
             throw new Exception("SKU '$sku' sudah digunakan oleh produk lain.");
        }

        // Update data
        $stmt = $pdo->prepare(
            "UPDATE products 
             SET sku = ?, product_name = ?, quantity = ?, price = ?, description = ?
             WHERE id = ?"
        );
        $stmt->execute([$sku, $product_name, $quantity, $price, $description, $id]);
        
        $_SESSION['success_msg'] = "Produk berhasil diperbarui.";

    } elseif ($action == 'delete') {
        // --- LOGIKA DELETE ---
        $id = $_POST['id'];

        if (empty($id)) {
            throw new Exception("ID produk tidak ditemukan.");
        }

        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
        
        $_SESSION['success_msg'] = "Produk telah berhasil dihapus.";
    }

} catch (Exception $e) {
    // Tangkap semua error (termasuk error duplikat SKU dari database)
    $_SESSION['error_msg'] = "Terjadi Kesalahan: " . $e->getMessage();
}

// Setelah selesai, kembalikan pengguna ke halaman produk
header("Location: ../products.php");
exit();
?>