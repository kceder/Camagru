<?php
session_start();
    require_once("connect.php");
    if(!$_SESSION['logged_in_user'])
        header('Location: main_page.php');

    $target_dir = "images/user_images/";
    $file = ($_FILES["file"]["name"]);
    $img_path = $target_dir . $file;
    $img_path = str_replace(" ", "", $img_path);
    $imageFileType = strtolower(pathinfo($img_path, PATHINFO_EXTENSION));
    $user = $_SESSION['logged_in_user'];
    $img_name = basename($file);

    if(isset($_POST["submit"])) 
    {
        if(getimagesize($_FILES["file"]["tmp_name"]) === false)
        {
            alert("File is not an image");
            header('Refresh: 3; camera.php');
            return;
        }
        else if ($_FILES["file"]["size"] > 1000000) 
        {
            alert("File over max size");
            header('Refresh: 3; camera.php');
            return;
        }
        else if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif")
        {
            alert("File must be .JPG, .JPEG, .PNG or .GIF");
            header('Refresh: 3; camera.php');
            return;
        }
        else 
        {
                $temp = explode(".", $_FILES["file"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir . $newfilename);
                $img_name = basename($newfilename);
                $img_path = $target_dir . $newfilename;
                $conn = connect();
                $stmt = $conn->prepare("INSERT INTO user_images (username, img_name, img_path)
                                        VALUES (:username, :img_name, :img_path)");
                $stmt->bindParam(':username', $user);
                $stmt->bindParam(':img_name', $img_name);
                $stmt->bindParam(':img_path', $img_path);
                $stmt->execute();
                $conn = null;
                if($imageFileType == "jpg" || $imageFileType == "jpeg")
                    $img = imagecreatefromjpeg($img_path);
                else if ($imageFileType == "png")
                    $img = imagecreatefrompng($img_path);
                else if ($imageFileType == "gif")
                    $img = imagecreatefromgif($img_path);
                    $size = getimagesize($img_path);
                    $w = $size[0] / 400;
                    $h = $size[1] / 300;
                    // $img = imagescale( $img, 400, 300);
                if($_POST['sticker1'] == 1) {
                    $src = imagecreatefrompng('images/stickers/sticker1.png');
                    // $w = $scale_w * (100 / $scale_w);
                    // $h = $scale_h * (71 / $scale_h);
                    // $src = imagescale($src, $w, $h);
                    add_sticker($img, $src, $w + 0, $h + 0, $img_path);
                }
                if($_POST['sticker2'] == 1) {
                    $src = imagecreatefrompng('images/stickers/sticker2.png');
                    // $w = $scale_w * (100 / $scale_w);
                    // $h = $scale_h * (71 / $scale_h);
                    // $src = imagescale($src, $w, $h);
                    add_sticker($img, $src, $w * 50, $h * 20, $img_path);
                }
                if($_POST['sticker3'] == 1) {
                    $src = imagecreatefrompng('images/stickers/sticker3.png');
                    // $src = imagescale($src, 1280 / $scale_w, 437 / $scale_h);
                    add_sticker($img, $src, $w * 220, $h * 200, $img_path);
                }
                if($_POST['sticker4'] == 1) {
                    $src = imagecreatefrompng('images/stickers/sticker4.png');
                    // $w = $scale_w * (100 / $scale_w);
                    // $h = $scale_h * (71 / $scale_h);
                    // $src = imagescale($src, $w, $h);
                    add_sticker($img, $src, $w + 200, $h + 200, $img_path);
                }
                if($_POST['sticker5'] == 1) {
                    $src = imagecreatefrompng('images/stickers/sticker5.png');
                    // $w = $scale_w * (100 / $scale_w);
                    // $h = $scale_h * (71 / $scale_h);
                    // $src = imagescale($src, $w, $h);
                    add_sticker($img, $src, $w * 100, $h * 15, $img_path);
                }
                imagedestroy($img);
               header("Location: camera.php");
        }
    }
    function add_sticker($img, $src, $margin_l, $margin_t, $img_path){
        $width = imagesx($src);
        $height = imagesy($src);
        imagecopy($img, $src, imagesx($img) - $width - $margin_l, imagesy($img) - $height - $margin_t, 0, 0, imagesx($src), imagesy($src));
        imagejpeg($img, $img_path);
        imagedestroy($img);
    }
?>