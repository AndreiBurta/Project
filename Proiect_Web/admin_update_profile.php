<?php

include 'conexiune.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:login.php');
}

if(isset($_POST['update_profile'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $update_profile = $conexiune->prepare("UPDATE `users` SET nume = ?, email = ? WHERE id = ?");
    $update_profile->bind_param('ssi',$name, $email, $admin_id);
    $update_profile->execute(); 
    $result_profile = $update_profile->get_result();

    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'intrare_img/'.$image;
    $old_image = $_POST['old_image'];

    if(!empty($image)){
        if($image_size > 2000000){
            $message[] = 'Image size is to large!';
        } else{
            $update_image = $conexiune->prepare("UPDATE `users` SET imagine = ? WHERE id = ?");
            $update_image->bind_param('si',$image, $admin_id);
            $update_image->execute(); 
            if($update_image){
                move_uploaded_file($image_tmp_name, $image_folder);
                unlink('intrare_img/'.$old_image);
                $message[] = 'image updated successfully!';
            };
        };
    };

   $old_password = $_POST['old_password'];
   $update_password = md5($_POST['update_password']);
   $update_password = filter_var($update_password, FILTER_SANITIZE_STRING);
   $new_password = md5($_POST['new_password']);
   $new_password = filter_var($new_password, FILTER_SANITIZE_STRING);
   $confirm_password = md5($_POST['confirm_password']);
   $confirm_password = filter_var($confirm_password, FILTER_SANITIZE_STRING);

   if(!empty($update_password) OR !empty($new_password) OR !empty($confirm_password)){
    if($update_password != $old_password){
        $message[] = 'old password not matched';
    } elseif($new_password != $confirm_password){
        $message[] = 'confirm password not matched';
    } else{
        $update_password_query = $conexiune->prepare("UPDATE `users` SET parola = ? WHERE id = ?");
        $update_password_query->bind_param('si',$confirm_password, $admin_id);
        $update_password_query->execute(); 
        $message[] = 'password updated successfully!';
    }
   } 

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile Admin</title>


 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<link rel="stylesheet" href="CSS/componente.css">

</head>
<body>

<?php include 'admin_header.php';?>

<section class="update-profile">

   <h1 class="title">update profile</h1>

  

   <form action="" method="POST" enctype="multipart/form-data">
   <img src="intrare_img/<?= $fetch_profile['imagine']; ?>" alt="">
    <div class="flex">
        <div class="inputBox">
        <span>username :</span>
        <input type="text" name="name" value="<?= $fetch_profile['nume']; ?>" placeholder="update username" required class="box">
        <span>email :</span>
        <input type="email" name="email" value="<?= $fetch_profile['email']; ?>" placeholder="update email" required class="box">
        <span>picture :</span>
        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
        <input type="hidden" name="old_image" value="<?= $fetch_profile['imagine']; ?>">
       </div>
        <div class="inputBox">
          <input type="hidden" name="old_password" value="<?= $fetch_profile['parola']; ?>">
          <span>old password :</span>
          <input type="password" name="update_password" placeholder="enter previes password" class="box">
          <span>new password :</span>
          <input type="password" name="new_password" placeholder="enter new password" class="box">
          <span>confirm password :</span>
          <input type="password" name="confirm_password" placeholder="confirm new password" class="box">
        
       </div>
    </div>
     <div class="flex-btn">
           <input type="submit" class="btn" value="update profile" name="update_profile">
           <a href="admin_page.php" class="option-btn">go back</a>
     </div>

   </form>

</section>


<script src="JS/script.js"></script>
</body>
</html>