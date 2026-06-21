<?php
session_start();

// ==========================================
// DATABASE FETCH LOGIC (For Quick Stats)
// ==========================================
$host = 'localhost';
$dbname = 'womanpreneur_db';
$username = 'root';
$password = ''; 

$total_produk = 0;
$today_revenue = 0;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Count how many products are currently in the database
    $stmt = $pdo->query("SELECT COUNT(*) FROM produk");
    $total_produk = $stmt->fetchColumn();

    // Calculate today's revenue (Pemasukan) from the ledger
    $today = date('Y-m-d');
    $stmt_today = $pdo->prepare("SELECT * FROM kas_harian WHERE tanggal = ?");
    $stmt_today->execute([$today]);
    $today_records = $stmt_today->fetchAll(PDO::FETCH_ASSOC);

    foreach ($today_records as $row) {
        $subtotal = $row['jumlah'] * $row['harga'];
        $nama = strtolower($row['nama_barang']);
        
        $is_pengeluaran = false;
        if (strpos($nama, 'belanja') !== false || 
            strpos($nama, 'bayar') !== false || 
            strpos($nama, 'beli') !== false || 
            strpos($nama, 'sewa') !== false || 
            strpos($nama, 'listrik') !== false || 
            strpos($nama, 'air') !== false || 
            strpos($nama, 'gaji') !== false || 
            strpos($nama, 'pengeluaran') !== false ||
            $row['harga'] < 0 ||
            $row['jumlah'] < 0) {
            $is_pengeluaran = true;
        }

        if (!$is_pengeluaran) {
            $today_revenue += abs($subtotal);
        }
    }

} catch(PDOException $e) {
    // If DB fails, just leave it at 0
    $total_produk = 0;
    $today_revenue = 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MealSync - Dashboard Owner</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #FDE4D0; min-height: 100vh; position: relative; padding: 40px 20px; }
        
        .bg-blobs { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; pointer-events: none; }

        .dashboard-wrapper { max-width: 1000px; margin: 0 auto; z-index: 1; position: relative; }

        /* --- Header Section --- */
        .dashboard-header {
            background-color: #FFFFFF;
            border-radius: 24px;
            padding: 30px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .header-left { display: flex; align-items: center; gap: 20px; }
        
        /* Adjusted logo size for the header */
        .logo-circle {
            width: 80px; height: 80px; background-color: white; border-radius: 50%; 
            display: flex; justify-content: center; align-items: center; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); border: 3px solid #F9C59F;
        }

        .welcome-text h1 { font-size: 24px; font-weight: 700; color: #222; margin-bottom: 5px; }
        .welcome-text p { font-size: 14px; color: #666; }

        .btn-logout {
            background-color: #ffebee;
            color: #d32f2f;
            padding: 12px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-logout:hover { background-color: #ffcdd2; transform: translateY(-2px); }

        /* --- Quick Stats Section --- */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        
        .stat-card {
            background: linear-gradient(135deg, #8D6E63 0%, #5D4037 100%);
            color: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(93, 64, 55, 0.2);
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .stat-card.green { background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%); box-shadow: 0 10px 20px rgba(76, 175, 80, 0.2); }

        .stat-icon { font-size: 40px; opacity: 0.8; }
        .stat-info h3 { font-size: 28px; font-weight: 700; margin-bottom: 2px; }
        .stat-info p { font-size: 13px; opacity: 0.9; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }

        /* --- Main Menu Grid --- */
        .menu-title { font-size: 22px; font-weight: 700; color: #222; margin-bottom: 20px; margin-top: 10px; }

        .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 25px; }

        .menu-card {
            background-color: #FFFFFF;
            border-radius: 20px;
            padding: 40px 20px;
            text-align: center;
            text-decoration: none;
            color: #333;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            border: 2px solid transparent;
        }
        
        .menu-card:hover { transform: translateY(-10px); box-shadow: 0 15px 35px rgba(220, 150, 100, 0.3); border-color: #F9C59F; }
        
        .menu-icon { width: 70px; height: 70px; border-radius: 50%; background-color: #F9C59F; display: flex; justify-content: center; align-items: center; font-size: 30px; color: #5D4037; transition: all 0.3s; }
        .menu-card:hover .menu-icon { background-color: #8D6E63; color: white; transform: scale(1.1); }

        .menu-card h3 { font-size: 18px; font-weight: 700; }
        .menu-card p { font-size: 13px; color: #777; line-height: 1.4; padding: 0 10px; }

        @media (max-width: 768px) {
            .dashboard-header { flex-direction: column; text-align: center; gap: 20px; }
            .header-left { flex-direction: column; }
            .btn-logout { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

    <svg class="bg-blobs" viewBox="0 0 1440 900" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M-50,-50 C150,100 350,-50 500,150 C650,350 850,200 1000,400 C1150,600 1350,450 1500,650 L1500,-50 Z" fill="#F9C59F" opacity="0.6"/>
        <path d="M-50,950 L500,950 C450,700 250,850 100,650 C-50,450 -100,600 -50,950 Z" fill="#F9C59F" opacity="0.7"/>
    </svg>

    <div class="dashboard-wrapper">
        
        <div class="dashboard-header">
            <div class="header-left">
                <div class="logo-circle" style="overflow: hidden; padding: 0;">
                    <img src="logo.png" alt="MealSync Logo" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="welcome-text">
                    <h1>Halo, Owner UMKM! &#128075;</h1>
                    <p>Siap mengelola bisnismu hari ini?</p>
                </div>
            </div>
            
            <a href="index.php" class="btn-logout">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar
            </a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <i class="fa-solid fa-box-open stat-icon"></i>
                <div class="stat-info">
                    <h3><?php echo $total_produk; ?></h3>
                    <p>Total Produk</p>
                </div>
            </div>
            <div class="stat-card green">
                <i class="fa-solid fa-chart-line stat-icon"></i>
                <div class="stat-info">
                    <h3>Rp <?php echo number_format($today_revenue, 0, ',', '.'); ?></h3>
                    <p>Pendapatan Hari Ini</p>
                </div>
            </div>
        </div>

        <h2 class="menu-title">Menu Utama</h2>

        <div class="menu-grid">
            
            <a href="kas_harian.php" class="menu-card">
                <div class="menu-icon"><i class="fa-solid fa-book-open"></i></div>
                <h3>Catat Kas Harian</h3>
                <p>Input pemasukan dan pengeluaran harian usahamu.</p>
            </a>

            <a href="laporan.php" class="menu-card">
                <div class="menu-icon"><i class="fa-solid fa-chart-pie"></i></div>
                <h3>Laporan</h3>
                <p>Lihat grafik dan ringkasan keuangan UMKM kamu.</p>
            </a>

            <a href="kelola_produk.php" class="menu-card">
                <div class="menu-icon"><i class="fa-solid fa-burger"></i></div>
                <h3>Kelola Produk</h3>
                <p>Tambah, edit, atau hapus menu makanan yang dijual.</p>
            </a>

            <a href="tentang.php" class="menu-card">
                <div class="menu-icon"><i class="fa-solid fa-circle-info"></i></div>
                <h3>Tentang Kami</h3>
                <p>Informasi aplikasi dan visi misi MealSync.</p>
            </a>

        </div>

    </div>

</body>
</html>