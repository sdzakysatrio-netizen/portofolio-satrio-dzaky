<?php
// ==========================================
// DATABASE INSERT & FILE UPLOAD LOGIC
// ==========================================

$host = 'localhost';
$dbname = 'womanpreneur_db';
$username = 'root';
$password = ''; // Leave empty for default Laragon/XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama_produk = $_POST['nama_produk'];
        $deskripsi = $_POST['deskripsi'];
        $harga = $_POST['harga'];
        $foto_path = 'https://via.placeholder.com/500?text=No+Image'; // Default if upload fails

        // Handle File Upload
        if (isset($_FILES['foto_produk']) && $_FILES['foto_produk']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/'; 
            
            // Create folder if it doesn't exist
            if (!is_dir($upload_dir)) { 
                mkdir($upload_dir, 0777, true); 
            }
            
            $file_name = time() . '_' . basename($_FILES['foto_produk']['name']);
            $target_file = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['foto_produk']['tmp_name'], $target_file)) {
                $foto_path = $target_file;
            }
        }

        // Insert into Database
        $stmt = $pdo->prepare("INSERT INTO produk (nama_produk, deskripsi, harga, foto) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nama_produk, $deskripsi, $harga, $foto_path]);

        $success_message = "Produk berhasil ditambahkan!";
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
    <title>MealSync - Tambah Produk</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #FDE4D0; min-height: 100vh; display: flex; justify-content: center; align-items: center; position: relative; padding: 40px 20px; }
        .bg-blobs { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; pointer-events: none; }
        .form-container { background-color: #FFFFFF; width: 100%; max-width: 900px; border-radius: 24px; padding: 50px; box-shadow: 0 20px 50px rgba(0,0,0,0.05); z-index: 1; position: relative; }
        
        .header-container { display: flex; align-items: center; margin-bottom: 40px; }
        .btn-back { text-decoration: none; color: #333; font-size: 24px; font-weight: 600; margin-right: 20px; width: 45px; height: 45px; border-radius: 50%; background-color: #FFF1E4; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
        .btn-back:hover { transform: translateX(-5px); background-color: #F9C59F; }
        .page-title { font-size: 28px; font-weight: 700; color: #111; }
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 30px; }
        .input-group { display: flex; flex-direction: column; margin-bottom: 20px; }
        .input-group label { font-size: 15px; font-weight: 500; margin-bottom: 10px; color: #444; margin-left: 5px; }
        .input-group input, .input-group textarea { background-color: #F9C59F; border: none; padding: 18px 20px; border-radius: 14px; font-size: 16px; color: #000; font-weight: 500; box-shadow: 0 4px 10px rgba(220, 150, 100, 0.3); outline: none; transition: all 0.3s; resize: none; }
        .input-group input:focus, .input-group textarea:focus { box-shadow: 0 4px 15px rgba(220, 150, 100, 0.5), 0 0 0 2px rgba(76, 175, 80, 0.5); }
        
        .upload-area-container { display: flex; flex-direction: column; height: 100%; }
        .upload-box { background-color: #4CAF50; border-radius: 20px; height: 100%; min-height: 250px; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; color: white; box-shadow: 0 10px 25px rgba(76, 175, 80, 0.3); transition: all 0.2s; position: relative; overflow: hidden; }
        .upload-box:hover { background-color: #45a049; transform: translateY(-3px); box-shadow: 0 15px 30px rgba(76, 175, 80, 0.4); }
        .upload-box .plus-icon { font-size: 60px; font-weight: 400; line-height: 1; margin-bottom: 10px; }
        .upload-box .upload-text { font-size: 18px; font-weight: 600; }
        
        #imagePreview { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; display: none; border-radius: 20px; z-index: 2; }
        
        .btn-submit { background-color: #388E3C; color: white; border: none; width: 100%; padding: 20px; border-radius: 14px; font-size: 20px; font-weight: 600; cursor: pointer; box-shadow: 0 8px 20px rgba(56, 142, 60, 0.3); transition: all 0.2s; margin-top: 10px; }
        .btn-submit:hover { background-color: #2E7D32; transform: translateY(-3px); box-shadow: 0 12px 25px rgba(56, 142, 60, 0.4); }
        
        .alert { padding: 15px; border-radius: 10px; margin-bottom: 20px; font-weight: 500; text-align: center; }
        .alert-success { background-color: #d4edda; color: #155724; }
        .alert-danger { background-color: #f8d7da; color: #721c24; }
        
        @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } .upload-box { min-height: 200px; } }
    </style>
</head>
<body>

    <svg class="bg-blobs" viewBox="0 0 1440 900" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M1440,0 L1440,400 C1200,350 1100,100 900,150 C700,200 600,-50 400,0 Z" fill="#F9C59F" opacity="0.6"/>
        <path d="M-50,800 C150,850 300,600 500,650 C700,700 850,950 1000,900 C1200,850 1300,1000 1500,900 L1500,1000 L-50,1000 Z" fill="#F9C59F" opacity="0.5"/>
    </svg>

    <div class="form-container">
        
        <?php if(isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if(isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="header-container">
            <a href="kelola_produk.php" class="btn-back">&#10094;</a>
            <h1 class="page-title">Tambah Produk</h1>
        </div>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="input-section">
                    <div class="input-group">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" required>
                    </div>
                    <div class="input-group">
                        <label>Deskripsi Produk</label>
                        <textarea name="deskripsi" rows="3" required></textarea>
                    </div>
                    <div class="input-group">
                        <label>Harga</label>
                        <input type="number" name="harga" required>
                    </div>
                </div>

                <div class="upload-area-container">
                    <div class="input-group" style="height: 100%;">
                        <label>Tambah Foto Produk</label>
                        <label for="fotoUpload" class="upload-box">
                            <span class="plus-icon">+</span>
                            <span class="upload-text">Tambah Foto Produk</span>
                            <img id="imagePreview" src="#" alt="Preview">
                        </label>
                        <input type="file" id="fotoUpload" name="foto_produk" accept="image/*" style="display: none;" onchange="previewImage(event)" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-submit">Tambah</button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>