<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model webapp\models\Language */

$this->title = Yii::t('translation', 'Create Language');
$this->params['breadcrumbs'][] = ['label' => Yii::t('translation', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
