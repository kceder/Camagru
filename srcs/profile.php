<?php
    session_start();
    require_once('connect.php');
    if(!isset($_SESSION['logged_in_user']))
        header('Location: ../index.php');
?>
<!DOCTYPE html>
<html>
<title>Camagru</title>
    <p class="login"><?php if(isset($_SESSION['logged_in_user']))
            echo 'Logged in as: '.$_SESSION['logged_in_user'];?></p>
    <h1>C A M A G R U</h1>
    <div class="headers">
        <a href="home.php">HOME</a> | 
        <a href="profile.php">PROFILE</a> | 
        <a href="camera.php">CAMERA</a> | 
        <a class="" href="edit.php">EDIT PROFILE</a> |
        <a class="logout" href="logout.php">LOG OUT</a> 
    </div>
    <br>
    <br>
    <style>
    .login {
        font-style: italic;
        margin-left: 9px;
        font-size: 1.5vh;
    }
    .headers {
        font-size: 2.4vh;
        color: black;
        text-align: center;
        padding: 15px 25px;
        border: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    h1 {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        text-align: center;
    }
    .main-container {
        width: 90vw;
        min-height: 10vh;
        max-width: 600px;
        display: flex;
        justify-content: center;
        text-align: center;
        flex-wrap: wrap;
        padding: 1vw;
        border-radius: 24px;
        border-style: groove;
        border-color: #5EBEC4;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 1.4vh;
        background: #FDF5DF;
        margin-right: auto;
        margin-left: auto;
    }
    img{
        padding: 10px;
        width: 42vw;
        max-width: 180px;
        transform: rotateY(180deg);
        -webkit-transform:rotateY(180deg); /* Safari and Chrome */
        -moz-transform:rotateY(180deg); /* Firefox */
        border-radius: 24px;
    }
        a:link { text-decoration: none; }
        a:visited { text-decoration: none; }
        a:hover { text-decoration: underline; }
        a:active { text-decoration: underline; }
        a {
            color: black;
        }
        body {
        background: rgb(94,190,196);
        background: radial-gradient(circle, rgba(94,190,196,1) 0%, rgba(253,245,223,1) 87%);
    }
    .footer {
        font-style: italic;
        margin-right: 9px;
        font-size: 1.5vh;
        text-align: right;
        color: #9ec2bd;
    }
    </style>
    <body>
        <div id="image_container" class="main-container">
            <?php
            if(isset($_SESSION['logged_in_user'])) {
                try {
                $user = $_SESSION['logged_in_user'];
                $snap_stat = 1;
                $conn = connect();
                $sql = "SELECT img_path
                        FROM user_images
                        WHERE username='$user'
                        ORDER BY id DESC";
                $stmt = $conn->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result)
                {
                    foreach($result as $private_image){ 
                    ?>
                    <div class="image-container">
                        <img class=""  src=<?php echo $private_image['img_path'];?>>
                        <form action="delete_img.php" method="POST" class="">
                            <button class="" type="submit" name="delete_image" onClick="">
                                <input class="" type="hidden" name="delete_image" value="<?php echo $private_image['img_path'];?>">
                                X</button>
                            </form>
                        </div>
                    <?php }
                    }
                }
            catch(PDOException $e)
            {
                echo $stmt . "<br>" . $e->getMessage();
            }
        }
            ?>
	</div>
    <footer class="footer">
        <br>
        <span>kceder @ HIVE Helsinki 2022</span>
    </footer>
</body>
</html>