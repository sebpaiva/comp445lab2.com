
<?php
require_once 'endpoints/src/VideoController.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>COMP 445 - Backend</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
</head>

<body>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">COMP 445 - Backend</a>
            </div>
    </nav>

    <!-- <div class="container">
        <h2>Video Storage</h2>


         --><!-- For each video, get sql --><!--
        <div class="row">
            <div class="col-md-6">
                <div class="bg-white border rounded-5">
                    <div class="p-4 text-center w-100" id="vid-recorder">
                        <video autoplay id="web-cam-container" style="background-color: gray;">
                            Your browser doesn't support the video tag
                        </video>
                        <p id="vid-record-status"></p>
                    </div>

                    <div class="p-4 text-center border-top">
                        <button type="button" class="btn btn-primary">AAAAAAAA</button>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="container">
        <h2>Video Storage</h2>

        <div class="row">
            <?php
            // Create a new instance of the VideoController
            $videoController = new VideoController();

            // Get all video names
            $videoNames = $videoController->getAllVideosName();

            // Loop through video names and display them
            foreach ($videoNames as $name) {
                echo '<div class="col-md-6">';
                echo '<div class="bg-white border rounded-5">';
                echo '<div class="p-4 text-center">';
                echo '<video src="videos/' . $name . '" controls></video>';
                echo '<p>' . $name . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>


</body>

</html>