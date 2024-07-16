<?php

include 'conexiune.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_cart_item = $conexiune->prepare("DELETE FROM `cart` WHERE id = ?");
    $delete_cart_item->bind_param('i', $delete_id);
    $delete_cart_item->execute();
    header('location: cart.php');
};

if(isset($_GET['delete_all'])){
    $delete_cart_item = $conexiune->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart_item->bind_param('i', $user_id);
    $delete_cart_item->execute();
    header('location: cart.php');
};

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);
   $update_qty = $conexiune->prepare("UPDATE `cart` SET cantitate = ? WHERE id = ?");
   $update_qty->bind_param('ii', $p_qty, $cart_id);
   $update_qty->execute();
   $message[] = 'cart quantity updated';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>

   
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<link rel="stylesheet" href="CSS/style.css">

</head>
<body>

<?php include 'header.php';?>

<section class="shopping-cart">

  <h1 class="title">products added</h1>

    <div class="box-container">
    
    <?php 
      $grand_total = 0;
      $select_cart = $conexiune->prepare("SELECT * FROM `cart` WHERE user_id =?");
      $select_cart->bind_param('i', $user_id);
      $select_cart->execute();
      $result_cart = $select_cart->get_result();

      if($result_cart->num_rows > 0){
           while($fetch_cart = $result_cart->fetch_assoc()){
    ?>
     <form action="" method="POST" class="box">
        <a href="cart.php?delete=<?= $fetch_cart['id']; ?>" class = "fas fa-times" onclick="return confirm('you want to delete this?');"></a>
        <a href="view_page.php?cid=<?= $fetch_cart['cid']; ?>" class="fas fa-eye"></a>
        <img src="intrare_img/<?= $fetch_cart['imagine']; ?>" alt="">
        <div class="name"><?= $fetch_cart['nume']; ?></div>
        <div class="price">$<?= $fetch_cart['pret']; ?>/</div>
        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
        <div class="flex-btn">
          <input type="number" min="1" value="<?= $fetch_cart['cantitate']; ?>" class="qty" name="p_qty">
          <input type="submit" value="update" name= "update_qty" class="option-btn">
        </div>
         <div class="sub-total">sub total : <span>$<?= $sub_total = ($fetch_cart['pret'] * $fetch_cart['cantitate']); ?>/</span> </div>
     </form>
    <?php 
      $grand_total += $sub_total;
      }
    }else{
       echo '<p class="empty">your cart is empty</p>';
    }
    ?>
    </div>

    <div class="cart-total">
       <p>grand total : <span>$<?= $grand_total; ?>/</span></p>
        <a href="shop.php" class="option-btn">continue shooping</a>
        <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled' ?>">delete all</a>
        <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled' ?>">proceed to checkout</a>
    </div>

</section>





<?php include 'footer.php';
?>
<script src="JS/script.js"></script>
</body>
</html>