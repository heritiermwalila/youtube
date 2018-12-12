<?php

class videoDetailsFormProvider{
    private $con;

    public function __construct($con){
        $this->con = $con;
    }
    
    public function createUploadForm(){
        
        $fileUpload = $this->AddInput('file', 'fileUpload', '', ['class'=>'form-control-file', 'id'=>'file-upload']);
        $AddInput = $this->AddInput('text', 'title', '', ['class'=>'form-control', 'id'=>'title', 'placeholder'=>'Video title']);
        $textArea = $this->textArea(3, 'description', '', ['class'=>'form-control', 'id'=>'description', 'placeholder'=>'Video description']);
        $selectInput = $this->selectInput();
        $categoriesInput = $this->categoriesInput();
        $submitBtn = $this->submit();
        
        return "
            <form action='processing.php' method='POST'>
                $fileUpload
                $AddInput
                $textArea
                $categoriesInput
                $selectInput
                $submitBtn
            </form>
        ";
    }

    private function addAttribute($attr){
        $str = '';
        $sin_attr = array('checked', 'disabled', 'readonly', 'multiple',
        'required', 'autofocus', 'novalidate', 'formnovalidate');

        foreach($attr as $key=>$value){
            
                if(!empty($value)){
                    $str .= " $key = \"$value\"";
                }else{
                    $str .= " $key = \"$value\"";
                }
            
        }
        return $str;

        
    }
    public function AddInput($type, $name, $value, $attr = []){
        $str = "<input type=\"$type\" name=\"$name\" value=\"$value\"";

        if($attr){
            $str .= $this->addAttribute($attr);
        }
        
        $str .= ">";

        return $this->surround($str);
    }

    private function surround($html){
        
        return "
                <div class='form-group'>
                    $html
                </div>
                ";
    }

    private function selectOption($value = []){
        $srt = "><option";

        foreach($value as $k => $v){
            if($v){
                $str .= "value=\"$k\"". ">";
            }

            $str .= "</option>";
            
            
        }
       return $str;

    }

    private function selectInput(){
        return "
        <div class='form-group'>
        <select class='form-control' id='status' name='status'>
          <option value='0'>Private</option>
          <option value='1'>Public</option>
        </select>
      </div>
                ";
    }

    private function categoriesInput(){

        $str = "<div class='form-group'>
        <select class='form-control' id='status' name='status'>";
        $query = $this->con->prepare("SELECT * FROM tbcategories");
        $query->execute();
        
        while($rows = $query->fetch(PDO::FETCH_ASSOC)){
            
            $str .= "<option value=" . $rows['id'] . ">" . $rows['name'] . "</option>";
        }
        $str .= "</select></div>";

        return $str;
    }


    private function textArea(int $rows, $name, $value, $attr = []){
        $str = "<textarea rows=\"$rows\" name=\"$name\"";

        if($attr){
            $str .= $this->addAttribute($attr);
        }
        
        $str .= ">" .$value ."</textarea>";

        return $this->surround($str);
    }

    private function submit(){
        return "<button type='submit' class='btn btn-primary'>upload video</button>";
    }

    
}