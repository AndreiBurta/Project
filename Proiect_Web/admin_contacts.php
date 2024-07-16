<?php

include 'conexiune.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:login.php');
}

if(isset($_GET['delete'])){
    
    $delete_id = $_GET['delete'];
    $delete_message = $conexiune->prepare('DELETE FROM `message` WHERE id = ?');
    $delete_message->bind_param('i', $delete_id);
    $delete_message->execute();
    header('location:admin_contacts.php');
    
  
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>messages</title>


 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<link rel="stylesheet" href="CSS/admin_style.css">

</head>
<body>

<?php include 'admin_header.php';?>

<section class="messages">
    <h1 class="title">messages</h1>

    <div class="box-container">

    <?php 
       $select_message = $conexiune->prepare('SELECT * FROM `message`');
       $select_message->execute();
       $result_message = $select_message->get_result(); 
       if($result_message->num_rows > 0){
        while($fetch_message = $result_message->fetch_assoc()){
     
    ?>
    <div class="box">
        <p> user id : <span><?= $fetch_message['user_id']; ?></span></p>
        <p> name : <span><?= $fetch_message['nume']; ?></span></p>
        <p> number : <span><?= $fetch_message['numar']; ?></span></p>
        <p> email : <span><?= $fetch_message['email']; ?></span></p>
        <p> message : <span><?= $fetch_message['mesaj']; ?></span></p>
        <a href="admin_contacts.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete</a>
    </div>
    <?php    
        }
   }else{
    echo '<p class="empty">you have no messages!</p>';
   }

    ?>

    </div>

</section>


<script src="JS/script.js"></script>
</body>
</html>