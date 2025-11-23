<?php
require('top.php');

// if (!isset($_SESSION['USER_LOGIN'])) {
//     echo "<script>window.location.href='log.php';</script>";
//     die();
// }

if (!isset($_GET['id']) || $_GET['id'] == '') {
    echo "<script>window.location.href='my_order.php';</script>";
    die();
}

$order_id = intval($_GET['id']);
$user_id = $_SESSION['USER_ID'];

$res = mysqli_query($con, "SELECT order_detail.*, product.name, product.image 
                           FROM order_detail, product, orders 
                           WHERE order_detail.order_id = '$order_id' 
                           AND orders.user_id = '$user_id' 
                           AND order_detail.product_id = product.id 
                           AND orders.id = order_detail.order_id");

if (mysqli_num_rows($res) == 0) {
    echo "<script>window.location.href='my_order.php';</script>";
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        table th {
            background-color: #f8f8f8;
        }

        img.product-img {
            width: 60px;
            height: auto;
            border-radius: 6px;
        }

        @media (max-width: 600px) {
            table th, table td {
                font-size: 14px;
                padding: 8px;
            }
            img.product-img {
                width: 40px;
            }
        }
    </style>
</head>
<body>
<h2 class="section-heading">Order Details</h2>
    <div class="container">
        
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                while ($row = mysqli_fetch_assoc($res)) {
                    $line_total = $row['qty'] * $row['price'];
                    $total += $line_total;
                    ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><img src="media/product/<?php echo $row['image']; ?>" class="product-img"></td>
                        <td><?php echo $row['qty']; ?></td>
                        <td>₹<?php echo $row['price']; ?></td>
                        <td>₹<?php echo $line_total; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="4" style="text-align: right;"><strong>Grand Total</strong></td>
                    <td><strong>₹<?php echo $total; ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php require('footer.php'); ?>
