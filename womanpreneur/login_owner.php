<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MealSync - Login Penjual</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #FDE4D0; min-height: 100vh; display: flex; justify-content: center; align-items: center; position: relative; padding: 40px 20px; }
        
        .bg-blobs { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; pointer-events: none; }
        
        /* --- Back Button --- */
        .back-portal {
            display: inline-flex; align-items: center; gap: 8px; color: #777; 
            text-decoration: none; font-size: 15px; font-weight: 600; 
            position: absolute; top: 40px; left: 40px; transition: color 0.2s; z-index: 10;
        }
        .back-portal:hover { color: #333; }

        /* --- Login Card --- */
        .login-card {
            background-color: #FFFFFF;
            width: 100%;
            max-width: 500px;
            border-radius: 24px;
            padding: 50px 40px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* EXACT LOGO SNIPPET */
        .logo-circle {
            width: 130px;
            height: 130px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            overflow: hidden; 
            padding: 0;
            border: 4px solid #F9C59F;
        }

        .page-title { font-size: 28px; font-weight: 700; color: #111; margin-bottom: 5px; text-align: center; }
        .page-subtitle { font-size: 15px; color: #666; margin-bottom: 35px; text-align: center; }

        form { width: 100%; }

        /* --- Owner Style Inputs (Solid Peach) --- */
        .input-group { display: flex; flex-direction: column; margin-bottom: 20px; position: relative; }
        .input-group label { font-size: 14px; font-weight: 600; margin-bottom: 8px; color: #444; margin-left: 5px; }
        
        .input-wrapper { position: relative; display: flex; align-items: center; }
        .input-wrapper i { position: absolute; left: 20px; color: #888; font-size: 18px; }
        
        .input-group input {
            width: 100%;
            background-color: #F9C59F;
            border: none;
            padding: 16px 20px 16px 50px;
            border-radius: 14px;
            font-size: 16px;
            color: #222;
            font-weight: 500;
            outline: none;
            transition: all 0.3s;
        }
        .input-group input::placeholder { color: rgba(0,0,0,0.4); }
        .input-group input:focus { box-shadow: 0 0 0 2px rgba(141, 110, 99, 0.5); background-color: #fcece0; }

        .forgot-link { display: block; text-align: right; color: #666; font-size: 13px; text-decoration: none; margin-top: -10px; margin-bottom: 25px; font-weight: 500; }
        .forgot-link:hover { color: #8D6E63; text-decoration: underline; }

        .btn-submit {
            background-color: #388E3C;
            color: white;
            border: none;
            width: 100%;
            padding: 18px;
            border-radius: 14px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(56, 142, 60, 0.3);
            transition: all 0.2s;
        }
        .btn-submit:hover { background-color: #2E7D32; transform: translateY(-3px); box-shadow: 0 12px 25px rgba(56, 142, 60, 0.4); }

        .switch-auth { text-align: center; margin-top: 25px; font-size: 14px; color: #555; }
        .switch-auth a { color: #8D6E63; font-weight: 600; text-decoration: none; }
        .switch-auth a:hover { text-decoration: underline; }
        
        @media (max-width: 768px) {
            .back-portal { top: 20px; left: 20px; }
            .login-card { padding: 40px 25px; }
        }
    </style>
</head>
<body>

    <a href="index.php" class="back-portal">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Portal
    </a>

    <svg class="bg-blobs" viewBox="0 0 1440 900" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M1440,0 L1440,400 C1200,350 1100,100 900,150 C700,200 600,-50 400,0 Z" fill="#F9C59F" opacity="0.6"/>
        <path d="M-50,800 C150,850 300,600 500,650 C700,700 850,950 1000,900 C1200,850 1300,1000 1500,900 L1500,1000 L-50,1000 Z" fill="#F9C59F" opacity="0.5"/>
    </svg>

    <div class="login-card">
        
        <div class="logo-circle" style="overflow: hidden; padding: 0;">
            <img src="logo.png" alt="MealSync Logo" style="width: 100%; height: 100%; object-fit: cover;">
        </div>

        <h1 class="page-title">Login Penjual</h1>
        <p class="page-subtitle">Masuk untuk mengelola UMKM Anda</p>

        <form action="dashboard.php" method="POST">
            
            <div class="input-group">
                <label>Email Toko</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="Masukkan email toko" required>
                </div>
            </div>
            
            <div class="input-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Masukkan password" required>
                </div>
            </div>

            <a href="#" class="forgot-link">Lupa Password?</a>

            <button type="submit" class="btn-submit">Masuk ke Dashboard</button>

            <div class="switch-auth">
                Belum punya akun toko? <a href="#">Daftar UMKM</a>
            </div>
        </form>

    </div>

</body>
</html>