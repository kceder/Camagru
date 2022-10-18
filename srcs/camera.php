<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('connect.php');
if(!isset($_SESSION['logged_in_user']))
    header('Location: ../index.php');
?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
<head>
<title>Camagru</title>
<p class="login"><?php if(isset($_SESSION['logged_in_user']))
            echo 'Logged in as: '.$_SESSION['logged_in_user'];?></p>
    <h1>C A M A G R U</h1>
    <div class="headers">
        <a href="home.php">HOME</a> | 
        <a href="profile.php">PROFILE</a> | 
        <a href="camera.php">CAMERA</a> | 
        <a class="logout" href="logout.php">LOG OUT</a>
    </div>
</head>
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
#video, canvas {
    border-radius: 3%;
    margin: auto;
    width: 100%;
    transform: rotateY(180deg);
    -webkit-transform:rotateY(180deg); /* Safari and Chrome */
    -moz-transform:rotateY(180deg); /* Firefox */
}
#canvas {
    position: absolute;
    background-repeat: no-repeat;
    background-position-x: left;
    background-position-x: top;
    background-size: 90px;
    z-index: 99;
    display: none;
}
.image_container {
    max-height: 45vh;
    overflow-y: auto;
    margin-top: 1vh;
    border-style: groove;
    padding: 2vh;
    border-radius: 24px;
    border-style: groove;
    border-color: #5EBEC4;
    background: #FDF5DF;
}
img{
    transform: rotateY(180deg);
    -webkit-transform:rotateY(180deg); /* Safari and Chrome */
    -moz-transform:rotateY(180deg); /* Firefox */
    border-radius: 14px;
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
.stickers {
    margin: auto;
}
.sticker {
    max-width: 50px;
    width: 12vw;
}
.sticker1 {
    max-width: 50px;
    width: 11vw;
    transform: rotateY(180deg);
    -webkit-transform:rotateY(180deg); /* Safari and Chrome */
    -moz-transform:rotateY(180deg); /* Firefox */
}
.side_img {
    width: 32%;
}
.save_button {
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
}
.button {
    background: #f0ebe5;
    border-width: 1px;
    border-radius: 5px 5px 5px 5px;
    cursor: pointer;
    text-transform: uppercase;
    box-shadow: 0px 2px 6px 0px rgba(0, 0, 0, 0.25);
    background:#77efad;
}
a:link { text-decoration: none; }
a:visited { text-decoration: none; }
a:hover { text-decoration: underline; }
a:active { text-decoration: underline; }
body {
    position: relative;
    background: rgb(94,190,196);
    background: radial-gradient(circle, rgba(94,190,196,1) 0%, rgba(253,245,223,1) 87%);
}
.booth {
    text-align: center;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: space-evenly;
    background: white;
    padding: 3%;
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
.error {
    color: #c95e5e;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
</style>
<body>
    <div class="main">
        <div class="booth">
            <video id="video" autoplay></video>
            <div class ="save_button">
                <button class="button" onclick="postPicture" value="">CAPTURE</button>
            </div>
            <div id="stickers" class="stickers">
                <img class="sticker" id="s1" src="../images/stickers/sticker1.png" onclick="selectedSticker(1)">
                <img class="sticker" id="s2" src="../images/stickers/sticker2.png" onclick="selectedSticker(2)">
                <img class="sticker1" id="s3" src="../images/stickers/sticker3.png" onclick="selectedSticker(3)">
                <img class="sticker" id="s4" src="../images/stickers/sticker4.png" onclick="selectedSticker(4)">
                <img class="sticker" id="s5" src="../images/stickers/sticker5.png" onclick="selectedSticker(5)">
            </div>
            <img class= "img1" src="" alt="" id="camera_previw">
        </div>
        <br>
            <div class="upload-container">
                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <div class="upload"><input type="file" name="file" id="file" required></div>
                    <div class="upload" onclick="postUploaded"><input type="submit" value="Upload" name="submit"></div>
                    <input type="hidden" id="sticker1" name="sticker1" value="">
                    <input type="hidden" id="sticker2" name="sticker2" value="">
                    <input type="hidden" id="sticker3" name="sticker3" value="">
                    <input type="hidden" id="sticker4" name="sticker4" value="">
                    <input type="hidden" id="sticker5" name="sticker5" value="">
                </form>
            </div>
            <?php
            if (isset($_GET['error']))
            {
                if ($_GET['error'] == 1)
                    echo "<p class='error'>File is not an image.</p>";
                if ($_GET['error'] == 2)
                    echo "<p class='error'>File over max size. Only images under 1MB.</p>";
                if ($_GET['error'] == 3)
                    echo "<p class='error'>File must be .JPG, .JPEG, .PNG or .GIF.</p>";
            }
            ?>
            <div id="image_container" class="image_container">
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
                if($result) {
                    foreach($result as $private_image){ 
                        ?>
                        <img class="side_img"  src=<?php echo $private_image['img_path'];?>>
                        <?php }
                    }
                }
                catch(PDOException $e) {
                    echo $stmt . "<br>" . $e->getMessage();
                }
                }
                ?>
	        </div>
	    </div>
    <canvas id="canvas" width="400" height="300"></canvas>
</div>
<footer class="footer">
    <br>
    <span>kceder @ HIVE Helsinki 2022</span>
</footer>
</body>
<script>
    const paths = new Array (
        "../images/stickers/sticker1.png",
        "../images/stickers/sticker2.png",
        "../images/stickers/sticker3.png",
        "../images/stickers/sticker4.png",
        "../images/stickers/sticker5.png",
    )
    let cameraPreviw = document.getElementById('camera_previw');
    let display = document.getElementById('display');
    let video = document.getElementById('video');
    let captureCanvas = document.querySelector('.capture_button');
    let postPicture = document.querySelector('.save_button');
    let postUploaded = document.querySelector('.upload');
    let newPicture = document.querySelector('.save_button');
    let sticker = document.querySelector('.sticker');

    cameraPreviw.style.display = 'block';
    video.style.display = 'block';
    navigator.mediaDevices.getUserMedia({video:true, audio:false}).then(function(stream){
    video.srcObject = stream;
    })

    postPicture.addEventListener('click', function() {
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
   	    image_data_url = canvas.toDataURL('image/jpeg');
        newPicture.value = image_data_url;
        if(sticker.val != -5) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'save_img.php', true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send('image='+newPicture.value+"&sticker1="+sticker.value1+"&sticker2="+sticker.value2+"&sticker3="
                                +sticker.value3+"&sticker4="+sticker.value4+"&sticker5="+sticker.value5);
            setTimeout(location.reload.bind(location), 10);
        }
        else
            alert("Choose at least one sticker!");
    });
    
    sticker.value1 = -1;
    sticker.value2 = -1;
    sticker.value3 = -1;
    sticker.value4 = -1;
    sticker.value5 = -1;
    sticker.val = -5;

    function selectedSticker(num) {
        switch(num){

            case 1:
                sticker.value1 *= -1;
                document.getElementById("sticker1").value = sticker.value1;
                document.getElementById("s1").style.border = "solid #5EBEC4";
                sticker.val = sticker.value1 + sticker.value2 + sticker.value3 + sticker.value4 + sticker.value5;
                if (sticker.value1 == -1)
                    document.getElementById("s1").style.border = "";
                break;
            case 2:
                sticker.value2 *= -1;
                document.getElementById("sticker2").value = sticker.value2;
                document.getElementById("s2").style.border = "solid #5EBEC4";
                sticker.val = sticker.value1 + sticker.value2 + sticker.value3 + sticker.value4 + sticker.value5;
                if (sticker.value2 == -1)
                    document.getElementById("s2").style.border = "";
                break;
            case 3:
                sticker.value3 *= -1;
                document.getElementById("sticker3").value = sticker.value3;
                document.getElementById("s3").style.border = "solid #5EBEC4";
                sticker.val = sticker.value1 + sticker.value2 + sticker.value3 + sticker.value4 + sticker.value5;
                if (sticker.value3 == -1)
                    document.getElementById("s3").style.border = "";
                    break;
            case 4:
                sticker.value4 *= -1;
                document.getElementById("sticker4").value = sticker.value4;
                document.getElementById("s4").style.border = "solid #5EBEC4";
                sticker.val = sticker.value1 + sticker.value2 + sticker.value3 + sticker.value4 + sticker.value5;
                if (sticker.value4 == -1)
                    document.getElementById("s4").style.border = "";
                break;
            case 5:
                sticker.value5 *= -1;
                document.getElementById("sticker5").value = sticker.value5;
                document.getElementById("s5").style.border = "solid #5EBEC4";
                sticker.val = sticker.value1 + sticker.value2 + sticker.value3 + sticker.value4 + sticker.value5;
                if (sticker.value5 == -1)
                    document.getElementById("s5").style.border = "";
                break;
        }
    }
</script>
</html>