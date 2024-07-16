<?php

include 'conexiune.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:login.php');
};

if(isset($_GET['delete'])){
    
    $delete_id = $_GET['delete'];
    $delete_users = $conexiune->prepare('DELETE FROM `users` WHERE id = ?');
    $delete_users->bind_param('i', $delete_id);
    $delete_users->execute();
    header('location:admin_users.php');
    
  
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>users</title>


 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<link rel="stylesheet" href="CSS/admin_style.css">

</head>
<body>

<?php include 'admin_header.php';?>

<section class="user-accounts">

    <h1 class="title">user accounts</h1>

    <div class="box-container">

       <?php 
           $select_users = $conexiune->prepare('SELECT * FROM `users`');
           $select_users->execute();
           $result_select = $select_users->get_result();
           while($fetch_users = $result_select->fetch_assoc()){
                
           
       ?>
      <div class="box" style="<?php if($fetch_users['id'] == $admin_id){ echo 'display:none'; }; ?>">
        <img src="intrare_img/<?=$fetch_users['imagine'] ?>">
        <p> user id: <span><?=$fetch_users['id'] ?></span></p>
        <p> username: <span><?=$fetch_users['nume'] ?></span></p>
        <p> email: <span><?=$fetch_users['email'] ?></span></p>
        <p> user type: <span style=" color:<?php if($fetch_users['tip_user'] == 'admin'){ echo 'orange'; }; ?>"><?=$fetch_users['tip_user'] ?></span></p>
        <a href="admin_users.php?delete=<?=$fetch_users['id'] ?>" onclick="return confirm('delete this user?');" class="delete-btn">delete</a>

      </div>
      <?php 
        
      }   
      ?>
    </div>

</section>


<script src="JS/script.js"></script>
</body>
</html>