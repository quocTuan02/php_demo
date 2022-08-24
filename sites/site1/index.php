<?php
require_once "Unit.php";
// Create folder for each user
session_start();
$dir = 'upload/' . session_id();
if (!file_exists($dir))
    mkdir($dir);


$error = '';
$success = '';
if (isset($_GET["debug"])) die(highlight_file(__FILE__));
if (isset($_FILES["file"])) {
    try {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);
        $whitelist = array("image/jpeg", "image/png", "image/gif");
        if (!in_array($mime_type, $whitelist, TRUE)) {
            die("Submit thất bại !");
        }
        $file = $dir . "/" . $_FILES["file"]["name"];
        move_uploaded_file($_FILES["file"]["tmp_name"], $file);

        $data = array(
            'img' => $file,
            'content' => $_POST["content"]
        );
        $data_string = callAPI("POST", "http://3.145.33.155:8022/news", json_encode($data));
        $kq = json_decode($data_string)->data;
        $success = '<a href="/card.php?id='.$kq->id.'"> Click to see details</a>';
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>PHP upload file</title>

    <!-- This is for UI only -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"
          integrity="sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

</head>
<body>
<div class="d-flex justify-content-center mt-5">
    <form class="bd-example card w-50 px-3 py-5" method="post" enctype="multipart/form-data">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="file" name="file" required>
            <label class="custom-file-label" for="file">Choose file...</label>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label"></label>
            <textarea class="form-control" name="content" id="content" required rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>

            <span style="color:red"><?php echo $error; ?></span>
            <span style="color:green"><?php echo $success; ?></span>
    </form>
</div>
</body>
</html>