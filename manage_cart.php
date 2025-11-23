<?php
require('connection.inc.php');
require('functions.inc.php');
require('add_to_cart.inc.php');

$pid = get_safe_value($con, $_POST['pid']);
$qty = get_safe_value($con, $_POST['qty']);
$type = get_safe_value($con, $_POST['type']);

$obj = new add_to_cart();

if ($type == 'add') {
    $obj->addProduct($con, $pid, $qty); // ✅ pass $con
} elseif ($type == 'update') {
    $obj->updateProduct($con, $pid, $qty);
} elseif ($type == 'remove') {
    $obj->removeProduct($con, $pid);
}

echo $obj->totalProduct(); // Returns cart count
?>
