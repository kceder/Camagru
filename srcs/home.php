<?php   
session_start();
        require_once('connect.php');
        include('comment.php');
?>
<!DOCTYPE html>
<html>
<title>Camagru</title>
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <p class="login"><?php if($_SESSION['logged_in_user'])
            echo 'Logged in as: '.$_SESSION['logged_in_user'];?></p>
    <h1>C A M A G R U</h1>
    <div class="headers">
        <a href="home.php">HOME</a> | 
        <a href="profile.php">PROFILE</a> | 
        <a href="camera.php">CAMERA</a> | 
        <?php 
        if($_SESSION['logged_in_user'])
            echo '<a class="logout" href="logout.php">LOG OUT</a>';
        else
            echo '<a class="logout" href="../index.php">LOG IN</a>';
        ?>
    </div>
    <style>
        
    .like-container{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px;
        font-style: bold;
        display: inline-grid;
        grid-template-columns: 1fr 1fr;
        margin-top: 0;
        padding: 0;
    }
    .button.submit-comment:hover, button.like:hover {
        opacity: 0.5;
        transform: scale(1.1);
        }
    .like{
        border-radius: none;
        border: none;
        cursor: pointer;
        width: 12%;
        transition: 0.3s opacity, 0.3s transform;
        margin-bottom: 1vh;
        margin-top: 0vw;
        background-color: inherit;
        }
    .like_count{
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin-top: 1vh;
    }
    .heart {
        width: 3vh;
        float: right;
        padding: 0vh;
    }
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
    .image_container {
        text-align: center;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-evenly;
        background: white;
        padding: 20px;
        border-radius: 24px;
        border-style: groove;
        border-color: #5EBEC4;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 1.4vh;
        background: #FDF5DF;
    }
    .footer {
        font-style: italic;
        margin-right: 9px;
        font-size: 1.5vh;
        text-align: right;
        color: #9ec2bd;
    }
    img{
        padding: 10px;
        width: 95%;
        transform: rotateY(180deg);
        -webkit-transform:rotateY(180deg);
        -moz-transform:rotateY(180deg);
        border-radius: 24px;
    }
    .comments{
        max-height: 16vh;
        max-width: 90%;
        overflow-y: auto;
        padding: 2%;
        margin: 2%;
        background: transparent;
    }
    .single_comment {
        background: inherit;
        padding: 7px;
    }
    h1 {
        margin-left: auto; margin-right: auto;
    }
    .main {
        margin-left: auto;
        margin-right: auto;
        width: 94vw;
        max-width: 500px;
    }
    body {
        background: rgb(94,190,196);
        background: radial-gradient(circle, rgba(94,190,196,1) 0%, rgba(253,245,223,1) 87%);
    }
    a:link { text-decoration: none; }
    a:visited { text-decoration: none; }
    a:hover { text-decoration: underline; }
    a:active { text-decoration: underline; }
    a {
        color: black;
    }
    .name {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-weight: bold;
        font-style: italic;
        color: black;
        text-align: center;

    }
    .comment-time {
        font-size: xx-small;
    }
    .comment-user {
        font-weight: bold;
    }
    .comment-text .comment-user {
        font-size: large;
    }
    .comment-button {
        background: #f0ebe5;
        border-width: 1px;
        border-radius: 5px 5px 5px 5px;
        cursor: pointer;
        text-transform: uppercase;
        box-shadow: 0px 2px 6px 0px rgba(0, 0, 0, 0.25);
    }
    .comment-button:hover {
        background: #d4cbc1;
    }
    #comment {
        border: none;
        background: #f0ebe5;
        padding: 5px 10px;
        border-radius: 5px 5px 5px 5px;
        transition: all 0.2s;
        margin-top: 15px;
        width:60%;
        rows:"10";
        margin-bottom:1vh;
        margin-top:0vh;
        box-shadow: 0px 2px 6px 0px rgba(0, 0, 0, 0.25);
    }
    .next .prev {
        cursor: pointer;
    }
    .pages {
        text-align: center;
        color: black;
        border: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .arrow {
        width: 2vh;
    }
    </style>
    <body>
        <div class="main">
            <?php
                if (isset($_GET['page_nro']) && $_GET['page_nro']!="")
                    $page_nro = $_GET['page_nro'];
                else
                    $page_nro = 1;
                $count_on_page = 5;
                $offset = ($page_nro-1) * $count_on_page;
                $prev = $page_nro - 1;
                $next = $page_nro + 1;
                $adjacents = "2";
                $conn = connect();
                $img_count = "SELECT COUNT(*) FROM user_images";
                $img_count = $conn->query($img_count);
                $img_count = $img_count->fetchAll(PDO::FETCH_ASSOC);
                $img_count = $img_count[0]['COUNT(*)'];
                $page_count = ceil($img_count/$count_on_page);
                try {
                $conn = connect();
                $sql = "SELECT img_path, username FROM user_images ORDER BY id DESC LIMIT $offset, $count_on_page";
                $stmt = $conn->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $conn = connect();
                
                if($result)
                {
                    foreach($result as $k){ 
                        $like_count = "SELECT COUNT(*) FROM image_likes WHERE img_path='$k[img_path]'";
                        $like_count = $conn->query($like_count);
                        $like_count = $like_count->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div id="image_container" class="image_container">
                        <p class="name">
                            <?php echo $k['username'];?>
                        </p>
                        <img class="" src=<?php echo $k['img_path'];?>>
                        <div class="like-container">
                            <form class="likes" action="likes_count.php" method="POST">
                                <button  class="like" type="like" name="like" value="OK"><img class="heart" src="../images/html_images/heart.png" width="25" alt="del"></button>
                                <input type="hidden" name="liked_img" value="<?php echo $k['img_path'];?>">
                            </form>
                            <p class="like_count">LIKES: <?php echo $like_count[0]['COUNT(*)'];?></p>
                        </div>
                        <div class="comments">
                            <?php
                            $conn = connect();
                            $sql = "SELECT comment, username, time_stamp FROM image_comments WHERE img_path='$k[img_path]' ORDER BY id DESC";
                            $stmt = $conn->query($sql);
                            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            if($comments) {
                                
                                foreach($comments as $c){
                                    ?>
                                    <div class="single_comment">
                                        <p class="comment-time"><?php echo $c['time_stamp'];?></p>
                                        <span class="comment-user"><?php echo $c['username'];?></span>
                                        <span class="comment-text"><?php echo $c['comment'];?></span>
                                    </div>
                                    <?php
                            }
                        }
                        ?>
                    </div>
                    <?php
                        if($_SESSION['logged_in_user']){ ?>
                    <br>
                    <form class="form" action="comment.php" method="POST">   
                        <textarea name="comment" id="comment" rows="1" placeholder=" Write a comment..."></textarea><br/>
                        <input type="hidden" name="img_path" value="<?php echo $k['img_path'];?>">
                        <input type="submit" class="comment-button" value="Post" name="OK">
                    </form> <?php
                } ?>
                    </div>
                    <br>
                    <?php
                }
                ?>
                <div class="pages">
			    <?php if($page_nro > 1) {?>
                    <a class="prev" <?php echo "href='?page_nro=$prev'"; ?>><img class="arrow" src="../images/html_images/right-arrow.png"></a><?php } ?>
                <?php if($page_nro < $page_count) {?>
			        <a class="next" <?php echo "href='?page_nro=$next'";?>><img class="arrow" src="../images/html_images/left-arrow.png"></a><?php } ?>
            <?php
                }
            }
            catch(PDOException $e) {
                echo $stmt . "<br>" . $e->getMessage();
            }
            ?>
	</div>
</div>
</body>
<footer class="footer">
    <br>
    <span>Author: kceder @ HIVE Helsinki 2022</span>
</footer>
</html>