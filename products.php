<?php
require 'includes/auth_check.php'; // WAJIB!
require 'config/database.php';
require 'includes/header.php';

// --- Logika untuk Fitur EDIT ---
$is_editing = false;
$edit_product = [
    'id' => '',
    'sku' => '',
    'product_name' => '',
    'quantity' => '',
    'price' => '',
    'description' => ''
];

if (isset($_GET['edit_id'])) {
    $is_editing = true;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['edit_id']]);
    $edit_product = $stmt->fetch();
    
    if (!$edit_product) {
        // Jika ID tidak ditemukan, kembalikan ke mode "Tambah"
        $is_editing = false; 
    }
}
// --- Selesai Logika Edit ---
?>

<h2><?php echo $is_editing ? 'Edit Produk' : 'Tambah Produk Baru'; ?></h2>

<form action="actions/handle_products.php" method="POST">
    
    <?php if ($is_editing): ?>
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?php echo $edit_product['id']; ?>">
    <?php else: ?>
        <input type="hidden" name="action" value="create">
    <?php endif; ?>

    <div class="form-group">
        <label for="sku">SKU (Kode Unik Produk)</label>
        <input type="text" id="sku" name="sku" value="<?php echo htmlspecialchars($edit_product['sku']); ?>" required>
    </div>
    <div class="form-group">
        <label for="product_name">Nama Produk</label>
        <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($edit_product['product_name']); ?>" required>
    </div>
    <div class="form-group">
        <label for="quantity">Kuantitas</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($edit_product['quantity']); ?>" required>
    </div>
    <div class="form-group">
        <label for="price">Harga</label>
        <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($edit_product['price']); ?>" required>
    </div>
    <div class="form-group">
        <label for="description">Deskripsi</label>
        <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($edit_product['description']); ?></textarea>
    </div>
    
    <button type="submit" class="btn">
        <?php echo $is_editing ? 'Update Produk' : 'Simpan Produk Baru'; ?>
    </button>
    <?php if ($is_editing): ?>
        <a href="products.php" style="margin-left: 10px;">Batal Edit</a>
    <?php endif; ?>
</form>

<hr style="margin: 30px 0;">

<h2>Daftar Produk di Gudang</h2>

<table>
    <thead>
        <tr>
            <th>SKU</th>
            <th>Nama Produk</th>
            <th>Kuantitas</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Ambil semua data produk
        $stmt = $pdo->query("SELECT * FROM products ORDER BY product_name ASC");
        
        while ($product = $stmt->fetch()):
        ?>
            <tr>
                <td><?php echo htmlspecialchars($product['sku']); ?></td>
                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                <td>Rp <?php echo number_format($product['price'], 2, ',', '.'); ?></td>
                <td>
                    <a href="products.php?edit_id=<?php echo $product['id']; ?>" style="margin-right: 5px;">Edit</a>
                    
                    <form action="actions/handle_products.php" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        <button type="submit" style="color:red; background:none; border:none; padding:0; cursor:pointer;">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        
        <?php if ($stmt->rowCount() == 0): ?>
            <tr>
                <td colspan="5" style="text-align: center;">Belum ada data produk.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require 'includes/footer.php'; ?>