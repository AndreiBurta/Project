<?php


if(isset($message)){
    foreach($message as $message){
        echo '<div class="message">
        <span>'.$message.'</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
    }
}
?>

<header class="header">

   <div class="flex">

    <a href="admin_page.php" class="logo">NutriBalance<span>.</span></a>

    <nav class="navbar">
        <a href="home.php">home</a>
        <a href="shop.php">shop</a>
        <a href="orders.php">orders</a>
        <a href="about.php">about</a>
        <a href="contact.php">contact</a>
    </nav>

    <div class="icons">
        <div id="menu-btn" class="fas fa-bars"></div>
        <div id="user-btn" class="fas fa-user"></div>
        <a href="search_page.php" class="fas fa-search"></a>
        <?php
             $count_cart_items = $conexiune->prepare("SELECT * FROM `cart` WHERE user_id= ?");
             $count_cart_items->bind_param('i', $user_id);
             $count_cart_items->execute();
             $result_count = $count_cart_items->get_result();

             $count_wishlist_items = $conexiune->prepare("SELECT * FROM `addlist` WHERE user_id= ?");
             $count_wishlist_items->bind_param('i', $user_id);
             $count_wishlist_items->execute();
             $result_countwish = $count_wishlist_items->get_result();
    
        ?>
        <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $result_countwish->num_rows; ?>)</span></a>
        <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $result_count->num_rows; ?>)</span></a>
    </div>

    <div class="profile">
        <?php     
    $select_profile = $conexiune->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_profile->bind_param('i', $user_id);
    $select_profile->execute();
    $result_profile = $select_profile->get_result();
    $fetch_profile = $result_profile->fetch_assoc();
    ?>
    <img src="intrare_img/<?= $fetch_profile['imagine']; ?>" alt=""> 
    <p><?= $fetch_profile['nume']; ?></p>
    <a href="user_profile_update.php" class="btn">update profile</a>
    <a href="logout.php" class="delete-btn">logout</a>
    <div class="flex-btn">
       <a href="login.php" class ="option-btn">login</a>
       <a href="inregistrare.php" class ="option-btn">Register</a>
    </div>

    </div>

   </div>

</header>