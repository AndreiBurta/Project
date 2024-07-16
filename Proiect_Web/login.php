<?php 
   include 'conexiune.php';

   session_start();

   if(isset($_POST['submit'])){
      
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $password = md5($_POST['password']);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    $select = $conexiune->prepare("SELECT * FROM `users` WHERE email = ? AND parola = ?");
    $select->bind_param("ss", $email, $password);
    $select->execute();
    $result = $select->get_result();
    $row = $result->fetch_assoc();
    ;

    if($result->num_rows > 0){

       if($row['tip_user'] == 'admin'){

        $_SESSION['admin_id'] = $row['id'];
        header('location:admin_page.php');

       } elseif($row['tip_user'] == 'user'){

        $_SESSION['user_id'] = $row['id'];
        header('location:home.php');

       } else{
          $message[] = 'no user found!';
       }
    }else{
        $message[] = 'Wrong email or password';
    }

   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login In</title>


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
        <h3>Login In</h3>
        <input type="email" name="email" class="box" placeholder="enter your email" required>
        <input type="password" name="password" class="box" placeholder="enter your password" required>
        <input type="submit" value="Login" class="btn" name="submit">
        <p>don't have an account?<a href="inregistrare.php"> Sign up</a></p>
    </form>
</section>
    
</body>
</html>