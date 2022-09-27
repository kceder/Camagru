<?php
    session_start();
    require_once('connect.php');
    require_once('config/setup.php');
    if(!$_SESSION['logged_in_user'])
        header('Location: index.php');
    
    if (isset($_POST['image'])) {
        $img = $_POST['image'];
        $img = preg_replace("/data:image\/jpeg;base64,/", '', $img);
        $img = str_replace(' ', '+', $img);
        $img = base64_decode($img);
        $file = 'images/user_images/' . uniqid() . '.jpeg';
        $put_content = file_put_contents($file, $img);
        
    try {
        $img_name = basename($file);
        $user = $_SESSION['logged_in_user'];
        $conn = connect();
        $stmt = $conn->prepare("INSERT INTO user_images (username) VALUES (:username)");
        $stmt = $conn->prepare("INSERT INTO user_images (username, img_name, img_path) VALUES (:username, :img_name, :img_path)");
        $stmt->bindParam(':username', $user);
        $stmt->bindParam(':img_name', $img_name);
        $stmt->bindParam(':img_path', $file);
        $stmt->execute();

        if($_POST['sticker1'] == 1) {
            $src = imagecreatefrompng('images/stickers/sticker1.png');
            add_sticker($file, $src, 0, 0);
        }
        if($_POST['sticker2'] == 1) {
            $src = imagecreatefrompng('images/stickers/sticker2.png');
            add_sticker($file, $src, 50, 20);
        }
        if($_POST['sticker3'] == 1) {
            $src = imagecreatefrompng('images/stickers/sticker3.png');
            add_sticker($file, $src, 220, 200);
        }
        if($_POST['sticker4'] == 1) {
            $src = imagecreatefrompng('images/stickers/sticker4.png');
            add_sticker($file, $src, 200, 200);
        }
        if($_POST['sticker5'] == 1) {
            $src = imagecreatefrompng('images/stickers/sticker8.png');
            add_sticker($file, $src, -8, -5);
        }
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;
    }
    function add_sticker($file, $src, $margin_l, $margin_t){
        $img = imagecreatefromjpeg($file);
        $width = imagesx($src);
        $height = imagesy($src);
        imagecopy($img, $src, imagesx($img) - $width - $margin_l, imagesy($img) - $height - $margin_t, 0, 0, imagesx($src), imagesy($src));
        imagejpeg($img, $file);
        imagedestroy($img);
    }
?>