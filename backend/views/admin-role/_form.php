<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdminRole */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .role_items h4 label {
        float: right;
        font-size: 14px;
    }
    .role_items {
        margin-bottom: 20px;
    }
    .role_items h4 {
        margin-bottom: 25px;
        margin-top: 26px;
        padding: 14px 6px;
        background-color: #6c9399;
        border-radius: 5px;
        font-size: 14;
        color: #fff;
    }
</style>
<div class="admin-role-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role_name')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'status')->dropDownList(['1' => 'Enable', '0' => 'Disable']) ?>


    <div class="row role_items">
        <div class="col-xs-12">
            <h4>Choose access area
                <label>Select All <input type="checkbox" value="1" class="select_all" label="Selct All"/></label>
            </h4>
        </div>
        <div class="col-xs-12">

            <?php $get_role_list = \common\models\AdminRoleList::find()->where(['status' => 1])->all(); ?>

            <?php if ($get_role_list != NULL) { ?>

                <?php foreach ($get_role_list as $get_role) { ?>

                    <?php
                    if ($model->isNewRecord) { // === false even we insert a new record
                        $checked = '';
                    } else {
                        $check_role_cat_exist = \common\models\AdminRoleCategory::find()->where(['status' => 1, 'role_id' => $model->id, 'access_location' => $get_role->value])->one();

                        if ($check_role_cat_exist != NULL) {
                            $checked = "checked";
                        } else {
                            $checked = '';
                        }
                    }
                    ?>
                    <label><input type="checkbox" id="adminrolecategory-access_location" <?php echo $checked; ?> class="check_bx" name="AdminRoleCategory[access_location][]" value="<?php echo $get_role->value; ?>"><?php echo $get_role->name; ?></label><br/>

                <?php }
                ?>
            <?php }
            ?>




        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$this->registerJs(<<< EOT_JS_CODE

        $('.select_all').click(function(){
            if($(".select_all").is(':checked')){

                $( ".check_bx" ).each(function( index ) {
                  $(this).prop( "checked", true );
                });

            }else{
                $( ".check_bx" ).each(function( index ) {
                     $(this).prop( "checked", false );
                });

            }

        });

EOT_JS_CODE
);
?>