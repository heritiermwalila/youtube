<?php

class VideoProcessor{

    private $con;
    private $uploadDir = 'uploads/videos/';
    private $tempFilePath;
    private $finalFilePath;
    private $ffmpegPath = "ffmpeg/bin/ffmpeg";
    private $ffprobePath = "ffmpeg/bin/ffprobe";
    private $allowedTypes = ["mp4", "flv", "mkv", "3gp", "wmv", "webm"];
    private $fileLimitSize = 5000000;
    public function __construct($con){
        $this->con = $con;
    }

    public function upload($data){

        
        //check if the file variable is not empty
        if(!empty($_FILES)){

            $data['video-name'] = $_FILES['video-name'];

        }else{
            return false;
        }
        $videoData = $data['video-name'];
        $this->tempFilePath = $this->uploadDir . uniqid() . basename($videoData['name']);
        $this->tempFilePath = str_replace(' ', '_', $this->tempFilePath);
        //var_dump($videoData);die;
        $isValideData = $this->processData($videoData, $this->tempFilePath);

        if(!$isValideData){
            return false;
        }

        if(move_uploaded_file($videoData['tmp_name'], $this->tempFilePath)){
            $finalFilePath = $this->uploadDir . uniqid() . ".mp4";

            try{
                $this->insertVideoData($data, $finalFilePath);
            }catch(Exception $e){
                echo $e->getMessage();
            }
            
            try{
                if($this->videoConverterToMp4($this->tempFilePath, $finalFilePath)){
                    $this->deleteOriginalVideo($this->tempFilePath);
                    $this->generateThumbnails($finalFilePath);
                }
                
            }catch(Exception $e){
                echo $e->getMessage();
            }
            
        }

        return true;
        
        
    }

    private function processData($video, $filePath){
        $videoExt = pathinfo($filePath, PATHINFO_EXTENSION); //get the video extension;

        if(!$this->isValideSize($video)){
            echo "File to large cannot upload a file more than " . $this->fileLimitSize . " bytes";
            return false;
        }elseif(!$this->isValideType($videoExt)){
            echo "Invalid Format ";
            return false;
        }elseif($this->hasError($video)){
            echo "Error code: " . $video['error'];
        }

        return true;
    }

    private function isValideSize($video){
        return $video['size'] <= $this->fileLimitSize;
    }

    private function isValideType($ext){
        $ext = strtolower($ext);
        return in_array($ext, $this->allowedTypes);
    }

    private function hasError($video){
        return $video['error'] != 0;
    }

    private function insertVideoData($data, $finalFilePath){
        $sql_query = "INSERT INTO tbvideos(title, status, description, category, file_path) 
        VALUES(:title, :status, :description, :category, :file_path)";
        $query = $this->con->prepare($sql_query);


        $query->bindParam(':title', $data['video-title']);
        $query->bindParam(':status', $data['video-status']);
        $query->bindParam(':description', $data['video-description']);
        $query->bindParam(':category', $data['video-category']);
        $query->bindParam(':file_path', $finalFilePath);

        $query->execute();

        

        
    }

    private function videoConverterToMp4($tempPath, $finalPath){
        $cmd = "$this->ffmpegPath -i $tempPath $finalPath 2>&1";

        $output = array();
        /**
         * Attention to this section with xampp
         */
        exec('unset DYLD_LIBRARY_PATH ;');
        putenv('DYLD_LIBRARY_PATH');
        putenv('DYLD_LIBRARY_PATH=/usr/bin');
        exec($cmd, $output, $returnCode);

        if($returnCode != 0){
            //means the code failed
            foreach($output as $line){
                echo $line . "<br >";
            }
            return false;
        }
        return true;

        
    }

    private function deleteOriginalVideo($filePath){
        if(!unlink($filePath)){
            echo "Could not delete the video";
            return false;
        }

        return true;
    }

    private function generateThumbnails($filePath){
        $thumbnailSize = "280x210";
        $thumbnailNumber = 3;
        $thumbnailPath = "uploads/videos/thumbnails";

        //$duration = $this->videoDuration($filePath)
        if($this->videoDuration($filePath)){
            $videoId = $this->con->lastInsertId();
            $duration = $this->videoDuration($filePath);
            $this->updateVideoDuration($videoId, $duration);
            
            for($num = 1; $num <= $thumbnailNumber; $num++){
                $thumbImage = uniqid() . ".jpg";
                $interval = ($duration * 0.8) / $thumbnailNumber * $num;
                $fullThumbnailPath = "$thumbnailPath/$videoId-$thumbImage";

                $cmd = "$this->ffmpegPath -i $filePath -ss $interval -s $thumbnailSize -vframes 1 $fullThumbnailPath  2>&1";

                $output = array();
                /**
                 * Attention to this section with xampp
                 */
                exec('unset DYLD_LIBRARY_PATH ;');
                putenv('DYLD_LIBRARY_PATH');
                putenv('DYLD_LIBRARY_PATH=/usr/bin');
                exec($cmd, $output, $returnCode);

                if($returnCode != 0){
                    //means the code failed
                    foreach($output as $line){
                        echo $line . "<br >";
                    }
                }
                $query = $this->con->prepare("INSERT INTO tbthumbnails(video_id, path, selected)
                                                VALUES(:videoId, :path, :selected)");

                $selected = $num == 1 ? 1 : 0;
                $query->bindParam(":videoId", $videoId);
                $query->bindParam(":path", $fullThumbnailPath);
                $query->bindParam(":selected", $selected);

                $result = $query->execute();

                if(!$result){
                    echo "Error inserted";
                    return false;
                }
            }
            return true;
        }
    }

    private function videoDuration($filePath){
        return (int) shell_exec("$this->ffprobePath -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $filePath");
    }

    private function updateVideoDuration($videoId, $duration){
        
        $times = gmdate('H:i:s', $duration);
        $explode = explode(':', $times);
        $hours = $explode[0];
        $minutes = $explode[1];
        $secs = $explode[2];
        $strTime;
        if($hours < 1){
            $strTime = $minutes . ":" . $secs;
        }else{
            $strTime = $hours . ":" . $minutes . ":" . $secs;
        }
        $sql = "UPDATE tbvideos SET duration=:duration WHERE id=:videoId ";
        $exec_sql = $this->con->prepare($sql);
        $exec_sql->bindParam(":duration", $strTime);
        $exec_sql->bindParam(":videoId", $videoId);
        $exec_sql->execute();

    }
}