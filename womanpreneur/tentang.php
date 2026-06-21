<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>MealSync - Tentang Kami</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #FDE4D0; min-height: 100vh; padding: 40px 20px; position: relative; }
        .bg-blobs { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; pointer-events: none; }
        .container { max-width: 800px; margin: 0 auto; position: relative; z-index: 1; text-align: center; }
        
        .btn-back { background: white; color: #555; padding: 10px 20px; border-radius: 12px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); position: absolute; left: 0; top: 0; transition: 0.2s; }
        .btn-back:hover { color: #8D6E63; transform: translateY(-2px); }

        .logo-circle { width: 150px; height: 150px; background-color: white; border-radius: 50%; display: flex; justify-content: center; align-items: center; box-shadow: 0 15px 30px rgba(0,0,0,0.1); margin: 60px auto 20px auto; overflow: hidden; padding: 0; border: 4px solid #F9C59F; }
        
        h1 { font-size: 36px; color: #222; margin-bottom: 10px; }
        .subtitle { font-size: 16px; color: #666; margin-bottom: 40px; }

        .content-card { background: white; padding: 40px; border-radius: 24px; box-shadow: 0 20px 50px rgba(0,0,0,0.05); text-align: left; line-height: 1.8; color: #444; margin-bottom: 20px; }
        .content-card h3 { color: #8D6E63; margin-bottom: 15px; font-size: 20px; display: flex; align-items: center; gap: 10px; }
        
        .footer-text { margin-top: 30px; font-size: 14px; color: #888; }
    </style>
</head>
<body>
    <svg class="bg-blobs" viewBox="0 0 1440 900" preserveAspectRatio="none"><path d="M-50,800 C150,850 300,600 500,650 C700,700 850,950 1000,900 C1200,850 1300,1000 1500,900 L1500,1000 L-50,1000 Z" fill="#F9C59F" opacity="0.5"/></svg>

    <div class="container">
        <a href="dashboard.php" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Dashboard</a>

        <div class="logo-circle">
            <img src="logo.png" alt="MealSync Logo" style="width: 100%; height: 100%; object-fit: cover;">
        </div>

        <h1>MealSync</h1>
        <p class="subtitle">Pesan langsung dari ponselmu, lebih cepat dan praktis.</p>

        <div class="content-card">
            <h3><i class="fa-solid fa-bullseye"></i> Visi & Misi</h3>
            <p style="margin-bottom: 20px;">MealSync hadir sebagai platform digital yang dirancang khusus untuk memberdayakan UMKM yang dikelola oleh perempuan. Kami percaya bahwa teknologi dapat menjembatani kualitas masakan rumahan dengan jangkauan pelanggan yang lebih luas.</p>
            
            <h3><i class="fa-solid fa-hand-holding-heart"></i> Kenapa Memilih Kami?</h3>
            <p>Aplikasi ini mempermudah proses pemesanan bagi pelanggan, sekaligus memberikan alat pencatatan yang rapi bagi pemilik usaha. Mulai dari manajemen stok, laporan penjualan, hingga integrasi pembayaran modern seperti QRIS.</p>
        </div>

        <div class="footer-text">
            &copy; 2026 MealSync App. Dibuat dengan <i class="fa-solid fa-heart" style="color: #D32F2F;"></i> untuk UMKM Indonesia.
        </div>
    </div>
</body>
</html>