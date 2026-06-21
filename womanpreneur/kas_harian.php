<?php
// ==========================================
// DATABASE CONNECTION & INSERT LOGIC (MariaDB)
// ==========================================

$host = 'localhost';
$dbname = 'womanpreneur_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tanggal = $_POST['tanggal'];
        $nama_barang = $_POST['nama_barang'];
        $jumlah = $_POST['jumlah'];
        $harga = $_POST['harga'];

        // Prepared statement to prevent SQL injection
        $stmt = $pdo->prepare("INSERT INTO kas_harian (tanggal, nama_barang, jumlah, harga) VALUES (?, ?, ?, ?)");
        $stmt->execute([$tanggal, $nama_barang, $jumlah, $harga]);

        // Show success message or redirect
        $success_message = "Data kas berhasil ditambahkan!";
    }
} catch(PDOException $e) {
    $error_message = "Database Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MealSync - Catat Kas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #FDE4D0; /* Light peach background */
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow-x: hidden;
            padding: 20px;
        }

        /* --- Desktop Background Blobs --- */
        .bg-blobs {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        /* --- Form Container --- */
        .form-container {
            position: relative;
            z-index: 1;
            background-color: #FFFFFF;
            width: 100%;
            max-width: 800px; /* Perfect width for a desktop form */
            border-radius: 24px;
            padding: 50px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        }

        /* --- Header & Back Button --- */
        .header-container {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }

        .btn-back {
            text-decoration: none;
            color: #333;
            font-size: 24px;
            font-weight: 600;
            margin-right: 20px;
            transition: transform 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #FFF1E4;
        }

        .btn-back:hover {
            transform: translateX(-5px);
            background-color: #F9C59F;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #111;
        }

        /* --- Form Layout & Inputs --- */
        /* Using CSS Grid for a 2-column layout on desktop */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
        }

        .input-group label {
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 10px;
            color: #444;
            margin-left: 5px;
        }

        .input-group input {
            background-color: #F9C59F; /* The darker peach matching the Figma inputs */
            border: none;
            padding: 18px 20px;
            border-radius: 14px;
            font-size: 16px;
            color: #000;
            font-weight: 500;
            /* Recreating the specific drop shadow from your design */
            box-shadow: 0 4px 10px rgba(220, 150, 100, 0.4);
            outline: none;
            transition: all 0.3s;
        }

        .input-group input:focus {
            box-shadow: 0 4px 15px rgba(220, 150, 100, 0.6), 0 0 0 2px rgba(76, 175, 80, 0.5);
        }

        /* --- Submit Button --- */
        .btn-submit {
            background-color: #4CAF50; /* Green button */
            color: white;
            border: none;
            width: 100%;
            padding: 20px;
            border-radius: 14px;
            font-size: 20px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(76, 175, 80, 0.3);
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background-color: #45a049;
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(76, 175, 80, 0.4);
        }

        /* --- Alerts --- */
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
            text-align: center;
        }
        .alert-success { background-color: #d4edda; color: #155724; }
        .alert-danger { background-color: #f8d7da; color: #721c24; }

        /* --- Responsive fallback for small laptops or resize --- */
        @media (max-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr; /* Stacks back to 1 column if the window is small */
            }
            .form-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

    <svg class="bg-blobs" viewBox="0 0 1440 900" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M-50,800 C200,850 300,600 500,650 C700,700 800,900 1000,850 C1200,800 1300,1000 1500,900 L1500,1000 L-50,1000 Z" fill="#F9C59F" opacity="0.6"/>
        <path d="M1440,0 L1440,300 C1200,250 1100,50 900,100 C700,150 600,-50 400,0 Z" fill="#F9C59F" opacity="0.5"/>
    </svg>

    <div class="form-container">
        
        <?php if(isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if(isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="header-container">
            <a href="dashboard.php" class="btn-back" title="Kembali">&#10094;</a>
            <h1 class="page-title">Pencatatan KAS Harian</h1>
        </div>

        <form action="" method="POST">
            <div class="form-grid">
                
                <div class="input-group">
                    <label>Masukkan Tanggal</label>
                    <input type="date" name="tanggal" value="2025-07-06" required>
                </div>
                
                <div class="input-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" placeholder="Contoh: Ketoprak" required>
                </div>

                <div class="input-group">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" placeholder="0" required>
                </div>

                <div class="input-group">
                    <label>Harga</label>
                    <input type="number" name="harga" placeholder="0" required>
                </div>

            </div>

            <button type="submit" class="btn-submit">Tambah</button>
        </form>

    </div>

</body>
</html> 