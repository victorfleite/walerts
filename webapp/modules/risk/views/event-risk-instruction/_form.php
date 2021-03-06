<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model webapp\modules\risk\models\EventRiskInstruction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-risk-instruction-form">

    <div class="alert alert-info">
	<p><strong><i class='fa fa-book'></i> <?php echo \Yii::t('translation', 'event_risk_instruction.documentation'); ?></strong></p>
    </div>

    <?php $form = ActiveForm::begin(['layout' => 'default']); ?>

    <?= $form->errorSummary($model) ?>


    <div class="row">	
	<div class="col-lg-6">
	    <?php
	    $events = webapp\modules\risk\models\Event::getTranslatedComboArray('id', 'name_i18n');
	    echo $form->field($model, 'event_id')->dropDownList($events, ['prompt' => '']);
	    ?>
	</div><!-- /.col-lg-6 -->

	<div class="col-lg-6">
	    <?php
	    $risks = webapp\modules\risk\models\Risk::getTranslatedComboArray('id', 'name_i18n');
	    echo $form->field($model, 'risk_id')->dropDownList($risks, ['prompt' => '']);
	    ?>
	</div><!-- /.col-lg-6 -->
    </div><!-- /.row -->

    <div class="form-group">
	<?= Html::submitButton($model->isNewRecord ? Yii::t('translation', 'Create') : Yii::t('translation', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
