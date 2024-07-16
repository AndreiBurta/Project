<?php

include 'conexiune.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:login.php');
};

if(isset($_POST['add_product'])){
   
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'intrare_img/'.$image;
    
    $select_products = $conexiune->prepare("SELECT * FROM `products` WHERE nume = ?");
    $select_products->bind_param('s', $name);
    $select_products->execute();
    $result_products =  $select_products->get_result();
     
    if($result_products->num_rows > 0){
        $message[] = 'product name already exist';
    } else{
        $insert_products = $conexiune->prepare("INSERT INTO `products` (nume, categorie, detalii, pret, imagine) VALUES(?,?,?,?,?)");
        $insert_products->bind_param('sssis', $name, $category, $details, $price, $image);
        $insert_products->execute();

        if($insert_products){
           if($image_size > 2000000){
              $message[] = 'image size is too large!';
           }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'new product added!';
           }

        }
    }
};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = $conexiune->prepare("SELECT imagine FROM `products` WHERE id = ?");
   $select_delete_image->bind_param('i', $delete_id);
   $select_delete_image->execute();
   $result_delete = $select_delete_image->get_result();
   $fetch_delete = $result_delete->fetch_assoc(); 
   unlink('intrare_img/'.$fetch_delete['imagine']);
   $delete_product = $conexiune->prepare("DELETE  FROM `products` WHERE id = ?");
   $delete_product->bind_param('i',  $delete_id);
   $delete_product->execute();
   $delete_product->close();

   $delete_addlist = $conexiune->prepare("DELETE  FROM `addlist` WHERE cid = ?");
   $delete_addlist->bind_param('i',  $delete_id);
   $delete_addlist->execute();
   $delete_addlist->close();

   $delete_cart = $conexiune->prepare("DELETE  FROM `cart` WHERE cid = ?");
   $delete_cart->bind_param('i',  $delete_id);
   $delete_cart->execute();
   $delete_cart->close();
   header('location:admin_products.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>

 <!-- font awesome cdn link -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<!-- custom css file -->
<link rel="stylesheet" href="CSS/admin_style.css">

</head>
<body>

<?php include 'admin_header.php';?>

<section class="add-products">

    <h1 class="title">add products</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="flex">
           <div class="inputBox">
           <input type="text" name="name" class="box" required placeholder="enter product name">
           <select name="category" class="box" required>
            <option value="" selected disabled>select category</option>
            <option value="vegitables">vegitables</option>
            <option value="fruits">fruits</option>
            <option value="meat">meat</option>
            <option value="fish">fish</option>
           </select>
           </div>
           <div class="inputBox">
           <input type="number" min="0" name="price" class="box" required placeholder="enter product price">
           <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png">
           </div>
           <textarea name="details" class="box" required placeholder="enter product details" cols="30" rows="10"></textarea>
            <input type="submit" class="btn" value="add product" name="add_product">
        </div>
    </form>

</section>

<section class="show-products">

   <h1 class="title">products added</h1>

  

   <div class="box-container">

    <?php 
    $show_products = $conexiune->prepare("SELECT * FROM `products`");
    $show_products->execute();
    $result_products = $show_products->get_result();
    if($result_products->num_rows > 0){
       while($fetch_products=$result_products->fetch_assoc()){
    ?>
    <div class="box">
        <div class="price">$<?= $fetch_products['pret']; ?>/-</div>
        <img src="intrare_img/<?= $fetch_products['imagine']; ?>" alt="">
        <div class="name"><?= $fetch_products['nume']; ?></div>
        <div class="cat"><?= $fetch_products['categorie']; ?></div>
        <div class="details"><?= $fetch_products['detalii']; ?></div>
        <div class="flex-btn">
            <a href="admin_update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
            <a href="admin_products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?')">delete</a>
        </div>
    </div>
    <?php  
    }
  }else{
   echo ' <p class="empty">no products added yet!</p>';
}
?>

   </div>

</section>


<script src="JS/script.js"></script>
</body>
</html>