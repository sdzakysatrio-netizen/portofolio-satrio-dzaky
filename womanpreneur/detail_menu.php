<?php
// ==========================================
// DATABASE FETCH LOGIC
// ==========================================
$host = 'localhost';
$dbname = 'womanpreneur_db';
$username = 'root';
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the product ID from the URL (e.g., detail_menu.php?id=1)
    $product_id = isset($_GET['id']) ? $_GET['id'] : 0;

    // Fetch the specific product
    $stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
    $stmt->execute([$product_id]);
    $produk = $stmt->fetch(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MealSync - Detail Menu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #FDE4D0; min-height: 100vh; position: relative; display: flex; flex-direction: column; }
        
        .bg-blobs { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; pointer-events: none; }

        /* =========================================
           TOP NAVIGATION BAR (Same as menu_pembeli)
           ========================================= */
        .navbar {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-brand { display: flex; align-items: center; gap: 15px; text-decoration: none; color: #333; }
        .nav-brand h2 { font-size: 24px; font-weight: 700; }
        .nav-logo-wrapper { width: 50px; height: 50px; }

        .nav-links { display: flex; gap: 35px; align-items: center; }
        .nav-link { color: #666; text-decoration: none; font-size: 22px; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { color: #8D6E63; transform: scale(1.1); }

        /* =========================================
           MAIN CONTENT (Detail Card)
           ========================================= */
        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .detail-card {
            background-color: #FFFFFF;
            width: 100%;
            max-width: 1000px; /* Perfect width for a side-by-side card */
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
            display: grid;
            grid-template-columns: 1fr 1fr; /* 50% Image, 50% Text */
            overflow: hidden; /* Keeps image inside rounded corners */
        }

        /* Left Side: Product Image */
        .detail-img-container {
            width: 100%;
            height: 100%;
            min-height: 400px;
            background-color: #f5f5f5;
        }
        
        .detail-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Right Side: Product Information */
        .detail-info {
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #777;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 25px;
            transition: color 0.2s;
            width: fit-content;
        }
        .btn-back:hover { color: #333; }

        .detail-title { font-size: 36px; font-weight: 700; color: #222; margin-bottom: 10px; line-height: 1.2; }
        
        .stars { color: #FFD700; font-size: 18px; margin-bottom: 20px; letter-spacing: 3px; }

        .detail-price { font-size: 28px; font-weight: 700; color: #4CAF50; margin-bottom: 25px; }

        .detail-desc {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 40px;
            text-align: justify;
        }

        .btn-add {
            background-color: #4CAF50;
            color: white;
            border: none;
            width: 100%;
            padding: 18px;
            border-radius: 14px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(76, 175, 80, 0.3);
            transition: all 0.2s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        .btn-add:hover { background-color: #45a049; transform: translateY(-3px); box-shadow: 0 15px 30px rgba(76, 175, 80, 0.4); }

        /* Responsive Breakpoint for Smaller Screens */
        @media (max-width: 800px) {
            .detail-card { grid-template-columns: 1fr; /* Stacks image on top of text */ }
            .detail-img-container { min-height: 300px; }
            .detail-info { padding: 30px 25px; }
        }
    </style>
</head>
<body>

    <svg class="bg-blobs" viewBox="0 0 1440 900" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M1440,0 L1440,400 C1200,350 1100,100 900,150 C700,200 600,-50 400,0 Z" fill="#F9C59F" opacity="0.6"/>
        <path d="M-50,800 C150,850 300,600 500,650 C700,700 850,950 1000,900 C1200,850 1300,1000 1500,900 L1500,1000 L-50,1000 Z" fill="#F9C59F" opacity="0.5"/>
    </svg>

    <nav class="navbar">
        <a href="menu_pembeli.php" class="nav-brand">
            <div class="nav-logo-wrapper">
                <div class="logo-circle" style="overflow: hidden; padding: 0;">
                    <img src="logo.png" alt="MealSync Logo" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
            <h2>MealSync</h2>
        </a>
        
        <div class="nav-links">
            <a href="menu_pembeli.php" class="nav-link active" title="Beranda"><i class="fa-solid fa-house"></i></a> 
            <a href="#" class="nav-link" title="Favorit"><i class="fa-regular fa-heart"></i></a>
            <a href="riwayat_pesanan.php" class="nav-link" title="Riwayat Pesanan"><i class="fa-solid fa-receipt"></i></a>
            <a href="#" class="nav-link" title="Profil"><i class="fa-regular fa-user"></i></a>
        </div>
    </nav>

    <div class="main-container">
        
        <div class="detail-card">
            
            <div class="detail-img-container">
                <img src="<?php echo htmlspecialchars($produk['foto']); ?>" alt="<?php echo htmlspecialchars($produk['nama_produk']); ?>" class="detail-img">
            </div>

            <div class="detail-info">
                <a href="menu_pembeli.php" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Menu
                </a>

                <h1 class="detail-title"><?php echo htmlspecialchars($produk['nama_produk']); ?></h1>
                
                <div class="stars">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>

                <div class="detail-price">
                    Rp. <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
                </div>

                <p class="detail-desc">
                    <?php echo nl2br(htmlspecialchars($produk['deskripsi'])); ?>
                </p>

                <button class="btn-add" onclick="alert('<?php echo htmlspecialchars($produk['nama_produk']); ?> berhasil ditambahkan ke keranjang!'); window.location.href='add_to_cart.php?id=<?php echo $produk['id']; ?>&redirect=menu_pembeli.php';">
                    <i class="fa-solid fa-cart-plus"></i> Tambah ke Keranjang
                </button>
            </div>

        </div>

    </div>

</body>
</html>