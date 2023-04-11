<?php
class VideoController
{

        public function uploadSegment() {
            // Read request body as raw data
            $segment = file_get_contents("php://input");

            // Parse request body as JSON
            $segment_decoded = json_decode($segment);

            // Extract data from request body
            $videoId = $segmentArray->videoId;
            $sequenceNumber = $segmentArray->sequenceNumber;
            $isDelivered = $segmentArray->isDelivered;
            $data = $segmentArray->data;

            // Create database connection
            $conn = $this->createConnection();


            // Check if the segment already exists
            $stmt = $conn->prepare("SELECT COUNT(*) FROM Segments WHERE video_id = ? AND sequenceNumber = ?");
            $stmt->bindParam(1, $videoId);
            $stmt->bindParam(2, $sequenceNumber);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->close();

            if ($result['COUNT(*)'] > 0) {
                // Sequence number already exists, send success response and return
                http_response_code(200);
                return;
            }

            // Insert the new segment into the database
            $stmt = $conn->prepare("INSERT INTO Segments (video_id, sequenceNumber, isDelivered, seg_data) VALUES (?, ?, ?, ?)");
            $stmt->bindParam(1, $videoId);
            $stmt->bindParam(2, $sequenceNumber);
            $stmt->bindParam(3, $isDelivered);
            $stmt->bindParam(4, $data, PDO::PARAM_LOB);
            $stmt->execute();
            $stmt->close();

            // Send success response
            http_response_code(200);

            // Close database connection
            $conn->close();
        }




        public function finishUpload($videoID) {
            // Create a connection to the database
                $conn = $this->createConnection();

                // Retrieve all segments for the given videoID
                $sql = "SELECT segment FROM Segments WHERE videoID = :videoID ORDER BY segmentID";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":videoID", $videoID, PDO::PARAM_INT);
                $stmt->execute();

                // Combine the segments into a single video file
                $videoData = "";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $videoData .= $row["segment"];
                }

                // Store the assembled video under the videos folder
                $filePath = "videos/video_$videoID.mp4";
                file_put_contents($filePath, $videoData);

                $conn->close();
        }


         /**
         * Get all video names from the Videos sql table
         */
        public function getAllVideosName()
        {
            $conn = $this->createConnection();

            $sql = "SELECT name FROM Videos";
            $sqlResult = $conn->query($sql);

            $result = [];

            if ($sqlResult->num_rows > 0) {
                while ($row = $sqlResult->fetch_assoc()) {
                    array_push($result, $row["name"]);
                }
            }

            $conn->close();

            return $result;
        }

        public function getAllVideos()
        {
            $conn = $this->createConnection();

            $sql = "SELECT id, name FROM Videos";
            $sqlResult = $conn->query($sql);

            $result = [];

            if ($sqlResult->num_rows > 0) {
                while ($row = $sqlResult->fetch_assoc()) {
                    $id = $row["id"];
                    $name = $row["name"];
                    $data = base64_encode(file_get_contents("../videos/" . $name));
                    $result[] = ["id" => $id, "name" => $name, "data" => $data];
                }
            }

            $conn->close();

            return $result;
        }

    /**
     * Helper function to get the next available video ID
     */
    private function getNextVideoId(): int
    {
        $conn = $this->createConnection();

        // Get the current highest id from the videos table
        $sql = "SELECT MAX(id) AS max_id FROM Videos";
        $sqlResult = $conn->query($sql);
        $nextId = 1;

        if ($sqlResult->num_rows > 0) {
            $row = $sqlResult->fetch_assoc();
            $nextId = intval($row["max_id"]) + 1;
        }

        // Insert a new row into the videos table with the next available id
        $sql = "INSERT INTO Videos (id, name) VALUES ('$nextId', 'video_$nextId.mp4')";
        $conn->query($sql);

        $conn->close();

        return $nextId;
    }

    /**
    * Endpoint to get the ID of the next video and insert a new row into the Videos table
    */
        public function getVideoId()
        {
            $nextId = $this->getNextVideoId();

            echo json_encode(["id" => $nextId]);
        }



    /**
     * Creates a connection to the DB, DON'T FORGET TO CLOSE IT!
     */
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

    /**
     * Translates videoId to videoName using the Videos sql table
     * This videoName will be used as part of the path when we read its contents
     */
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

    /**
     * Get the encoded contents of a video given its id
     */
    public function getVideoForId($id)
    {
        $videoTitle = $this->getVideoNameForId($id);

        // Validate if the file exists
        if ($videoTitle == null) {
            echo json_encode(["error" => "Could not find video with id " . $id]);
            http_response_code(500);
            return;
        }

        $videoPath = "../../videos/" . $videoTitle;

        // Validate that the file is a video
        $fileType = pathinfo($videoPath, PATHINFO_EXTENSION);
        if ($this->notSupportedFileType($fileType)) {
            echo json_encode(["error" => "File Format Not Suppoted " . $fileType]);
            http_response_code(500);
            return;
        }

        // Note: This path is different from the one above, I don't know why they require different ones
        $file = file_get_contents("../videos/" . $videoTitle);

        // Print the video contents to the screen, we need to encode them so no information is lost on transmission and conversion
        echo json_encode(["name" => $videoTitle, "data" => base64_encode($file)]);
    }

    /**
     * Helper function for #getVideoForId
     */
    private function notSupportedFileType($fileType): bool{
        return $fileType != "mp4" && $fileType != "avi" && $fileType != "mov";
    }

    public function processRequest($method, $id): void
    {
        // Return video matching the id
        if ($method == "GET" && $id) 
        {
            $this->getVideoForId($id);
        }

        // Return all videos
        else if ($method == "GET")
        {
            $videos = $this->getAllVideos();
            echo json_encode($videos);
        }
    }
}

?>