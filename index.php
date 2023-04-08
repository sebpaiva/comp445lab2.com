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
            <!-- <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="./endpoints/home.php">.</a></li>
            </ul> -->
        </div>
    </nav>

    <div class="container">
        <h2>Video Storage</h2>


        <!-- For each video, get sql -->        
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
                        <!-- This button will start the video recording -->
                        <button type="button" class="btn btn-primary"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>