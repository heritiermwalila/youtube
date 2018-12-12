<?php 
require_once('includes/header.php'); 
require_once('includes/classes/videoDetailsFormProvider.php'); 
?>
        <div class="form-upload-container">
            <?php 
                $uploadForm = new videoDetailsFormProvider($con);
                echo $uploadForm->createUploadForm();
            ?>
        </div>
<?php require_once('includes/footer.php'); ?>