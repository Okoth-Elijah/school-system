<?php include 'root/process.php';
    $currentUrl = $_SERVER['REQUEST_URI'];
    $parts = explode('/', $currentUrl);
    $uid = $parts[count($parts) - 2]; 
    $user = dbRow("SELECT * FROM users WHERE userid = '$uid' ");

    if (isset($_POST['submit_image_btn'])) {
        trim(extract($_POST));
        $img = $_POST['image'];
        $folderPath = "uploadx/";
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
      
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';
        //`cpid`, `cid`, `client_photo`, `date_photo_taken`
        $url = SITE_URL.'/uploadx/'.$fileName;
        $id = $user->userid;
        $dbh->query("UPDATE users SET pic = '$url' WHERE userid = '$id' ");
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);
        if (isset($_SESSION['udetail_userid']) && isset($_SESSION['udetail_fullname'])) {
            $udetailsUserid = $_SESSION['udetail_userid'];
            $udetailsFullname = $_SESSION['udetail_fullname'];
            // Redirect the user back to the candidate details page
            header("Location: ".SITE_URL."/udetails/$udetailsUserid/" . str_replace(' ', '-', strtolower($udetailsFullname)));
            exit;
        }elseif (isset($_SESSION['up_userid']) && isset($_SESSION['up_fullname'])) {
            $upUserid = $_SESSION['up_userid'];
            $upFullname = $_SESSION['up_fullname'];
            header("Location: ".SITE_URL."/user-profile");
            exit;
        }else {
            // Redirect the user to the homepage or dashboard
            header("Location: " . SITE_URL);
            exit;
        }
    }
  
?>
<!DOCTYPE html>
<html>
<head>
    <base href="http://localhost/kitudesacco/">
    <title>Capture client's photo</title>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/webcam.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script> -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <style type="text/css">
        #results { padding:20px; border:1px solid; background:#ccc; }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center">
    <?php if (isset($_SESSION['udetail_userid']) && isset($_SESSION['udetail_fullname'])) {
        $udetailsUserid = $_SESSION['udetail_userid'];
        $udetailsFullname = $_SESSION['udetail_fullname']; ?>
        <a href="udetails/<?=$udetailsUserid.'/'. str_replace(' ', '-', strtolower($udetailsFullname))?>" class="btn btn-info"><<- Back</a> Capture <?=ucfirst($user->firstname);?>'s Photo
    <?php }elseif (isset($_SESSION['up_userid']) && isset($_SESSION['up_fullname'])) {
        $udetailsUserid = $_SESSION['udetail_userid'];
        $udetailsFullname = $_SESSION['udetail_fullname']; ?>
        <a href="<?=SITE_URL;?>/user-profile" class="btn btn-info"><<- Back</a> Capture <?=ucfirst($user->firstname);?>'s Photo
    <?php } ?>
    </h1>
    <form method="POST" action="">
    <!-- <form method="POST" action="storeImage.php"> -->
        <div class="row">
            <div class="col-md-6">
                <div id="my_camera"></div>
                <br/>
                <input type=button value="Take Snapshot" onClick="take_snapshot()">
                <input type="hidden" name="image" class="image-tag">
            </div>
            <div class="col-md-6">
                <div id="results">Your captured image will appear here...</div>
            </div>
            <div class="col-md-12 text-center">
                <br/>
                <button class="btn btn-success" name="submit_image_btn" type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>
<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
    Webcam.set({
        width: 490,
        height: 390,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
  
    Webcam.attach( '#my_camera' );
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
</script>
</body>
</html>