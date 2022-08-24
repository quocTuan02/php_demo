<?php
require_once "Unit.php";

$id = $_GET["id"];
$data_string = "";
$success = "";
if (isset($id)) {
    $url = "http://3.145.33.155:8022/news/" . $id;
    $data_string = callAPI("GET", $url, false);
    $data = json_decode($data_string)->data;
    if ($data == null || count($data) == 0) {
        header("Location: /");
        exit();
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Info</title>

    <!-- This is for UI only -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"
          integrity="sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>
<div class="d-flex justify-content-center mt-5" onload='alert("Page is loaded")'>
    <?php
    $data = json_decode($data_string)->data;

    for ($i = 0; $i < count($data); $i++) {
        $obj = $data[$i];

        echo '<div class="card w-50">
                    <img class="card-img-top"
                         src="' . $obj->img . '"
                         alt="' . $obj->img . '">
                    <div class="card-body">
                        <p class="card-text">' . $obj->content . ' </p>
                    </div>
                </div>';
    }
    ?>
</div>

</body>
</html>