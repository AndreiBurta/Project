<?php

include 'conexiune.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
};

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

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_wishlist_item = $conexiune->prepare("DELETE FROM `addlist` WHERE id = ?");
    $delete_wishlist_item->bind_param('i', $delete_id);
    $delete_wishlist_item->execute();
    header('location: wishlist.php');
};

if(isset($_GET['delete_all'])){

    $delete_wishlist_item = $conexiune->prepare("DELETE FROM `addlist` WHERE user_id = ?");
    $delete_wishlist_item->bind_param('i', $user_id);
    $delete_wishlist_item->execute();
    header('location: wishlist.php');
};


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wishlist</title>


 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<link rel="stylesheet" href="CSS/style.css">

</head>
<body>

<?php include 'header.php';
?>

<section class="wishlist">

  <h1 class="title">products added</h1>

    <div class="box-container">
    
    <?php 
      $grand_total = 0;
      $select_wishlist = $conexiune->prepare("SELECT * FROM `addlist` WHERE user_id =?");
      $select_wishlist->bind_param('i', $user_id);
      $select_wishlist->execute();
      $result_wishlist = $select_wishlist->get_result();

      if($result_wishlist->num_rows > 0){
           while($fetch_wishlist = $result_wishlist->fetch_assoc()){
    ?>
     <form action="" method="POST" class="box">
        <a href="wishlist.php?delete=<?= $fetch_wishlist['id']; ?>" class = "fas fa-times" onclick="return confirm('you want to delete this?');"></a>
        <a href="view_page.php?cid=<?= $fetch_wishlist['cid']; ?>" class="fas fa-eye"></a>
        <img src="intrare_img/<?= $fetch_wishlist['imagine']; ?>" alt="">
        <div class="name"><?= $fetch_wishlist['nume']; ?></div>
        <div class="price">$<?= $fetch_wishlist['pret']; ?>/</div>
        <input type="number" min="1" value="1" class="qty" name="p_qty">
        <input type="hidden" name="pid" value="<?= $fetch_wishlist['cid']; ?>">
        <input type="hidden" name="p_name" value="<?= $fetch_wishlist['nume']; ?>">
        <input type="hidden" name="p_price" value="<?= $fetch_wishlist['pret']; ?>">
        <input type="hidden" name="p_image" value="<?= $fetch_wishlist['imagine']; ?>">
        <input type="submit" value="add to cart" name = "add_to_cart" class="btn">

     </form>
    <?php 
      $grand_total += $fetch_wishlist['pret'];
      }
    }else{
       echo '<p class="empty">your wishlist is empty</p>';
    }
    ?>
    </div>

    <div class="wishlist-total">
       <p>grand total : <span>$<?= $grand_total; ?>/</span></p>
        <a href="shop.php" class="option-btn">continue shooping</a>
        <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled' ?>">delete all</a>
    </div>

</section>


<?php include 'footer.php';
?>
<script src="JS/script.js"></script>
</body>
</html>