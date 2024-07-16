<?php

include 'conexiune.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){

    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
     $p_name = $_POST['p_name'];
     $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
     $p_price = $_POST['p_price'];
     $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
     $p_image = $_POST['p_image'];
     $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

     $check_wishlist_number = $conexiune->prepare("SELECT * FROM `addlist` WHERE nume=? AND user_id = ?");
     $check_wishlist_number->bind_param('si', $p_name, $user_id);
     $check_wishlist_number->execute();
     $result_check = $check_wishlist_number->get_result();

     $check_cart_number = $conexiune->prepare("SELECT * FROM `cart` WHERE nume=? AND user_id = ?");
     $check_cart_number->bind_param('si', $p_name, $user_id);
     $check_cart_number->execute();
     $result_checkcart = $check_cart_number->get_result();

     if($result_check->num_rows > 0){
        $message[] = 'already added to list!';
     }elseif($result_checkcart->num_rows > 0){
        $message[] = 'already added to cart!';
     }else{
        $insert_wishlist = $conexiune->prepare("INSERT INTO `addlist`(user_id, cid, nume, pret, imagine) VALUES (?,?,?,?,?)");
        $insert_wishlist->bind_param('iisis', $user_id, $pid, $p_name, $p_price, $p_image);
        $insert_wishlist->execute();
        $message[] = 'added to list!';
     }
}

if(isset($_POST['add_to_cart'])){

    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
     $p_name = $_POST['p_name'];
     $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
     $p_price = $_POST['p_price'];
     $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
     $p_image = $_POST['p_image'];
     $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
     $p_qty = $_POST['p_qty'];
     $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);


     $check_cart_number = $conexiune->prepare("SELECT * FROM `cart` WHERE nume=? AND user_id = ?");
     $check_cart_number->bind_param('si', $p_name, $user_id);
     $check_cart_number->execute();
     $result_checkcart = $check_cart_number->get_result();

     if($result_checkcart->num_rows > 0){
        $message[] = 'already added to cart!';
     }else{

        $check_wishlist_number = $conexiune->prepare("SELECT * FROM `addlist` WHERE nume=? AND user_id = ?");
        $check_wishlist_number->bind_param('si', $p_name, $user_id);
        $check_wishlist_number->execute();
        $result_check = $check_wishlist_number->get_result();

        if($result_check->num_rows > 0){
            $delete_wishlist = $conexiune->prepare("DELETE  FROM `addlist` WHERE nume=? AND user_id = ?");
            $delete_wishlist->bind_param('si', $p_name, $user_id);
            $delete_wishlist->execute();
        }

        $insert_cart = $conexiune->prepare("INSERT INTO `cart`(user_id, cid, nume, pret, cantitate, imagine) VALUES (?,?,?,?,?,?)");
        $insert_cart->bind_param('iisiis', $user_id, $pid, $p_name, $p_price, $p_qty, $p_image);
        $insert_cart->execute();
        $message[] = 'added to cart!';
     }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>search page</title>

    
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<link rel="stylesheet" href="CSS/style.css">

</head>
<body>

<?php include 'header.php';?>

<section class="search-form">

    <form action="" method="POST">
        <input type="text" class="box" name="search_box" placeholder="search products">
        <input type="submit" name="search_btn" value="search" class="btn">
    </form>

</section>

<?php 

  if(isset($_POST['search_btn'])){
    
   


?>

<section class="products" style="padding-top: 0;">

   <div class="box-container">

    <?php 
      $search_box = $_POST['search_box'];
      $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);
      $select_products = $conexiune->prepare("SELECT * FROM `products` WHERE nume LIKE '%{$search_box}%' OR categorie LIKE '%{$search_box}%'");
      $select_products->execute();
      $result_products = $select_products->get_result();
      if($result_products->num_rows > 0){
        while($fetch_products = $result_products->fetch_assoc()){
    ?>

    <form action="" class="box" method ="POST">
        <div class="price">$<span><?= $fetch_products['pret']; ?></span>/</div>
        <a href="view_page.php?cid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
        <img src="intrare_img/<?= $fetch_products['imagine']; ?>" alt="">
        <div class="name"><?= $fetch_products['nume']; ?></div>
        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
        <input type="hidden" name="p_name" value="<?= $fetch_products['nume']; ?>">
        <input type="hidden" name="p_price" value="<?= $fetch_products['pret']; ?>">
        <input type="hidden" name="p_image" value="<?= $fetch_products['imagine']; ?>">
        <input type="number" min="1" value="1" name="p_qty" class = "qty">
        <input type="submit" value="add to wishlist" class="option-btn" name= "add_to_wishlist">
        <input type="submit" value="add to cart" class="btn" name= "add_to_cart">
    </form>

    <?php
    }
    }else{
     echo '<p class="empty">no result found!</p>';
    }
    ?>
 

   </div>

</section>

<?php 

};
?>

<?php include 'footer.php';
?>
<script src="JS/script.js"></script>
</body>
</html>