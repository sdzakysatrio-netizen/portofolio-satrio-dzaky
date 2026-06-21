<?php
session_start(); // This turns on the server's memory to remember the cart!

// ==========================================
// DATABASE CONNECTION
// ==========================================
$host = 'localhost';
$dbname = 'womanpreneur_db';
$username = 'root';
$password = ''; // Leave empty for default Laragon/XAMPP

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Find the specific product they clicked
        $stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
        $stmt->execute([$product_id]);
        $produk = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($produk) {
            // If the cart session doesn't exist yet, create an empty array
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            
            // If the item is already in the cart, just add +1 to the quantity
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['qty'] += 1;
            } else {
                // Otherwise, add the new item to the cart with a quantity of 1
                $_SESSION['cart'][$product_id] = [
                    'nama' => $produk['nama_produk'],
                    'harga' => $produk['harga'],
                    'qty' => 1
                ];
            }
        }
    } catch(PDOException $e) {
        // If something goes wrong with the database, show the error
        die("Database Error: " . $e->getMessage());
    }
}

// ==========================================
// SMART REDIRECT LOGIC
// ==========================================
// Check if the link passed a specific page to return to (e.g., ?redirect=favorit.php)
// If there is no redirect specified, default to sending them back to the main menu.
$redirect_url = isset($_GET['redirect']) ? $_GET['redirect'] : 'menu_pembeli.php';

// Instantly send them back so the page refresh feels seamless
header("Location: " . $redirect_url);
exit;
?>