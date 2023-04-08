<?php
class VideoController
{

    public function getVideoNameForId($id): string
    {
        // SQL get video name for id
        return "sample.mp4";
    }

    public function processRequest(string $method, string $id): void
    {
        if ($method == "GET" && $id) {
            print_r("Return video for the given id");

            $videoPath = "../../videos/" . $this->getVideoNameForId($id);
            
            // $video = readfile($videoPath);

            $imageFileType = pathinfo($videoPath, PATHINFO_EXTENSION);
            if ($imageFileType != "mp4" && $imageFileType != "avi" && $imageFileType != "mov") {
                echo "File Format Not Suppoted";
                return;
            } 
            ?>
            
            <video width="300" height="200" controls>
                <source src="<?php echo $videoPath ?>" type="video/mp4">
            </video>
            
            <?php
                // $video_path = $_FILES['fileToUpload']['name']; // c
                // move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                // echo "uploaded ";
            
            // print_r($videoPath, $video);
        } else if ($method == "GET") {
            print_r("Returning all videos.");

        } else {
            print_r("Else.");
        }
    }

}

?>