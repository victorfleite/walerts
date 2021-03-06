<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RegionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('translation', 'regions');
$this->params['breadcrumbs'][] = Yii::t('translation', 'menu.administration_menu_label');
$this->params['breadcrumbs'][] = Yii::t('translation', 'menu.local_menu_label');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p class="text-right">
        <?= Html::a(Yii::t('translation', 'region.create_btn'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nm_meso',
            [
		'attribute' => 'country_id',
		'value' => 'country.name',
	    ],

            ['class' => 'yii\grid\ActionColumn',
		'contentOptions' => ['class' => 'text-right'],
	    ],
        ],
    ]); ?>
</div>
