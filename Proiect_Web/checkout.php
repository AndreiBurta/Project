<?php

include 'conexiune.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
};

if(isset($_POST['order'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);
    $address = 'flat no. '. $_POST['flat'] .' '. $_POST['street'] .' '. $_POST['city'] .' '. $_POST['state'] .' '. $_POST['country'] .' - '. $_POST['pin_code'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '';
    
    $cart_query = $conexiune->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $cart_query->bind_param('i', $user_id);
    $cart_query->execute();
    $result_cart = $cart_query->get_result();
    if($result_cart->num_rows > 0){
        while($cart_item = $result_cart->fetch_assoc()){
            $cart_products[] = $cart_item['nume'].' ( ' .$cart_item['cantitate'].' ) ';
            $sub_total = ($cart_item['pret'] * $cart_item['cantitate']);
            $cart_total += $sub_total;
        };
    };

    $total_products = implode(', ', $cart_products);

    $order_query = $conexiune->prepare("SELECT * FROM `orders` WHERE nume = ? AND numar =? AND email=? AND metoda=? AND
    adresa=? AND produse_total=? AND pret_total=?");
    $order_query->bind_param('ssssssi', $name, $number, $email, $method, $address, $total_products, $cart_total);
    $order_query->execute();
    $result_order = $order_query->get_result();

    if($cart_total == 0){
        $message[] = 'your cart is empty';
    }elseif($result_order->num_rows > 0){
       $message[] = 'order placed already!';
    }else{
        $insert_order = $conexiune->prepare("INSERT INTO `orders`(user_id, nume, numar, email, metoda, adresa, produse_total, pret_total, plasare, status_plata)
        VALUES (?,?,?,?,?,?,?,?,?,?)");
        $status_plata = 'pending';
        $insert_order->bind_param('issssssiss', $user_id, $name, $number, $email, $method, $address, $total_products, $cart_total, $placed_on,$status_plata);
        $insert_order->execute();
        $delete_cart = $conexiune->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $delete_cart->bind_param('i', $user_id);
        $delete_cart->execute();
        $message[] = 'order placed successfully!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>


 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<link rel="stylesheet" href="CSS/style.css">

</head>
<body>

<?php include 'header.php';?>

<section class="display-orders">

  <?php
     $cart_grand_total = 0;
     $select_cart_items = $conexiune->prepare("SELECT * FROM `cart` WHERE user_id = ?");
     $select_cart_items->bind_param('i', $user_id);
     $select_cart_items->execute();
     $result_select = $select_cart_items->get_result();
     if($result_select->num_rows > 0){
       while($fetch_cart_items = $result_select->fetch_assoc()){
           $cart_total_price = ($fetch_cart_items['pret'] * $fetch_cart_items['cantitate']);
           $cart_grand_total += $cart_total_price;
  ?>
   <p> <?= $fetch_cart_items['nume']; ?> <span>(<?= '$'. $fetch_cart_items['pret'].'/- x  '.  $fetch_cart_items['cantitate']; ?>)</span> </p>
  <?php
       }
    }else{
   echo '<p class="empty">your cart is empty!</p>';
   }
  ?>

  <div class="grand-total">grand total: <span>$<?= $cart_grand_total; ?>/</span></div>

</section>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>place your order</h3>

   <div class="flex">
      <div class="inputBox">
        <span>name: </span>
        <input type="text" name="name" placeholder="enter your name" class="box" required>
      </div>
      <div class="inputBox">
        <span>number: </span>
        <input type="number" name="number" placeholder="enter your number" class="box" required>
      </div>
      <div class="inputBox">
        <span>email: </span>
        <input type="email" name="email" placeholder="enter your email" class="box" required>
      </div>
      <div class="inputBox">
        <span>payment method: </span>
         <select name="method" class="box" required>
            <option value="cash on delivery">cash on delivery</option>
            <option value="credit card">credit card</option>
            <option value="paypal">paypal</option>
         </select>
      </div>
      <div class="inputBox">
        <span>address line 1: </span>
        <input type="text" name="flat" placeholder="enter address number" class="box" required>
      </div>
      <div class="inputBox">
        <span>address line 2: </span>
        <input type="text" name="street" placeholder="enter street name" class="box" required>
      </div>
      <div class="inputBox">
        <span>city: </span>
        <input type="text" name="city" placeholder="enter cluj" class="box" required>
      </div>
      <div class="inputBox">
        <span>continent: </span>
        <input type="text" name="state" placeholder="enter europa" class="box" required>
      </div>
      <div class="inputBox">
        <span>country: </span>
        <input type="text" name="country" placeholder="enter romania" class="box" required>
      </div>
      <div class="inputBox">
        <span>pin code: </span>
        <input type="number" min="0" name="pin_code" placeholder="enter 12345" class="box" required>
      </div>

      <input type="submit" name="order" class="btn  <?= ($cart_grand_total > 1)?'':'disabled'; ?>" value="place order">
      
   </div>

   </form>

</section>


<?php include 'footer.php';
?>
<script src="JS/script.js"></script>
</body>
</html>