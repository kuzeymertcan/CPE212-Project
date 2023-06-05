<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

$message = array();

if(isset($_POST['send'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);
    
    $timestamp = date('Y-m-d H:i:s');

    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

    if(mysqli_num_rows($select_message) > 0){
        $message[] = 'Mesaj zaten gönderildi!';
    }else{
        mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message, sent_at) VALUES('$user_id', '$name', '$email', '$number', '$msg', '$timestamp')") or die('query failed');
        $message[] = 'Mesaj başarıyla gönderildi!';
    }

}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>İletişim</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>İLETİŞİME GEÇ</h3>
    <p> <a href="home.php">Ana Sayfa</a> / İletişim </p>
</section>

<section class="contact">

    <form action="" method="POST">
        <h3>BİZE MESAJ GÖNDERİN!</h3>
        <input type="text" name="name" placeholder="İsminizi girin" class="box" required> 
        <input type="email" name="email" placeholder="E-posta adresinizi girin" class="box" required>
        <input type="number" name="number" placeholder="Telefon numaranızı girin" class="box" required>
        <textarea name="message" class="box" placeholder="Mesajınızı girin" required cols="30" rows="10"></textarea>
        <input type="submit" value="Mesaj Gönder" name="send" class="btn">
    </form>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
