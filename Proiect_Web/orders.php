<?php

include 'conexiune.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orders</title>


 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<link rel="stylesheet" href="CSS/style.css">

</head>
<body>

<?php include 'header.php';?>

<section class="placed-orders">
 
    <h1 class="title">placed orders</h1>

   <div class="box-container">

     <?php 
      $select_orders = $conexiune->prepare("SELECT * FROM `orders` WHERE user_id = ?");
      $select_orders->bind_param('i', $user_id);
      $select_orders->execute();
      $result_orders = $select_orders->get_result();
      if($result_orders->num_rows > 0){
          while($fetch_orders = $result_orders->fetch_assoc()){        
     ?>

     <div class="box">

       <p> placed on : <span><?= $fetch_orders['plasare']; ?></span></p>
       <p> name : <span><?= $fetch_orders['nume']; ?></span></p>
       <p> number: <span><?= $fetch_orders['numar']; ?></span></p>
       <p> email: <span><?= $fetch_orders['email']; ?></span></p>
       <p> address: <span><?= $fetch_orders['adresa']; ?></span></p>
       <p> payment method: <span><?= $fetch_orders['metoda']; ?></span></p>
       <p> your order: <span><?= $fetch_orders['produse_total']; ?></span></p>
       <p> total price: <span>$<?= $fetch_orders['pret_total']; ?>/</span></p>
       <p> payment status: <span style="color:<?php if($fetch_orders['status_plata'] == 'pending'){echo 'red';}else{echo 'green'; }; ?>"><?= $fetch_orders['status_plata']; ?></span></p>
        
     </div>

     <?php
     }
    }else{
     echo  '<p class="empty">no orders placed yet!</p>';
    }
     ?>

   </div>

</section>




<?php include 'footer.php';
?>
<script src="JS/script.js"></script>
</body>
</html>