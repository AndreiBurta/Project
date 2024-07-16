<?php

include 'conexiune.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
};

if(isset($_POST['send'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $select_message = $conexiune->prepare("SELECT * FROM `message` WHERE nume = ? AND email = ? AND numar = ? AND mesaj = ?");
    $select_message->bind_param('ssss', $name, $email, $number, $msg);
    $select_message->execute();
    $result_message = $select_message->get_result();

    if($result_message->num_rows > 0){
        $message[] = 'already sent a message!';
    }else{
        $insert_message = $conexiune->prepare("INSERT INTO `message`(user_id, nume, email,numar, mesaj) VALUES(?,?,?,?,?)");
        $insert_message->bind_param('issss', $user_id, $name, $email, $number, $msg);
        $insert_message->execute();


        $message[] = 'message sent!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>

   
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<link rel="stylesheet" href="CSS/style.css">

</head>
<body>

<?php include 'header.php';?>

<section class="contact">

   <h1 class="title">contact us</h1>

  <form action="" method = "POST">
    <input type="text" name="name" class="box" required placeholder="enter your name">
    <input type="email" name="email" class="box" required placeholder="enter your email">
    <input type="number" name="number" class="box" required placeholder="enter your number">
    <textarea name="msg" class="box" required placeholder="enter your message" cols="30" rows="10"></textarea>
    <input type="submit" value="send message" class="btn" name="send">
  </form>


</section>




<?php include 'footer.php';
?>
<script src="JS/script.js"></script>
</body>
</html>