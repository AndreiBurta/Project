<?php 
   include 'conexiune.php';

   if(isset($_POST['submit'])){
         
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $password = md5($_POST['password']);
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    $cpassword = md5($_POST['cpassword']);
    $cpassword = filter_var($cpassword, FILTER_SANITIZE_STRING);
  
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'intrare_img/'.$image; 

    $select = $conexiune->prepare("SELECT * FROM `users` WHERE email = ?");
    $select->bind_param("s", $email);
    $select->execute();
    $result = $select->get_result();
    if($result->num_rows > 0){
    $message[] = 'This email already exists!';
    } else {
        if($password != $cpassword){
        $message[] = "Passwords don't match!";
         }else{
        $insert = $conexiune->prepare("INSERT INTO `users` (nume, email, parola, imagine, tip_user) VALUES (?, ?, ?, ?, ?)");
        $tip_user = 'user'; 
        $insert->bind_param("sssss", $name, $email, $password, $image, $tip_user);
        $insert->execute();
        if($insert){
             if($image_size > 2000000){
                $message[] = 'Image size is to large!';
             }else{
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Register successfully!';
                header('Location: login.php');
             }
        }
    }
    }
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inregistrare</title>


   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


   <link rel="stylesheet" href="CSS/componente.css">

</head>
<body>

<?php

if(isset($message)){
    foreach($message as $message){
        echo '<div class="message">
        <span>'.$message.'</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
    }
}

?>

<section class="form-container">
    <form action="" method="POST" enctype="multipart/form-data">
        <h3>register now</h3>
        <input type="text" name="name" class="box" placeholder="enter your name" required>
        <input type="email" name="email" class="box" placeholder="enter your email" required>
        <input type="password" name="password" class="box" placeholder="enter your password" required>
        <input type="password" name="cpassword" class="box" placeholder="confirm your password" required>
        <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png">
        <input type="submit" value="Register Now" class="btn" name="submit">
        <p>already have an account?<a href="login.php"> login now</a></p>
    </form>
</section>
    
</body>
</html>