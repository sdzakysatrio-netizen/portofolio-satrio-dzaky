<?php
session_start();

if(isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    // Create the favorites array in the session if it doesn't exist yet
    if(!isset($_SESSION['favorites'])) {
        $_SESSION['favorites'] = [];
    }
    
    // If the item is already favorited, REMOVE it (un-favorite)
    if(in_array($product_id, $_SESSION['favorites'])) {
        $_SESSION['favorites'] = array_diff($_SESSION['favorites'], [$product_id]);
    } 
    // If it's not favorited yet, ADD it
    else {
        $_SESSION['favorites'][] = $product_id;
    }
}

// Bounce them back to whichever page they clicked the button from
$redirect_url = isset($_GET['redirect']) ? $_GET['redirect'] : 'menu_pembeli.php';
header("Location: " . $redirect_url);
exit;
?>