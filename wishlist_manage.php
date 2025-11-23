<?php
session_start(); // Ensure session is started

require('connection.inc.php');
require('functions.inc.php');

// Ensure the user is logged in
if (!isset($_SESSION['USER_ID'])) {
    header('location:log.php');
    die();
}

$user_id = $_SESSION['USER_ID'];

// Add product to wishlist
if (isset($_GET['type']) && $_GET['type'] == 'add' && isset($_GET['product_id'])) {
    $product_id = get_safe_value($con, $_GET['product_id']);

    // Check if the product is already in the wishlist
    $check = mysqli_query($con, "SELECT * FROM wishlist WHERE user_id='$user_id' AND product_id='$product_id'");
    
    // If the product is not already in the wishlist, insert it
    if (mysqli_num_rows($check) == 0) {
        $added_on = date('Y-m-d H:i:s');
        $insert_query = "INSERT INTO wishlist(user_id, product_id, added_on) VALUES('$user_id', '$product_id', '$added_on')";
        
        // Check if the query executed successfully
        if (!mysqli_query($con, $insert_query)) {
            die('Error: ' . mysqli_error($con));
        }
    }
    
    // Redirect to wishlist page
    header('location:wishlist.php');
    die();
}

// Remove product from wishlist
if (isset($_GET['type']) && $_GET['type'] == 'remove' && isset($_GET['id'])) {
    $id = get_safe_value($con, $_GET['id']);
    
    // Delete the product from the wishlist
    $delete_query = "DELETE FROM wishlist WHERE id='$id' AND user_id='$user_id'";
    
    // Check if the delete query executed successfully
    if (!mysqli_query($con, $delete_query)) {
        die('Error: ' . mysqli_error($con));
    }
    
    // Redirect to wishlist page
    header('location:wishlist.php');
    die();
}
?>
