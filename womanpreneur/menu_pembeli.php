<?php
session_start(); // Must be the very first line!

// Initialize favorites session if it doesn't exist yet
if (!isset($_SESSION['favorites'])) {
    $_SESSION['favorites'] = [];
}

// ==========================================
// DATABASE FETCH LOGIC (MariaDB)
// ==========================================
$host = 'localhost';
$dbname = 'womanpreneur_db';
$username = 'root';
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM produk ORDER BY id DESC");
    $produk_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $produk_list = []; 
}

// ==========================================
// CART MATH LOGIC
// ==========================================
$total_items = 0;
$total_price = 0;
$latest_item_name = "Keranjang";

if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach($_SESSION['cart'] as $item) {
        $total_items += $item['qty'];
        $total_price += ($item['harga'] * $item['qty']);
        $latest_item_name = $item['nama']; 
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MealSync - Menu Makanan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #FDE4D0; min-height: 100vh; position: relative; padding-bottom: 100px; }
        
        .bg-blobs { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; pointer-events: none; }

        /* --- Navbar --- */
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

        /* --- Main Content --- */
        .main-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .page-title { font-size: 40px; font-weight: 700; color: #FFFFFF; text-shadow: 0 2px 10px rgba(0,0,0,0.15); margin-bottom: 30px; }

        /* --- Controls --- */
        .controls-section { display: flex; flex-direction: column; gap: 20px; margin-bottom: 40px; }
        .search-bar { background-color: #FFFFFF; border-radius: 20px; padding: 15px 25px; display: flex; align-items: center; box-shadow: 0 8px 20px rgba(0,0,0,0.05); width: 100%; max-width: 600px; }
        .search-bar i { color: #999; font-size: 18px; } 
        .search-bar input { border: none; outline: none; width: 100%; font-size: 16px; margin-left: 15px; color: #333; }
        .filter-pills { display: flex; gap: 15px; align-items: center; }
        .pill { background-color: #FFFFFF; color: #777; padding: 10px 25px; border-radius: 20px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: all 0.2s; border: none; font-size: 15px; }
        .pill.active { background-color: #8D6E63; color: #FFFFFF; }
        .pill:hover:not(.active) { background-color: #f0f0f0; }

        /* --- Product Grid --- */
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; }

        .product-card {
            background-color: #FFFFFF;
            border-radius: 24px;
            padding: 15px;
            box-shadow: 0 10px 20px rgba(220, 150, 100, 0.2);
            transition: transform 0.2s;
            display: flex;
            flex-direction: column;
            position: relative; /* Essential for placing the heart over the image! */
        }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(220, 150, 100, 0.3); }

        /* --- Floating Favorite Button --- */
        .btn-favorite {
            position: absolute;
            top: 25px;
            right: 25px;
            background-color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            text-decoration: none;
            z-index: 10;
            transition: transform 0.2s;
            font-size: 16px;
        }
        .btn-favorite:hover { transform: scale(1.1); }

        .product-link { text-decoration: none; color: inherit; flex-grow: 1; display: flex; flex-direction: column; }
        .product-img { width: 100%; height: 200px; object-fit: cover; border-radius: 16px; margin-bottom: 15px; }
        .product-info h3 { font-size: 20px; font-weight: 700; color: #222; margin-bottom: 5px; }
        .product-info .stars { color: #FFD700; font-size: 14px; margin-bottom: 10px; letter-spacing: 2px; }
        
        .product-bottom { display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 10px; }
        .product-price { font-size: 16px; font-weight: 600; color: #555; }
        
        .btn-add { background-color: #4CAF50; color: white; text-decoration: none; padding: 8px 20px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: background-color 0.2s; text-align: center; }
        .btn-add:hover { background-color: #45a049; }

        /* --- Floating Cart --- */
        .floating-cart { position: fixed; bottom: 30px; right: 40px; background-color: #4CAF50; color: white; padding: 15px 25px; border-radius: 16px; display: flex; align-items: center; justify-content: space-between; gap: 30px; box-shadow: 0 10px 30px rgba(76, 175, 80, 0.4); z-index: 1000; cursor: pointer; transition: transform 0.2s; text-decoration: none; }
        .floating-cart:hover { transform: scale(1.02); }
        .cart-left { display: flex; flex-direction: column; }
        .cart-qty { font-weight: 700; font-size: 18px; }
        .cart-desc { font-size: 13px; opacity: 0.9; }
        .cart-right { font-weight: 700; font-size: 18px; }

        @media (max-width: 768px) { .navbar { padding: 15px 20px; } .floating-cart { bottom: 20px; right: 20px; left: 20px; justify-content: space-between; } }
    </style>
</head>
<body>

    <svg class="bg-blobs" viewBox="0 0 1440 900" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,0 L1440,0 L1440,300 C1100,400 900,100 600,200 C300,300 100,100 0,200 Z" fill="#F9C59F" opacity="0.8"/>
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
            <a href="favorit.php" class="nav-link" title="Favorit"><i class="fa-regular fa-heart"></i></a>
            <a href="riwayat_pesanan.php" class="nav-link" title="Keranjang & Riwayat"><i class="fa-solid fa-receipt"></i></a>
            <a href="profil.php" class="nav-link" title="Profil"><i class="fa-regular fa-user"></i></a>
        </div>
    </nav>

    <div class="main-container">
        
        <h1 class="page-title">Cari Lauk untuk<br>Makananmu!</h1>

        <div class="controls-section">
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Cari Lauk...">
            </div>
            
            <div class="filter-pills">
                <button class="pill active">Semua</button>
                <button class="pill">Makanan</button>
                <button class="pill">Minuman</button>
                <span style="margin-left:auto; font-size:12px; color:#555; cursor:pointer;">
                    Urut Berdasarkan <i class="fa-solid fa-chevron-down" style="margin-left: 5px;"></i>
                </span>
            </div>
        </div>

        <div class="product-grid">
            
            <?php if(empty($produk_list)): ?>
                <div class="product-card">
                    <a href="#" class="btn-favorite" style="color: #ccc;"><i class="fa-regular fa-heart"></i></a>
                    <a href="#" class="product-link">
                        <img src="https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&w=500&q=60" class="product-img" alt="Nasi Goreng">
                        <div class="product-info">
                            <h3>Nasi Goreng</h3>
                            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i></div>
                        </div>
                    </a>
                    <div class="product-bottom">
                        <span class="product-price">Rp. 22.000</span>
                        <a href="#" class="btn-add">Tambah</a>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach($produk_list as $produk): ?>
                
                <?php 
                // Check if this specific item ID is in the user's favorites session
                $is_favorite = in_array($produk['id'], $_SESSION['favorites']);
                // Set the color and icon style based on if it's favorited or not
                $heart_color = $is_favorite ? '#D32F2F' : '#ccc';
                $heart_icon = $is_favorite ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
                ?>

                <div class="product-card">
                    
                    <a href="toggle_favorit.php?id=<?php echo $produk['id']; ?>&redirect=menu_pembeli.php" class="btn-favorite" style="color: <?php echo $heart_color; ?>;">
                        <i class="<?php echo $heart_icon; ?>"></i>
                    </a>

                    <a href="detail_menu.php?id=<?php echo $produk['id']; ?>" class="product-link">
                        <img src="<?php echo htmlspecialchars($produk['foto']); ?>" class="product-img" alt="<?php echo htmlspecialchars($produk['nama_produk']); ?>">
                        <div class="product-info">
                            <h3><?php echo htmlspecialchars($produk['nama_produk']); ?></h3>
                            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                    </a>
                    <div class="product-bottom">
                        <span class="product-price">Rp. <?php echo number_format($produk['harga'], 0, ',', '.'); ?></span>
                        <a href="add_to_cart.php?id=<?php echo $produk['id']; ?>&redirect=menu_pembeli.php" class="btn-add">Tambah</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>

    <?php if($total_items > 0): ?>
    <a href="riwayat_pesanan.php" class="floating-cart">
        <div class="cart-left">
            <span class="cart-qty"><?php echo $total_items; ?> Item</span>
            <span class="cart-desc"><?php echo htmlspecialchars($latest_item_name); ?></span>
        </div>
        <div class="cart-right">
            Rp. <?php echo number_format($total_price, 0, ',', '.'); ?> <i class="fa-solid fa-arrow-right" style="margin-left: 10px;"></i>
        </div>
    </a>
    <?php endif; ?>

</body>
</html>