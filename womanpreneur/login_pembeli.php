<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MealSync - Login Pembeli</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { min-height: 100vh; display: flex; overflow: hidden; background-color: #FDE4D0; }

        .split-container { display: flex; width: 100%; min-height: 100vh; }

        /* --- Back Button --- */
        .back-portal {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #555;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            position: absolute;
            top: 40px;
            left: 40px;
            transition: all 0.2s;
            z-index: 10;
            padding: 8px 15px;
            background: rgba(255,255,255,0.3);
            border-radius: 20px;
        }
        .back-portal:hover { color: #222; background: rgba(255,255,255,0.6); transform: translateX(-3px); }

        /* =========================================
            LEFT SIDE: BRANDING
           ========================================= */
        .brand-side {
            flex: 1;
            background: linear-gradient(180deg, #FDE4D0 0%, #a27a5e 50%, #2A2421 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: white;
            position: relative;
        }

        .brand-side h1 { font-size: 42px; font-weight: 700; margin-top: 30px; margin-bottom: 15px; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        .brand-side p { font-size: 18px; text-align: center; max-width: 400px; line-height: 1.5; font-weight: 400; opacity: 0.9; }

        .logo-circle {
            width: 180px;
            height: 180px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden; 
        }

        /* =========================================
            RIGHT SIDE: LOGIN FORM
           ========================================= */
        .form-side {
            flex: 1;
            background-color: #FDE4D0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            position: relative;
        }

        .bg-blobs { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; pointer-events: none; }

        .form-wrapper {
            width: 100%;
            max-width: 450px;
            z-index: 1;
        }

        .form-title { font-size: 38px; font-weight: 700; color: #333333; margin-bottom: 40px; }

        /* Input Group Styling */
        .input-group { position: relative; margin-bottom: 30px; display: flex; align-items: center; }
        .input-icon { font-size: 18px; color: #888; margin-right: 15px; width: 25px; text-align: center; }
        
        .input-group input {
            flex: 1;
            background: transparent;
            border: none;
            border-bottom: 2px solid rgba(0,0,0,0.1);
            padding: 10px 0;
            font-size: 16px;
            color: #333;
            outline: none;
            transition: all 0.3s;
        }

        .input-group input::placeholder { color: rgba(0,0,0,0.4); }
        .input-group input:focus { border-bottom: 2px solid #4CAF50; }
        
        .input-suffix { font-size: 16px; color: #4CAF50; margin-left: 10px; cursor: pointer; }
        .input-suffix.eye { color: #888; }

        .forgot-link { display: block; text-align: right; color: #555; font-size: 13px; text-decoration: none; margin-top: -15px; margin-bottom: 30px; font-weight: 500; }
        .forgot-link:hover { color: #4CAF50; text-decoration: underline; }

        /* Buttons */
        .btn-primary {
            background-color: #4CAF50;
            color: white;
            border: none;
            width: 100%;
            padding: 18px;
            border-radius: 14px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(76, 175, 80, 0.3);
            transition: all 0.2s;
            margin-bottom: 25px;
        }
        .btn-primary:hover { background-color: #45a049; transform: translateY(-2px); box-shadow: 0 10px 25px rgba(76, 175, 80, 0.4); }

        .divider { display: flex; align-items: center; text-align: center; color: #777; font-size: 13px; font-weight: 600; margin-bottom: 25px; }
        .divider::before, .divider::after { content: ''; flex: 1; border-bottom: 1px solid rgba(0,0,0,0.1); }
        .divider span { padding: 0 15px; }

        /* Social Login */
        .social-login { display: flex; gap: 15px; }
        .btn-social {
            flex: 1; padding: 14px; border-radius: 12px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; border: none; transition: all 0.2s;
        }
        .btn-google { background-color: white; color: #333; border: 1px solid #ddd; }
        .btn-facebook { background-color: #1877F2; color: white; }
        .btn-social:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

        .switch-auth { text-align: center; margin-top: 30px; font-size: 14px; color: #555; }
        .switch-auth a { color: #4CAF50; font-weight: 600; text-decoration: none; }
        .switch-auth a:hover { text-decoration: underline; }

        @media (max-width: 900px) {
            .split-container { flex-direction: column; }
            .brand-side { display: none; }
            .back-portal { top: 20px; left: 20px; }
            body { overflow: auto; }
        }
    </style>
</head>
<body>

    <div class="split-container">
        
        <div class="brand-side">
            <div class="logo-circle">
                <img src="logo.png" alt="MealSync Logo" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <h1>MealSync</h1>
            <p>Pesan langsung dari ponselmu,<br>lebih cepat dan praktis</p>
        </div>

        <div class="form-side">
            
            <a href="index.php" class="back-portal">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Portal
            </a>
            
            <svg class="bg-blobs" viewBox="0 0 500 1000" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,0 L500,0 L500,200 C400,250 300,100 150,150 C50,180 0,300 0,300 Z" fill="#F9C59F" opacity="0.8"/>
                <circle cx="100" cy="400" r="30" fill="#F9C59F" opacity="0.8"/>
                <circle cx="450" cy="500" r="50" fill="#F9C59F" opacity="0.8"/>
                <path d="M0,1000 L500,1000 L500,800 C350,750 250,900 100,850 C50,830 0,700 0,700 Z" fill="#F9C59F" opacity="0.8"/>
            </svg>

            <div class="form-wrapper">
                <h2 class="form-title">Selamat Datang !</h2>

                <form action="menu_pembeli.php" method="POST">
                    
                    <div class="input-group">
                        <span class="input-icon"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="email" placeholder="Email" required>
                        <span class="input-suffix"><i class="fa-solid fa-circle-check"></i></span>
                    </div>
                    
                    <div class="input-group">
                        <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" placeholder="Password" required>
                        <span class="input-suffix eye"><i class="fa-solid fa-eye"></i></span>
                    </div>

                    <a href="#" class="forgot-link">Lupa Password ?</a>

                    <button type="submit" class="btn-primary">Sign In</button>

                    <div class="divider">
                        <span>atau masuk dengan</span>
                    </div>

                    <div class="social-login">
                        <button type="button" class="btn-social btn-google">
                            <i class="fa-brands fa-google"></i> Google
                        </button>
                        <button type="button" class="btn-social btn-facebook">
                            <i class="fa-brands fa-facebook-f"></i> Facebook
                        </button>
                    </div>

                    <div class="switch-auth">
                        Belum Punya Akun? <a href="register_pembeli.php">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>

    </div>

</body>
</html>