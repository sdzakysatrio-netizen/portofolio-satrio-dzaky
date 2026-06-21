<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MealSync - Portal Masuk</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #FDE4D0; min-height: 100vh; display: flex; justify-content: center; align-items: center; position: relative; padding: 40px 20px; overflow: hidden; }
        
        /* --- Background Graphics --- */
        .bg-blobs { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; pointer-events: none; }

        /* --- Main Card --- */
        .portal-card {
            background-color: #FFFFFF;
            width: 100%;
            max-width: 800px;
            border-radius: 24px;
            padding: 50px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        /* --- Logo --- */
        .logo-circle {
            width: 150px;
            height: 150px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            overflow: hidden; 
            padding: 0;
            border: 4px solid #F9C59F;
        }

        /* --- Typography --- */
        .portal-title { font-size: 32px; font-weight: 700; color: #222; margin-bottom: 10px; }
        .portal-subtitle { font-size: 16px; color: #666; margin-bottom: 40px; }

        /* --- Selection Options --- */
        .options-container {
            display: flex;
            gap: 30px;
            width: 100%;
            justify-content: center;
        }

        .role-card {
            flex: 1;
            background-color: #fcfcfc;
            border: 2px solid #eee;
            border-radius: 20px;
            padding: 40px 20px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .role-icon {
            font-size: 50px;
            color: #ccc;
            transition: all 0.3s;
            margin-bottom: 10px;
        }

        .role-title { font-size: 22px; font-weight: 700; }
        .role-desc { font-size: 14px; color: #777; line-height: 1.5; padding: 0 10px; }

        /* Hover Effects */
        .role-card.customer:hover {
            border-color: #4CAF50;
            background-color: #f0fdf4;
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(76, 175, 80, 0.2);
        }
        .role-card.customer:hover .role-icon { color: #4CAF50; transform: scale(1.1); }

        .role-card.owner:hover {
            border-color: #8D6E63;
            background-color: #fdfaf8;
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(141, 110, 99, 0.2);
        }
        .role-card.owner:hover .role-icon { color: #8D6E63; transform: scale(1.1); }

        @media (max-width: 768px) {
            .options-container { flex-direction: column; }
            .portal-card { padding: 40px 25px; }
        }
    </style>
</head>
<body>

    <svg class="bg-blobs" viewBox="0 0 1440 900" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M-100,-100 L400,-100 C450,150 250,300 100,350 C-50,400 -100,250 -100,-100 Z" fill="#F9C59F" opacity="0.6"/>
        <path d="M1540,1000 L1000,1000 C950,750 1150,600 1300,550 C1450,500 1540,650 1540,1000 Z" fill="#F9C59F" opacity="0.7"/>
    </svg>

    <div class="portal-card">
        
        <div class="logo-circle" style="overflow: hidden; padding: 0;">
            <img src="logo.png" alt="MealSync Logo" style="width: 100%; height: 100%; object-fit: cover;">
        </div>

        <h1 class="portal-title">Selamat Datang di MealSync</h1>
        <p class="portal-subtitle">Silakan pilih peran Anda untuk melanjutkan</p>

        <div class="options-container">
            
            <a href="login_pembeli.php" class="role-card customer">
                <i class="fa-solid fa-basket-shopping role-icon"></i>
                <div class="role-title">Saya Pembeli</div>
                <div class="role-desc">Pesan makanan favoritmu dengan mudah, cepat, dan praktis.</div>
            </a>

            <a href="login_owner.php" class="role-card owner">
                <i class="fa-solid fa-store role-icon"></i>
                <div class="role-title">Saya Penjual</div>
                <div class="role-desc">Kelola menu, lihat pesanan, dan atur keuangan UMKM kamu.</div>
            </a>

        </div>

    </div>

</body>
</html>