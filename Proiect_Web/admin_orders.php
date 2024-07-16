<?php

include 'conexiune.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:login.php');
};

if(isset($_POST['update_order'])){
    
  $order_id = $_POST['order_id'];
  $update_payment = $_POST['update_payment'];
  $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);
  $update_orders = $conexiune->prepare("UPDATE `orders` SET status_plata = ? WHERE id = ?");
  $update_orders->bind_param('si', $update_payment, $order_id);
  $update_orders->execute();
  $message[] = 'payment has been updated!';
};

if(isset($_GET['delete'])){
    
  $delete_id = $_GET['delete'];
  $delete_orders = $conexiune->prepare('DELETE FROM `orders` WHERE id = ?');
  $delete_orders->bind_param('i', $delete_id);
  $delete_orders->execute();
  header('location:admin_orders.php');
  

};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orders</title>


 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<link rel="stylesheet" href="CSS/admin_style.css">

</head>
<body>

<?php include 'admin_header.php';?>


<section class="place-orders">

<h1 class="title">placed orders</h1>

  <div class="box-container">

    <?php 
      $select_orders = $conexiune->prepare("SELECT * FROM `orders`");
      $select_orders->execute();
      $result_orders = $select_orders->get_result();
      if($result_orders->num_rows > 0){
        while($fetch_orders = $result_orders->fetch_assoc()){

       
    ?>
    <div class="box">
        <p> user id : <span><?=$fetch_orders['user_id']?></span> </p>
        <p> placed on : <span><?=$fetch_orders['plasare']?></span> </p>
        <p> name : <span><?=$fetch_orders['nume']?></span> </p>
        <p> email : <span><?=$fetch_orders['email']?></span> </p>
        <p> number : <span><?=$fetch_orders['numar']?></span> </p>
        <p> address : <span><?=$fetch_orders['adresa']?></span> </p>
        <p> total products : <span><?=$fetch_orders['produse_total']?></span> </p>
        <p> total price : <span>$<?=$fetch_orders['pret_total']?></span> </p>
        <p> payment method : <span><?=$fetch_orders['metoda']?></span> </p>
      
        <form action="" method="POST">
            <input type="hidden" name="order_id" value="<?=$fetch_orders['id']?>">
            <select name="update_payment" class="drop-down">
                <option value="" selected disabled><?=$fetch_orders['status_plata']?></option>
                <option value="pending">pending</option>
                <option value="completed">completed</option>
            </select>
           <div class="flex-btn">
              <input type="submit" name="update_order" class="option-btn" value="update">
              <a href="admin_orders.php?delete=<?=$fetch_orders['id']?>"class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
           </div> 
        </form>
    </div>

    <?php 
     }
    }else{
      echo '<p class="empty">no orders placed yet!</p>';
    }
    ?>

  </div>

</section>


<script src="JS/script.js"></script>
</body>
</html>