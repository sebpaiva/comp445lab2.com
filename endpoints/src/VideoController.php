<?php
class VideoController
{
    public function createConnection()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "comp445";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    public function getVideoNameForId($id)
    {
        $conn = $this->createConnection();

        $sql = "SELECT name FROM Videos WHERE id = " . $id;
        $sqlResult = $conn->query($sql);

        $result = null;

        if ($sqlResult->num_rows > 0) {
            $result = $sqlResult->fetch_assoc()["name"];
        }

        $conn->close();

        return $result;
    }

    public function getVideoForId($id)
    {
        $videoTitle = $this->getVideoNameForId($id);

        if ($videoTitle == null) {
            echo json_encode(["error" => "Could not find video with id " . $id]);
            http_response_code(500);
            return;
        }

        $videoPath = "../../videos/" . $videoTitle;

        $imageFileType = pathinfo($videoPath, PATHINFO_EXTENSION);
        if ($imageFileType != "mp4" && $imageFileType != "avi" && $imageFileType != "mov") {
            echo json_encode(["error" => "File Format Not Suppoted " . $imageFileType]);
            http_response_code(500);
            return;
        }

        // Output video to screen
        ?><video controls>
            <source src="<?php echo $videoPath ?>" type="video/mp4">
        </video><?php

        $file = file_get_contents("../videos/" . $videoTitle);

        echo json_encode(["data" => base64_encode($file)]);
    }

    public function processRequest(string $method, string $id): void
    {
        if ($method == "GET" && $id) 
        {
            // Return video matching the id
            $this->getVideoForId($id);
        } 
        else if ($method == "GET") 
        {
            // Return all videos
            print_r("Returning all videos.");
        } 
        else 
        {
            print_r("Method not supported");
        }
    }

}

?>