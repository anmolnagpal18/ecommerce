<?php
class add_to_cart {
    function addProduct($con, $pid, $qty) {
        $_SESSION['cart'][$pid]['qty'] = $qty;
    }

    function updateProduct($con, $pid, $qty) {
        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid]['qty'] = $qty;
        }
    }

    function removeProduct($con, $pid) {
        if (isset($_SESSION['cart'][$pid])) {
            unset($_SESSION['cart'][$pid]);
        }
    }

    function emptyCart($con) {
        unset($_SESSION['cart']);
    }

    function totalProduct() {
        if (isset($_SESSION['cart'])) {
            return count($_SESSION['cart']);
        }else{
            return 0;
        }
        
    }
}
?>
