<?php
session_start();
$host = 'localhost'; $dbname = 'womanpreneur_db'; $username = 'root'; $password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch Products
    $stmt = $pdo->query("SELECT * FROM produk ORDER BY id DESC");
    $produk_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $produk_list = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>MealSync - Kelola Produk</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #FDE4D0; min-height: 100vh; padding: 40px 20px; position: relative; }
        .bg-blobs { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; pointer-events: none; }
        .container { max-width: 1000px; margin: 0 auto; position: relative; z-index: 1; }
        
        .header-bar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px; background: white; padding: 20px 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .header-left { display: flex; align-items: center; gap: 20px; }
        
        .btn-back { background: #f5f5f5; color: #555; padding: 10px 20px; border-radius: 12px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }
        .btn-back:hover { background: #e0e0e0; color: #333; }
        
        .page-title { font-size: 24px; font-weight: 700; color: #222; }

        .btn-add-new { background: #4CAF50; color: white; padding: 12px 25px; border-radius: 12px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 8px 20px rgba(76, 175, 80, 0.3); transition: 0.2s; }
        .btn-add-new:hover { background: #388E3C; transform: translateY(-2px); box-shadow: 0 12px 25px rgba(76, 175, 80, 0.4); }

        .alert-success { background: #d4edda; color: #155724; padding: 15px 20px; border-radius: 12px; margin-bottom: 30px; font-weight: 500; display: flex; align-items: center; gap: 10px; }

        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 25px; }
        .p-card { background: white; border-radius: 20px; padding: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.05); text-align: center; transition: 0.2s; display: flex; flex-direction: column; }
        .p-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(220,150,100,0.2); }
        .p-img { width: 100%; height: 160px; object-fit: cover; border-radius: 15px; margin-bottom: 15px; }
        .p-title { font-size: 18px; font-weight: 700; color: #222; margin-bottom: 5px; }
        .p-price { font-weight: 600; color: #4CAF50; margin-bottom: 15px; font-size: 15px; }
        
        .p-actions { margin-top: auto; display: flex; gap: 10px; }
        .btn-edit { flex: 1; background: #e8f0fe; color: #1a73e8; text-decoration: none; padding: 10px; border-radius: 10px; font-size: 14px; font-weight: 600; transition: 0.2s; text-align: center; }
        .btn-edit:hover { background: #d2e3fc; }
        .btn-delete { flex: 1; background: #ffebee; color: #d32f2f; text-decoration: none; padding: 10px; border-radius: 10px; font-size: 14px; font-weight: 600; transition: 0.2s; text-align: center; }
        .btn-delete:hover { background: #ffcdd2; }

        .empty-state { text-align: center; padding: 60px 20px; background: white; border-radius: 20px; color: #777; }
        
        @media (max-width: 768px) { .header-bar { flex-direction: column; gap: 20px; text-align: center; } }
    </style>
</head>
<body>
    <svg class="bg-blobs" viewBox="0 0 1440 900" preserveAspectRatio="none"><path d="M1440,0 L1440,400 C1200,350 1100,100 900,150 C700,200 600,-50 400,0 Z" fill="#F9C59F" opacity="0.6"/></svg>

    <div class="container">
        
        <div class="header-bar">
            <div class="header-left">
                <a href="dashboard.php" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                <h1 class="page-title">Kelola Produk</h1>
            </div>
            <a href="tambah_produk.php" class="btn-add-new"><i class="fa-solid fa-plus"></i> Tambah Menu Baru</a>
        </div>

        <?php if(isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
            <div class="alert-success">
                <i class="fa-solid fa-circle-check"></i> Produk baru berhasil ditambahkan ke menu!
            </div>
        <?php endif; ?>

        <?php if(empty($produk_list)): ?>
            <div class="empty-state">
                <i class="fa-solid fa-box-open" style="font-size: 50px; color: #ccc; margin-bottom: 15px;"></i>
                <h2>Belum ada produk</h2>
                <p>Klik tombol "Tambah Menu Baru" di atas untuk mulai memasukkan makanan ke tokomu.</p>
            </div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach($produk_list as $p): ?>
                <div class="p-card">
                    <img src="<?php echo htmlspecialchars($p['foto']); ?>" class="p-img" alt="<?php echo htmlspecialchars($p['nama_produk']); ?>">
                    <div class="p-title"><?php echo htmlspecialchars($p['nama_produk']); ?></div>
                    <div class="p-price">Rp <?php echo number_format($p['harga'], 0, ',', '.'); ?></div>
                    
                    <div class="p-actions">
                        <a href="edit_produk.php?id=<?php echo $p['id']; ?>" class="btn-edit">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                        <a href="hapus_produk.php?id=<?php echo $p['id']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus <?php echo htmlspecialchars($p['nama_produk']); ?>?');">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>