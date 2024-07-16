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
    <title>about</title>


 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<link rel="stylesheet" href="CSS/style.css">

</head>
<body>

<?php include 'header.php';?>

<section class="about">

   <div class="row">

    <div class="box">
      <img src="img/img10.png" alt="">
      <h3>why us?</h3>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum dolorem neque similique? Labore totam inventore ut,
         quis quidem iste placeat nam illum dolor autem perferendis. Cumque, ipsa deserunt.</p>
        <a href="contact.php" class="btn">contact us</a>
    </div>

    <div class="box">
      <img src="img/shop.png" alt="">
      <h3>what we offer?</h3>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum dolorem neque similique? Labore totam inventore ut,
         quis quidem iste placeat nam illum dolor autem perferendis. Cumque, ipsa deserunt.</p>
        <a href="shop.php" class="btn">shop</a>
    </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">reviews</h1>

   <div class="box-container">

   <div class="box">
    <img src="img/prs5.png" alt="">
    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur tenetur ex fuga delectus exercitationem velit et nostrum?</p>
    <div class="stars">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
    </div>
    <h3>andrei alex</h3>
   </div>

   <div class="box">
    <img src="img/prs7.png" alt="">
    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur tenetur ex fuga delectus exercitationem velit et nostrum?</p>
    <div class="stars">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
    </div>
    <h3>andrei alex</h3>
   </div>

   <div class="box">
    <img src="img/prs3.jpg" alt="">
    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur tenetur ex fuga delectus exercitationem velit et nostrum?</p>
    <div class="stars">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
    </div>
    <h3>andrei alex</h3>
   </div>

   <div class="box">
    <img src="img/prs4.jpg" alt="">
    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur tenetur ex fuga delectus exercitationem velit et nostrum?</p>
    <div class="stars">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
    </div>
    <h3>andrei alex</h3>
   </div>
    
   </div>
</section>




<?php include 'footer.php';
?>
<script src="JS/script.js"></script>
</body>
</html>