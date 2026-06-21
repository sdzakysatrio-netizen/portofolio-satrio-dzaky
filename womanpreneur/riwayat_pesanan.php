<?php
session_start();

$pesan_sukses = false;
$metode_pilihan = "";

// Initialize history session if it doesn't exist yet
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

// Calculate Current Cart
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total_price = 0;
$total_items_count = 0;
foreach($cart_items as $item) {
    $total_price += ($item['harga'] * $item['qty']);
    $total_items_count += $item['qty'];
}

// Handle a real "Checkout" form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'checkout') {
    $metode_pilihan = isset($_POST['metode_bayar']) ? $_POST['metode_bayar'] : 'Tunai';
    
    // Save the order to our History Session!
    $new_order = [
        'tanggal' => date('d F Y, H:i'),
        'jumlah_item' => $total_items_count,
        'total_harga' => $total_price,
        'metode' => $metode_pilihan
    ];
    
    // Add to the beginning of the history array so the newest order is at the top
    array_unshift($_SESSION['history'], $new_order);

    // Clear the cart
    unset($_SESSION['cart']); 
    $cart_items = []; // Empty it for the current page load
    $total_price = 0;
    $pesan_sukses = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MealSync - Riwayat Pesanan</title>
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

        /* --- Main Layout --- */
        .main-container { max-width: 800px; margin: 40px auto; padding: 0 20px; display: flex; flex-direction: column; gap: 40px; }
        .section-title { font-size: 32px; font-weight: 700; color: #111; text-align: center; margin-bottom: 25px; }

        /* --- Current Cart Section --- */
        .cart-card { background-color: #FFFFFF; border-radius: 20px; padding: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); }
        .cart-item { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #eee; }
        .cart-item:last-child { border-bottom: none; }
        .item-info h4 { font-size: 18px; color: #333; font-weight: 600; }
        .item-info p { font-size: 14px; color: #777; }
        .item-price { font-weight: 700; font-size: 18px; color: #4CAF50; }

        /* --- Payment Method Cards --- */
        .payment-section { margin-top: 25px; border-top: 2px dashed #eee; padding-top: 25px; }
        .payment-title { font-size: 16px; font-weight: 700; color: #333; margin-bottom: 15px; }
        .payment-options { display: flex; gap: 15px; }
        .pay-radio { display: none; }
        .pay-card { flex: 1; background-color: #f9f9f9; border: 2px solid #e0e0e0; border-radius: 12px; padding: 15px; text-align: center; cursor: pointer; transition: all 0.2s; display: flex; flex-direction: column; align-items: center; gap: 10px; }
        .pay-card i { font-size: 24px; color: #777; transition: color 0.2s; }
        .pay-card span { font-weight: 600; font-size: 15px; color: #555; transition: color 0.2s; }
        .pay-radio:checked + .pay-card { border-color: #4CAF50; background-color: #f0fdf4; box-shadow: 0 4px 10px rgba(76, 175, 80, 0.15); }
        .pay-radio:checked + .pay-card i, .pay-radio:checked + .pay-card span { color: #4CAF50; }

        /* --- Total & Checkout --- */
        .cart-total { display: flex; justify-content: space-between; align-items: center; margin-top: 25px; font-size: 20px; font-weight: 700; }
        .btn-checkout { background-color: #4CAF50; color: white; border: none; width: 100%; display: block; text-align: center; padding: 18px; border-radius: 12px; font-size: 18px; font-weight: 600; margin-top: 25px; cursor: pointer; box-shadow: 0 8px 20px rgba(76, 175, 80, 0.3); transition: all 0.2s; }
        .btn-checkout:hover { background-color: #45a049; transform: translateY(-3px); box-shadow: 0 12px 25px rgba(76, 175, 80, 0.4); }

        /* --- Success Alert & QR Code --- */
        .alert-success { background-color: #d4edda; color: #155724; padding: 20px; border-radius: 12px; text-align: center; margin-bottom: 20px; border: 1px solid #c3e6cb; }
        .alert-success h3 { margin-bottom: 5px; font-size: 20px; }
        .alert-success p { font-size: 15px; opacity: 0.9; }
        .qr-code-box { margin-top: 20px; padding: 15px; background: white; border-radius: 15px; display: inline-block; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .qr-code-box img { width: 180px; height: 180px; }

        /* --- Order History Section --- */
        .history-card { background: linear-gradient(90deg, #F9C59F 0%, #fde4d0 100%); border-radius: 15px; padding: 20px 25px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; box-shadow: 0 4px 10px rgba(220, 150, 100, 0.2); text-decoration: none; color: inherit; transition: transform 0.2s, box-shadow 0.2s; cursor: pointer; border: none; width: 100%; text-align: left; }
        .history-card:hover { transform: translateX(5px); box-shadow: 0 6px 15px rgba(220, 150, 100, 0.4); }
        .history-info h4 { font-size: 18px; font-weight: 700; color: #222; margin-bottom: 5px; }
        .history-info p { font-size: 13px; color: #666; }
        .history-arrow { color: #888; font-size: 18px; }

        /* --- Modal Styling --- */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1000; justify-content: center; align-items: center; backdrop-filter: blur(5px); }
        .modal-box { background: white; width: 90%; max-width: 400px; padding: 30px; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.2); position: relative; }
        .close-btn { position: absolute; top: 15px; right: 20px; font-size: 24px; color: #777; cursor: pointer; transition: color 0.2s; }
        .close-btn:hover { color: #d32f2f; }
        .modal-box h3 { font-size: 22px; color: #333; margin-bottom: 20px; text-align: center; border-bottom: 2px dashed #eee; padding-bottom: 15px; }
        .modal-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 15px; color: #555; }
        .modal-row strong { color: #222; }

        @media (max-width: 768px) { .navbar { padding: 15px 20px; } .cart-card { padding: 20px; } }
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
            <a href="menu_pembeli.php" class="nav-link" title="Beranda"><i class="fa-solid fa-house"></i></a> 
            <a href="favorit.php" class="nav-link" title="Favorit"><i class="fa-regular fa-heart"></i></a>
            <a href="riwayat_pesanan.php" class="nav-link active" title="Keranjang & Riwayat"><i class="fa-solid fa-receipt"></i></a>
            <a href="profil.php" class="nav-link" title="Profil"><i class="fa-regular fa-user"></i></a>
        </div>
    </nav>

    <div class="main-container">
        
        <div>
            <h1 class="section-title">Keranjang Saat Ini</h1>
            
            <?php if($pesan_sukses): ?>
                <div class="alert-success">
                    <h3><i class="fa-solid fa-circle-check"></i> Pesanan Berhasil!</h3>
                    <p>Terima kasih. Anda telah memilih metode pembayaran: <strong><?php echo htmlspecialchars($metode_pilihan); ?></strong>.</p>
                    
                    <?php if($metode_pilihan == 'QRIS'): ?>
                        <div class="qr-code-box">
                            <p style="font-weight: 600; color: #333; margin-bottom: 10px; font-size: 14px;">Scan untuk membayar:</p>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=Pembayaran+QRIS+MealSync" alt="QRIS Barcode">
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="cart-card">
                <?php if(empty($cart_items)): ?>
                    <div style="text-align: center; padding: 20px; color: #777;">
                        <i class="fa-solid fa-basket-shopping" style="font-size: 40px; margin-bottom: 15px; color: #ccc;"></i>
                        <p>Keranjang masih kosong.</p>
                        <a href="menu_pembeli.php" style="color: #4CAF50; font-weight: 600; text-decoration: none; display: inline-block; margin-top: 10px;">Kembali ke Menu</a>
                    </div>
                <?php else: ?>
                    
                    <form method="POST" action="riwayat_pesanan.php">
                        <input type="hidden" name="action" value="checkout">
                        
                        <?php foreach($cart_items as $id => $item): ?>
                            <?php $item_total = $item['harga'] * $item['qty']; ?>
                            <div class="cart-item">
                                <div class="item-info">
                                    <h4><?php echo htmlspecialchars($item['nama']); ?></h4>
                                    <p><?php echo $item['qty']; ?>x @ Rp. <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                                </div>
                                <div class="item-price">
                                    Rp. <?php echo number_format($item_total, 0, ',', '.'); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <div class="payment-section">
                            <div class="payment-title">Pilih Metode Pembayaran</div>
                            <div class="payment-options">
                                <label style="flex: 1;">
                                    <input type="radio" name="metode_bayar" value="Tunai" class="pay-radio" required checked>
                                    <div class="pay-card">
                                        <i class="fa-solid fa-money-bill-wave"></i>
                                        <span>Tunai</span>
                                    </div>
                                </label>
                                
                                <label style="flex: 1;">
                                    <input type="radio" name="metode_bayar" value="QRIS" class="pay-radio" required>
                                    <div class="pay-card">
                                        <i class="fa-solid fa-qrcode"></i>
                                        <span>QRIS</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="cart-total">
                            <span>Total Pembayaran</span>
                            <span style="color: #4CAF50;">Rp. <?php echo number_format($total_price, 0, ',', '.'); ?></span>
                        </div>

                        <button type="submit" class="btn-checkout">
                            Pesan Sekarang <i class="fa-solid fa-paper-plane" style="margin-left: 10px;"></i>
                        </button>
                    </form>

                <?php endif; ?>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <h1 class="section-title">Riwayat Pesanan</h1>

            <?php if(empty($_SESSION['history'])): ?>
                <div style="text-align: center; color: #777; padding: 20px; background-color: #FFFFFF; border-radius: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.05);">
                    <i class="fa-solid fa-clock-rotate-left" style="font-size: 30px; margin-bottom: 10px; color: #ccc;"></i><br>
                    Belum ada riwayat pesanan.
                </div>
            <?php else: ?>
                <?php foreach($_SESSION['history'] as $order): ?>
                
                <button onclick="openModal('<?php echo $order['tanggal']; ?>', '<?php echo $order['jumlah_item']; ?>', '<?php echo htmlspecialchars($order['metode']); ?>', '<?php echo number_format($order['total_harga'], 0, ',', '.'); ?>')" class="history-card">
                    <div class="history-info">
                        <h4><?php echo $order['jumlah_item']; ?> Item</h4>
                        <p><?php echo $order['tanggal']; ?> • <?php echo htmlspecialchars($order['metode']); ?></p>
                    </div>
                    <div style="text-align: right; margin-right: 15px;">
                        <span style="color: #4CAF50; font-weight: 700; font-size: 16px;">Rp. <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></span>
                    </div>
                    <i class="fa-solid fa-chevron-right history-arrow"></i>
                </button>
                
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div id="receiptModal" class="modal-overlay">
        <div class="modal-box">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h3>Struk Pesanan</h3>
            
            <div class="modal-row">
                <span>Tanggal:</span>
                <strong id="modal-date"></strong>
            </div>
            <div class="modal-row">
                <span>Jumlah Item:</span>
                <strong id="modal-items"></strong>
            </div>
            <div class="modal-row">
                <span>Metode Bayar:</span>
                <strong id="modal-method"></strong>
            </div>
            
            <hr style="margin: 20px 0; border: 0; border-top: 2px dashed #eee;">
            
            <div class="modal-row" style="font-size: 18px;">
                <span>Total:</span>
                <strong style="color: #4CAF50;">Rp. <span id="modal-total"></span></strong>
            </div>

            <button onclick="closeModal()" class="btn-checkout" style="margin-top: 25px; padding: 12px; background-color: #f0f0f0; color: #333; box-shadow: none;">Tutup</button>
        </div>
    </div>

    <script>
        function openModal(date, items, method, total) {
            // Fill the modal with the specific data from the button clicked
            document.getElementById('modal-date').innerText = date;
            document.getElementById('modal-items').innerText = items;
            document.getElementById('modal-method').innerText = method;
            document.getElementById('modal-total').innerText = total;
            
            // Show the modal
            document.getElementById('receiptModal').style.display = 'flex';
        }

        function closeModal() {
            // Hide the modal
            document.getElementById('receiptModal').style.display = 'none';
        }

        // Optional: Close modal if user clicks outside the white box
        window.onclick = function(event) {
            var modal = document.getElementById('receiptModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>

</body>
</html>