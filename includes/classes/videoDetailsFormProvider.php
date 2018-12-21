<?php

class videoDetailsFormProvider{
    private $con;

    public function __construct($con){
        $this->con = $con;
    }
    
    public function createUploadForm($action, $method, $multipart=false){
        $uploadedBy = $this->input('hidden', ['class'=>"form-control-file", 'name'=>'uploadedBy', 'value'=>'1']);
        $videoUpload = $this->input('file', ['class'=>"form-control-file", 'name'=>'video-name']);
        $videoTitle = $this->input('text', ['class'=>"form-control", "placeholder"=>"Video title", 'name'=>'video-title']);
        $videoStatus = $this->select(['0'=>'Private', '1'=>'Public'], ['class'=>'form-control', 'name'=>'video-status']);
        $videoDescription = $this->textarea(['class'=>'form-control', 'rows'=>'3', 'name'=>'video-description', 'placeholder'=>'Video description']);
        $submitButton = $this->input('submit', ['class'=>"btn btn-primary", "placeholder"=>"Video title", 'value'=>'Upload video']);

        /**
         * @return video categories
         * @var stmt SQL statement for getting video categories
         * @var sql_categories prepare the sql query before executing
         * @var result empty array which will hold all the result from the query and pass it into @var videoCategories 
         */

         $stmt = "SELECT * FROM tbcategories";
         $sql_categories = $this->con->prepare($stmt);
         $sql_categories->execute();
         
         $result = [];
         while($rows = $sql_categories->fetch(PDO::FETCH_ASSOC)){

            $result[$rows['id']] =$rows['name'];

         }
         $videoCategories = $this->select($result, ['class'=>'form-control', 'name'=>'video-category']);

         /**
          * @var form hold the entire form and @return a html from 
          */
        $form = "<form action=\"$action\" method=\"$method\"";
        if($multipart){
            $form .= " enctype=\"multipart/form-data\"";
        }
        $form .=">";
        $form .=$uploadedBy;
        $form .=$videoUpload;
        $form .=$videoTitle;
        $form .=$videoStatus;
        $form .=$videoDescription;
        $form .=$videoCategories;
        $form .=$submitButton;
        $form .="</form>";
        return $form;
    }

    /**
     * @param addAttrbute
     * @return a string
     */
    private function addAttribute($attr = []){
        $str = '';
        $default_attr = ['disabled', 'required', 'autocomplete', 'autofocus', 'multiple'];
        foreach($attr as $key=>$name){
            if(in_array($key, $default_attr)){
                $str .= " $key";
            }else{
                $str .= " $key=\"$name\"";
            }
        }

        return $str;
    }

    /**
     * @param wrap
     * @return a string
     */
    private function wrap($html){
        return "<div class='form-group'>" . $html . "</div>";
    }

    private function input($type, $attributes=[]){
        $str ="<input type=\"$type\" ";

        if(!empty($attributes)){
            $str .= $this->addAttribute($attributes);
        }

        $str .=">";

        return $this->wrap($str);
    }

    /**
     * @param select select html input
     * @var options hold select options and there values default is empty array
     * @var attributes hold select attrbites default is empty object
     * @return a string $str
     */
    private function select($options=[], $attributes=[]){

        $str = "<select";
        $str .=  $this->addAttribute($attributes) . " >";
        foreach($options as $value => $name){
            $str .="<option value=\"$value\">";
            $str .= $name . "</option>";
        }

        $str .="</select>";

        return $this->wrap($str);

    }

    private function textarea($attributes=[], $value=''){
        $str = "<textarea";
        if(!empty($attributes)){
            $str .= $this->addAttribute($attributes);
            $str .=">";
            if(!is_null($value)){ 
                $str .= $value;
            }
            
        }

        $str .="</textarea>";

        return $this->wrap($str);
    }

    
}