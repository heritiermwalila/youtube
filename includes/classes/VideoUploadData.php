<?php

class VideoUploadData{
        // private $videoDataArray, $title, $status, $description, $category, $uploadedBy;
        // public function __construct($videoDataArray, $title, $status, $description, $category, $uploadedBy){

        //     $this->videoDataArray = $videoDataArray;
        //     $this->title = $title;
        //     $this->status = $status;
        //     $this->description = $description;
        //     $this->category = $category;
        //     $this->uploadedBy = $uploadedBy;

        // }

        public $postData;
        public function __construct(array $postData){

            $this->postData = $postData;

        }
}