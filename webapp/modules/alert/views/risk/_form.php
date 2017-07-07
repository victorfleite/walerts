<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Config */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="config-form">

    <?php $form = ActiveForm::begin(['layout' => 'default']); ?>


    <div class="row">
	<div class="col-lg-4">
	    <?=
	    $form->field($model, 'name_i18n')->widget('\common\components\widgets\inputmodal_i18n\InputModalI18n', [
		'button_modal_label' => \Yii::t('translation', 'translation'),
		'fieldType'=>'text',
		'options' => [
		    //'rows' => 6
		]
	    ]);
	    ?>
	</div><!-- /.col-lg-4 -->
	<div class="col-lg-4">
	    <?=
	    $form->field($model, 'color')->widget('\kartik\widgets\ColorInput', []);
	    ?>
	</div><!-- /.col-lg-4 -->
	
	<div class="col-lg-4">
	    <?=
	    $form->field($model, 'description_i18n')->widget('\common\components\widgets\inputmodal_i18n\InputModalI18n', [
		'button_modal_label' => \Yii::t('translation', 'translation'),
		'fieldType'=>'textarea',
		'options' => [
		    'rows' => 6
		]
	    ]);
	    ?>
	</div><!-- /.col-lg-4 -->
    </div><!-- /.row -->


    <div class="form-group">
	<?= Html::submitButton($model->isNewRecord ? Yii::t('translation', 'Create') : Yii::t('translation', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
