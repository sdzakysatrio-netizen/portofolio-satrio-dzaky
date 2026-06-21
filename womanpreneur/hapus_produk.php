<?php
// ==========================================
// DATABASE DELETE LOGIC (hapus_produk.php)
// ==========================================

$host = 'localhost';
$dbname = 'womanpreneur_db';
$username = 'root';
$password = ''; // Leave empty for default Laragon/XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Support both POST (form) and GET (link) requests for deleting a product
    $product_id = null;
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_to_delete'])) {
        $product_id = $_POST['id_to_delete'];
    } elseif (isset($_GET['id'])) {
        $product_id = $_GET['id'];
    }

    if ($product_id) {

        // 2. Fetch the product first so we know what the photo's file name is
        $stmt = $pdo->prepare("SELECT foto FROM produk WHERE id = ?");
        $stmt->execute([$product_id]);
        $produk = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produk) {
            $foto_path = $produk['foto'];

            // 3. Delete the image file from the server folder (if it exists and is a local file)
            // We make sure not to try and delete placeholder URLs that start with "http"
            if (file_exists($foto_path) && strpos($foto_path, 'http') === false) {
                unlink($foto_path); // 'unlink' is the PHP command to delete a file
            }

            // 4. Delete the actual record from the database
            $delete_stmt = $pdo->prepare("DELETE FROM produk WHERE id = ?");
            $delete_stmt->execute([$product_id]);
        }
    }

    // 5. Instantly redirect the user back to the product list
    header("Location: kelola_produk.php");
    exit;

} catch(PDOException $e) {
    // If something goes wrong, show the error
    die("Database Error: " . $e->getMessage());
}
?>