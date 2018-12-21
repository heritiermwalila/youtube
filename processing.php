<?php 
require_once('includes/header.php'); 
require_once('includes/classes/VideoUploadData.php'); 
require_once('includes/classes/VideoProcessor.php'); 
?>
<?php
if(!$_SERVER['REQUEST_METHOD'] === 'POST'){
    echo 'HELLO';
    exit();
}else{
    //1) hold all the form form data
    $videoUploadData = new VideoUploadData($_POST);
    $posts;
    foreach($videoUploadData as $post){
        $posts = $post;
    }

    //2) Proccess the video data

    $videoProcessor = new VideoProcessor($con);
    $response = $videoProcessor->upload($posts);
    

    //check if it was successful
    if($response){
        echo "Upload successful";
    }

    
}
?>
<?php require_once('includes/footer.php'); ?>