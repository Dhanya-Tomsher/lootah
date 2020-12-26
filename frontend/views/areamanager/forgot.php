<?php
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div uk-height-viewport class="uk-flex uk-flex-middle bg-gradient-primary log-wrap">
        <div class="uk-width-1-3@m uk-width-1-3@s m-auto rounded">
            <div class="uk-child-width-1-1@m uk-grid-collapse " uk-grid>
                <!-- column one -->
                <div class="uk-margin-auto-vertical uk-text-center uk-animation-scale-up p-3 uk-light">
                    <img src="<?= Yii::$app->request->baseUrl; ?>/images/lootah.png" />
                   
                </div>

                <!-- column two -->
                <div class="uk-card-default py-4 px-5">
                    <div class="mt-4 mb-2 uk-text-center">
                        <h3 class="mb-0">Forgot Password</h3>
                        <p class="my-2">Enter your emailid</p>
                    </div>
<form name="frm" onsubmit="return validation();" class="uk-grid-small uk-grid" action="<?= Yii::$app->request->baseUrl; ?>/areamanager/forgotpwdsub" method="POST">
                           
                        <div class="uk-form-group">
                            <label class="uk-form-label"> Email</label>

                            <div class="uk-position-relative w-100">
                                <span class="uk-form-icon">
                                    <i class="icon-feather-mail"></i>
                                </span>
                                <input class="uk-input" type="email" name="email" id="email" placeholder="Enter your emailid">
                                <span id="result"></span>
                            </div>

                        </div>
						
			

                        

                        <div class="mt-4 uk-flex-middle uk-grid-small" uk-grid>
                            <div class="uk-width-expand@s">
                                <p>Back to <a href="<?= Yii::$app->request->baseUrl; ?>/areamanager/index">Login</a></p>
                            </div>
                            <div class="uk-width-auto@s">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </form>
                </div><!--  End column two -->

            </div>
        </div>
    </div>
<style>
    input, input[type="text"]{
    padding: 0 36px;
    }
    input, input[type="password"]{
    padding: 0 36px;
    }
</style>
<script>
    //$(document).ready(function(){
    function validation() {
        event.preventDefault();
      var str = $("#email").val();
     $.ajax({
        type: "POST",
        url: "<?= Yii::$app->request->baseUrl. '/areamanager/findemail'; ?>",
        dataType: "text",
        data: {email:str},
        success: function (response) {
        if(response=="0"){
           $("#result").html("Invalid emailid!");
           $("#result").css("color", "red");
           return false;
         }else{
             document.frm.submit();
           return true;
         }
          },
          });
}
//});

</script>