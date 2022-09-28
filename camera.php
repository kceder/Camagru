<?php 
    session_start();
    require_once('connect.php');
    if(!$_SESSION['logged_in_user'])
        header('Location: index.php');
?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
    <title>Camera</title>
    <p class="login">Logged in as: <?php echo $_SESSION['logged_in_user'];?></p>
    <h1>C A M A G R U</h1>
    <div class="headers">
        <a href="home.php">HOME</a> | 
        <a href="profile.php">PROFILE</a> | 
        <a href="camera.php">TAKE A PHOTO</a> | 
        <a class="logout" href="logout.php">LOG OUT</a>
    </div>

<head>
</head>
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
        text-decoration: none;
        border: none;
    }
    h1 {
        text-align: center;
    }
    #video, canvas {
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
        display: flex;
        float: right;
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: space-evenly;
        margin-left: 5%;
        margin-right: 20%;
        max-height: 30vh;
        overflow-y: scroll;
        
    }
    img{
        padding: 5px;
        transform: rotateY(180deg);
        -webkit-transform:rotateY(180deg); /* Safari and Chrome */
        -moz-transform:rotateY(180deg); /* Firefox */
        border-radius: 14px;
    }
    #h1 {
        margin-left: auto; margin-right: auto;
        font-size: smaller;
    }
    .stickers {
        display: flex;
        float: left;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        flex-wrap: wrap;
        border: none;
        margin-right: 5%;
        margin-left: 20%;
    }
    .sticker {
        display: inline;
        max-width:125px;
        max-height:100px;
        width: auto;
        height: auto;
    }
    .sticker1 {
        display: inline;
        max-width:125px;
        max-height:100px;
        width: auto;
        height: auto;
        transform: rotateY(180deg);
        -webkit-transform:rotateY(180deg); /* Safari and Chrome */
        -moz-transform:rotateY(180deg); /* Firefox */
    }
    .container {
        display:flex;
        justify-content:space-between;
        width: 44vh;
    }
    .side_img {
        width: 100px;
    }
    .main {
        display: inline-block;
        margin: 0 auto;   
    }
    .save_button {
        margin: 0;
        position: absolute;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
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
    <div class="main">

        <div id="container" class="container">
            <div id="stickers" class="stickers">
                <img class="sticker" id="s1" src="./images/stickers/sticker1.png" onclick="selectedSticker(1)">
                <img class="sticker" id="s2" src="./images/stickers/sticker2.png" onclick="selectedSticker(2)">
                <img class="sticker1" id="s3" src="./images/stickers/sticker3.png" onclick="selectedSticker(3)">
                <img class="sticker1" id="s4" src="./images/stickers/sticker4.png" onclick="selectedSticker(4)">
                <img class="sticker" id="s5" src="./images/stickers/sticker5.png" onclick="selectedSticker(5)">
            </div>
            <video id="video" autoplay></video>
            <img class= "img1" src="" alt="" id="camera_previw">
            <div id="image_container" class="image_container">
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
                        <img class="side_img"  src=<?php echo $private_image['img_path'];?>>
                        <?php }
                    }
                }
                catch(PDOException $e) {
                    echo $stmt . "<br>" . $e->getMessage();
                }
                ?>
	</div>
</div>
<div class ="save_button">
    <button class="" onclick="postPicture" value="">CAPTURE</button>
</div>
<br>
<div class="upload-container">
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <div class="choose"><input type="file" name="file" id="file" required></div>
                <div class="upload" onclick="postUploaded"><input type="submit" value="Upload" name="submit"></div>
                <input type="hidden" id="sticker1" name="sticker1" value="">
                <input type="hidden" id="sticker2" name="sticker2" value="">
                <input type="hidden" id="sticker3" name="sticker3" value="">
                <input type="hidden" id="sticker4" name="sticker4" value="">
                <input type="hidden" id="sticker5" name="sticker5" value="">
            </form>
        </div>
    <canvas id="canvas" width="400" height="300"></canvas>
</div>

</body>
<script>

    const paths = new Array (
        "./images/stickers/sticker1.png",
        "./images/stickers/sticker2.png",
        "./images/stickers/sticker3.png",
        "./images/stickers/sticker4.png",
        "./images/stickers/sticker5.png",
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
    // captureCanvas.addEventListener('click', function() {
   	//     canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
   	//     image_data_url = canvas.toDataURL('image/jpeg');
    //     newPicture.value = image_data_url;
    // });
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
        }
        else
            alert("Choose at least one sticker!")
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
                document.getElementById("s1").style.border = "thick solid #0000FF";
                sticker.val = sticker.value1 + sticker.value2 + sticker.value3 + sticker.value4 + sticker.value5;
                if (sticker.value1 == -1)
                    document.getElementById("s1").style.border = "";
                break;
            case 2:
                sticker.value2 *= -1;
                document.getElementById("sticker2").value = sticker.value2;
                document.getElementById("s2").style.border = "thick solid #0000FF";
                sticker.val = sticker.value1 + sticker.value2 + sticker.value3 + sticker.value4 + sticker.value5;
                if (sticker.value2 == -1)
                    document.getElementById("s2").style.border = "";
                break;
            case 3:
                sticker.value3 *= -1;
                document.getElementById("sticker3").value = sticker.value3;
                document.getElementById("s3").style.border = "thick solid #0000FF";
                sticker.val = sticker.value1 + sticker.value2 + sticker.value3 + sticker.value4 + sticker.value5;
                if (sticker.value3 == -1)
                    document.getElementById("s3").style.border = "";
                    break;
            case 4:
                sticker.value4 *= -1;
                document.getElementById("sticker4").value = sticker.value4;
                document.getElementById("s4").style.border = "thick solid #0000FF";
                sticker.val = sticker.value1 + sticker.value2 + sticker.value3 + sticker.value4 + sticker.value5;
                if (sticker.value4 == -1)
                    document.getElementById("s4").style.border = "";
                break;
            case 5:
                sticker.value5 *= -1;
                document.getElementById("sticker5").value = sticker.value5;
                document.getElementById("s5").style.border = "thick solid #0000FF";
                sticker.val = sticker.value1 + sticker.value2 + sticker.value3 + sticker.value4 + sticker.value5;
                if (sticker.value5 == -1)
                    document.getElementById("s5").style.border = "";
                break;
        }
    }
</script>
</html>