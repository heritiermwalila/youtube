<?php 
require_once('includes/header.php'); 
require_once('includes/classes/videoDetailsFormProvider.php'); 
?>
        <div class="form-upload-container">
            <?php 
                $uploadForm = new videoDetailsFormProvider($con);
                echo $uploadForm->createUploadForm('processing.php', 'POST', true);
            ?>
        </div>

        <script>
            jQuery(document).ready(function($){
                $("form").submit(function(){
                    $("#loadingModel").modal("show");
                })
            })
        </script>
        <div class="modal fade" id="loadingModel" tabindex="-1" role="dialog" aria-labelledby="loadingModelTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    
                    <div class="modal-body">
                        <p>Please wait this may take a while. <img src="assets/images/icons/loading-spinner.gif" alt=""></p>
                    </div>
                    
                </div>
            </div>
        </div>
<?php require_once('includes/footer.php'); ?>