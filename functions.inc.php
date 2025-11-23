<?php
// to give value safely
function get_safe_value($con,$str){
    if($str!=''){
    // adds a backslash (\) before special characters like ', ", or ; to stop hackers from injecting harmful SQL code.
    // \' OR 1=1 --
    // the database treats it as text, not as a command. The hacker fails.
    return mysqli_real_escape_string($con,$str);
}
}

// print arr
function prx($arr){
    echo "<pre>";
    print_r($arr);
    die();
}

// function to get the value of a product

function get_product($con, $limit = '', $cat_id = '', $product_id = '', $is_best_seller = '', $str = '') {
    $sql = "SELECT * FROM product WHERE status = 1 ";

    if (!empty($cat_id)) {
        $sql .= " AND categories_id = $cat_id";
    }

    if (!empty($product_id)) {
        $sql .= " AND id = $product_id";
    }

    if ($is_best_seller === '1') {
        $sql .= " AND best_seller = 1";
    }

    if (!empty($str)) {
        // Escape the search term safely
        $str = mysqli_real_escape_string($con, $str);
        $sql .= " AND name LIKE '%$str%'";
    }

    if (!empty($limit)) {
        $sql .= " LIMIT $limit";
    }

    // Execute the query
    $res = mysqli_query($con, $sql);

    if (!$res) {
        die('Query Failed: ' . mysqli_error($con));
    }

    $data = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }

    return $data;
}


?>