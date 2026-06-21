<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MealSync - Profil Saya</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #FDE4D0; min-height: 100vh; position: relative; padding-bottom: 50px; }
        
        .bg-blobs { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; pointer-events: none; }

        /* --- Navbar --- */
        .navbar { background-color: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 100; }
        .nav-brand { display: flex; align-items: center; gap: 15px; text-decoration: none; color: #333; }
        .nav-brand h2 { font-size: 24px; font-weight: 700; }
        .nav-logo-wrapper { width: 50px; height: 50px; }
        .nav-links { display: flex; gap: 35px; align-items: center; }
        .nav-link { color: #666; text-decoration: none; font-size: 22px; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { color: #8D6E63; transform: scale(1.1); }

        /* --- Profile Layout --- */
        .main-container { max-width: 600px; margin: 60px auto; padding: 0 20px; }
        .profile-card { background-color: #FFFFFF; border-radius: 24px; padding: 40px; box-shadow: 0 20px 50px rgba(0,0,0,0.05); text-align: center; }
        
        /* CHANGED: Avatar is now set up perfectly for a real image */
        .avatar { 
            width: 140px; /* Made it slightly bigger so the photo pops! */
            height: 140px; 
            background-color: #f0f0f0; 
            border-radius: 50%; 
            margin: 0 auto 20px auto; 
            box-shadow: 0 10px 25px rgba(220, 150, 100, 0.4); 
            overflow: hidden; /* This makes sure the square image is cut into a circle */
            border: 4px solid #FFFFFF;
        }

        .profile-name { font-size: 28px; font-weight: 700; color: #111; margin-bottom: 5px; }
        .profile-email { font-size: 16px; color: #666; margin-bottom: 30px; }

        .info-row { display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #eee; text-align: left; }
        .info-row:last-child { border-bottom: none; margin-bottom: 30px; }
        .info-label { font-weight: 600; color: #555; }
        .info-value { color: #111; font-weight: 500; }

        .btn-logout { background-color: #D32F2F; color: white; border: none; width: 100%; padding: 15px; border-radius: 12px; font-size: 18px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; box-shadow: 0 8px 20px rgba(211, 47, 47, 0.3); transition: all 0.2s; }
        .btn-logout:hover { background-color: #B71C1C; transform: translateY(-2px); box-shadow: 0 12px 25px rgba(211, 47, 47, 0.4); }
    </style>
</head>
<body>

    <svg class="bg-blobs" viewBox="0 0 1440 900" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M1440,0 L1440,400 C1200,350 1100,100 900,150 C700,200 600,-50 400,0 Z" fill="#F9C59F" opacity="0.6"/>
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
            <a href="menu_pembeli.php" class="nav-link" title="Beranda"><i class="fa-solid fa-house"></i></a> 
            <a href="favorit.php" class="nav-link" title="Favorit"><i class="fa-regular fa-heart"></i></a>
            <a href="riwayat_pesanan.php" class="nav-link" title="Keranjang & Riwayat"><i class="fa-solid fa-receipt"></i></a>
            <a href="profil.php" class="nav-link active" title="Profil"><i class="fa-solid fa-user"></i></a>
        </div>
    </nav>

    <div class="main-container">
        
        <div class="profile-card">
            
            <div class="avatar">
                <img src="profil.jpg" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
            </div>

            <h1 class="profile-name">Mas Amba</h1>
            <p class="profile-email">customer@email.com</p>

            <div class="info-row">
                <span class="info-label">No. Telepon</span>
                <span class="info-value">0812-3456-7890</span>
            </div>
            <div class="info-row">
                <span class="info-label">Alamat</span>
                <span class="info-value">Jalan Teuku Umar No. 12, Ngawi, Jawa Timur</span>
            </div>

            <a href="login_pembeli.php" class="btn-logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar (Logout)
            </a>

        </div>

    </div>

</body>
</html>