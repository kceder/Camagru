<?php
    session_start(); 
    require_once('connect.php');
    if(!$_SESSION['logged_in_user'])
        header('Location: index.php');
?>
<!DOCTYPE html>
<html>
    <p class="login">Logged in as: <?php echo $_SESSION['logged_in_user'];?></p>
    <h1>C A M A G R U</h1>
    <div class="headers">
        <a href="main_page.php">HOME</a> | 
        <a href="profile.php">PROFILE</a> | 
        <a href="camera.php">TAKE A PHOTO</a> | 
        <a class="logout" href="logout.php">LOG OUT</a> | 
        <a class="" href="edit.php">EDIT PROFILE</a>
    </div>
    <br>
    <br>
    <style>
    .login {
        font-style: italic;
        margin-left: 9px;
        font-size: 1vw;
    }
    .headers {
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
        width: 54vh;
        display: flex;
        text-align: center;
        flex-wrap: wrap;
        /* justify-content: space-evenly; */
        padding: 20px;
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
        width: 20vh;
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
        /* background: #FDF5DF; */
    }
    </style>
    <body>
        <div id="image_container" class="main-container">
            <?php
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
            catch(PDOException $e) {
                echo $stmt . "<br>" . $e->getMessage();
            }
            ?>
	</div>
</body>
<script>
       function del_message(){
        if (alert("Delete image?")) {
            
        }
    };
</script>
</html>