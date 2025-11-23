<?php require('top.php');

// if (!isset($_SESSION['user_id'])) {
//   // Redirect to the homepage if not logged in
//   header("Location: index.php");
//   exit;
// }

if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['id'])) {
  $product_id = get_safe_value($con, $_GET['id']);

  $productArr = get_product($con, '', '', $product_id);
  if (!empty($productArr)) {
    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
      $_SESSION['cart'][$product_id]['qty'] += 1;
    } else {
      $_SESSION['cart'][$product_id] = ['qty' => 1];
    }
  }

  header("Location: cart.php");
  exit;
}

// Handle quantity update or removal
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pid'])) {
  $pid = get_safe_value($con, $_POST['pid']);

  if (isset($_POST['qty'])) {
    $qty = max(1, (int)get_safe_value($con, $_POST['qty']));
    if (isset($_SESSION['cart'][$pid])) {
      $_SESSION['cart'][$pid]['qty'] = $qty;
    }
  }

  if (isset($_POST['remove'])) {
    unset($_SESSION['cart'][$pid]);
  }

  header("Location: cart.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Shopping Cart</title>
  <style>
    h1 {
      font-size: 32px;
      margin-bottom: 20px;
    }

    .cart-container {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .cart-main {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .cart-items, .order-summary {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      flex: 1;
      min-width: 300px;
    }

    .cart-item {
      display: flex;
      align-items: center;
      border-bottom: 1px solid #eee;
      padding: 15px 0;
      gap: 15px;
    }

    .cart-item img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
    }

    .item-details {
      flex: 1;
    }

    .item-details h4 {
      margin-bottom: 6px;
    }

    .item-details .price {
      color: #111;
      font-size: 15px;
      font-weight: bold;
    }

    .item-details .mrp {
      color: #777;
      font-size: 13px;
      text-decoration: line-through;
      margin-left: 8px;
    }

    .cart-controls {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .size {
      padding: 6px 12px;
      background: #eee;
      border-radius: 6px;
      font-size: 14px;
    }

    .qty {
      display: flex;
      align-items: center;
      border: 1px solid #ccc;
      border-radius: 8px;
      overflow: hidden;
    }

    .qty button {
      padding: 6px 10px;
      background: none;
      border: none;
      cursor: pointer;
      font-size: 16px;
    }

    .qty input {
      width: 40px;
      text-align: center;
      border: none;
      font-size: 14px;
    }

    .item-total {
      min-width: 60px;
      text-align: right;
      font-weight: bold;
    }

    .remove-btn {
      background: none;
      border: none;
      color: #e44;
      font-size: 18px;
      cursor: pointer;
    }

    .promo {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
    }

    .promo input {
      flex: 1;
      padding: 12px;
      border: 2px solid #111;
      border-radius: 10px;
      font-size: 14px;
    }

    .promo button {
      padding: 12px 18px;
      background-color: #111;
      color: #fff;
      border: none;
      border-radius: 10px;
      font-size: 14px;
      cursor: pointer;
    }

    .promo small {
      display: block;
      margin-top: 5px;
      color: #666;
    }

    .order-summary {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
    }

    .summary-line {
      display: flex;
      justify-content: space-between;
      margin: 8px 0;
    }

    .checkout-btn {
      margin-top: 15px;
      padding: 14px;
      width: 100%;
      background: #0e1a2b;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    .checkout-btn:hover {
      background: #1c2941;
    }

    @media (max-width: 768px) {
      .cart-main {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <br>
  <h2 class="section-heading">Shopping Cart</h2>
  <div class="cart-container">
    <div class="cart-main">
      <div class="cart-items">
        <?php 
        $cartTotal = 0;
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
          foreach ($_SESSION['cart'] as $key => $val) {
            $productArr = get_product($con, '', '', $key);
            $pname = $productArr[0]['name'];
            $mrp = $productArr[0]['mrp'];
            $price = $productArr[0]['price'];
            $image = $productArr[0]['image'];
            $qty = $val['qty'];
            $itemTotal = $price * $qty;
            $cartTotal += $itemTotal;
        ?>
        <form method="post" action="cart.php" class="cart-item" id="item-<?php echo $key ?>">
          <img src="media/product/<?php echo $image ?>" alt="image">
          <div class="item-details">
            <h4><?php echo $pname ?></h4>
            <span class="price">₹<?php echo $price ?></span>
            <span class="mrp">₹<?php echo $mrp ?></span>
          </div>
          <div class="cart-controls">
            <!-- <span class="size">L</span> -->
            <div class="qty">
              <button type="button" onclick="changeQty(<?php echo $key ?>, -1)">-</button>
              <input type="number" name="qty" id="qty-<?php echo $key ?>" value="<?php echo $qty ?>" min="1" />
              <button type="button" onclick="changeQty(<?php echo $key ?>, 1)">+</button>
            </div>
          </div>
          <div class="item-total" id="itemTotal-<?php echo $key ?>">₹<?php echo $itemTotal ?></div>
          <input type="hidden" name="pid" value="<?php echo $key ?>">
          <button class="remove-btn" name="remove" value="1">🗑️</button>
          <input type="submit" style="display:none">
        </form>
        <?php 
          }
        } else {
          echo "<p>Your cart is empty.</p>";
        }
        ?>
      </div>

      <div class="order-summary">
        <h3>Order Summary</h3>
        <div class="summary-line">
          <span>Subtotal</span>
          <span id="subtotal">₹<?php echo $cartTotal ?></span>
        </div>
        <div class="summary-line">
          <span>Shipping</span>
          <span id="shipping">₹50</span>
        </div>
        <hr>
        <div class="summary-line" style="font-weight: bold;">
          <span>Total</span>
          <span id="total">₹<?php echo $cartTotal + 50 ?></span>
        </div>
        <a href="checkout.php"><button class="checkout-btn">Proceed to Checkout</button></a>
      </div>
    </div>

    <div class="promo">
      <h3>Have a promo code?</h3>
      <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
        <input type="text" id="promoInput" placeholder="Enter promo code">
        <button onclick="applyPromo()">OK</button>
      </div>
      <small>Try "DISCOUNT10" for 10% off</small>
    </div>
  </div>

  <script>
    function changeQty(productId, change) {
      const qtyInput = document.getElementById(`qty-${productId}`);
      let qty = parseInt(qtyInput.value);
      qty = Math.max(qty + change, 1);
      qtyInput.value = qty;
      document.getElementById(`item-${productId}`).submit();
    }
  </script>

  <?php require('footer.php') ?>
</body>
</html>
