<?php

include 'conexiune.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin page</title>

 <!-- font awesome cdn link -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<!-- custom css file -->
<link rel="stylesheet" href="CSS/admin_style.css">

</head>
<body>

<?php include 'admin_header.php';?>

<section class="dashboard">

   <h1 class="title">dashboard</h1>

   <div class="box-container">

     <div class="box">
        <?php 
        $total_pendings = 0;
        $select_pendings= $conexiune->prepare("SELECT * FROM `orders` WHERE status_plata = ?");
        $pending = 'pending';
        $select_pendings->bind_param('s', $pending);
        $select_pendings->execute();
        $result_pending =  $select_pendings->get_result();
        while($fetch_pending = $result_pending->fetch_assoc()){
            $total_pendings += $fetch_pending['pret_total'];
        };
        ?>
        <h3>$<?= $total_pendings; ?>/-</h3>
        <p>total pendings</p>
        <a href="admin_orders.php" class="btn">see orders</a>
     </div>

     <div class="box">
        <?php 
        $total_completed = 0;
        $select_completed= $conexiune->prepare("SELECT * FROM `orders` WHERE status_plata = ?");
        $pending = 'completed';
        $select_completed->bind_param('s', $pending);
        $select_completed->execute();
        $result_completed =  $select_completed->get_result();
        while($fetch_completed = $result_completed->fetch_assoc()){
            $total_completed += $fetch_completed['pret_total'];
        };
        ?>
        <h3>$<?= $total_completed; ?>/-</h3>
        <p>completed orders</p>
        <a href="admin_orders.php" class="btn">see orders</a>
     </div>

     <div class="box">
        <?php 
        $select_orders= $conexiune->prepare("SELECT * FROM `orders`");
        $select_orders->execute();
        $result_orders =  $select_orders->get_result();
        $number_of_orders = $result_orders->num_rows;
        ?>
        <h3><?=  $number_of_orders; ?></h3>
        <p>orders placed</p>
        <a href="admin_orders.php" class="btn">see orders</a>
     </div>

     <div class="box">
        <?php 
        $select_products= $conexiune->prepare("SELECT * FROM `products`");
        $select_products->execute();
        $result_products =  $select_products->get_result();
        $number_of_products = $result_products->num_rows;
        ?>
        <h3><?=  $number_of_products; ?></h3>
        <p>products added</p>
        <a href="admin_products.php" class="btn">see products</a>
     </div>

     <div class="box">
        <?php 
        $select_users= $conexiune->prepare("SELECT * FROM `users` WHERE tip_user = ?");
        $tip_user = 'user';
        $select_users->bind_param('s', $tip_user);
        $select_users->execute();
        $result_users =  $select_users->get_result();
        $number_of_users= $result_users->num_rows;
        ?>
        <h3><?=  $number_of_users; ?></h3>
        <p>total users</p>
        <a href="admin_users.php" class="btn">see users</a>
     </div>

     <div class="box">
        <?php 
        $select_admins= $conexiune->prepare("SELECT * FROM `users` WHERE tip_user = ?");
        $tip_user = 'admin';
        $select_admins->bind_param('s', $tip_user);
        $select_admins->execute();
        $result_admins =  $select_admins->get_result();
        $number_of_admins= $result_admins->num_rows;
        ?>
        <h3><?=  $number_of_admins; ?></h3>
        <p>total admins</p>
        <a href="admin_users.php" class="btn">see admins</a>
     </div>

     <div class="box">
        <?php 
        $select_accounts= $conexiune->prepare("SELECT * FROM `users`");
        $select_accounts->execute();
        $result_accounts =  $select_accounts->get_result();
        $number_of_accounts = $result_accounts->num_rows;
        ?>
        <h3><?=  $number_of_accounts; ?></h3>
        <p>total accounts</p>
        <a href="admin_users.php" class="btn">see accounts</a>
     </div>

     <div class="box">
        <?php 
        $select_messages= $conexiune->prepare("SELECT * FROM `message`");
        $select_messages->execute();
        $result_messages =  $select_messages->get_result();
        $number_of_messages = $result_messages->num_rows;
        ?>
        <h3><?=  $number_of_messages; ?></h3>
        <p>total messages</p>
        <a href="admin_contacts.php" class="btn">see messages</a>
     </div>

   </div>

</section>


<script src="JS/script.js"></script>
</body>
</html>