<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
use webapp\modules\communication\models\Trigger;
use webapp\modules\communication\models\TriggerWorkgroupFilter;
use webapp\modules\communication\models\TriggerGroupFilter;

/* @var $this yii\web\View */
/* @var $model webapp\modules\communication\models\Behavior */

$this->title = $model->name;
$this->params['breadcrumbs'][] = Yii::t('translation', 'menu.administration_menu_label');
$this->params['breadcrumbs'][] = Yii::t('translation', 'menu.communication_menu_label');
$this->params['breadcrumbs'][] = ['label' => Yii::t('translation', 'triggers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="behavior-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="text-right">
	<?= Html::a(Yii::t('translation', 'Admin'), ['index'], ['class' => 'btn btn-primary']) ?>  
	<?= Html::a(Yii::t('translation', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
	<?=
	Html::a(Yii::t('translation', 'Delete'), ['delete', 'id' => $model->id], [
	    'class' => 'btn btn-danger',
	    'data' => [
		'confirm' => Yii::t('translation', 'Are you sure you want to delete this item?'),
		'method' => 'post',
	    ],
	])
	?>
    </p>

    <?=
    DetailView::widget([
	'model' => $model,
	'attributes' => [
	    //'id',
	    'name',
		[
		'attribute' => 'type',
		'value' => function($data) {
		    return webapp\modules\communication\models\Trigger::getTypeLabel($data->type);
		}
	    ],
		[
		'attribute' => 'behavior_id',
		'value' => function($data) {
		    return $data->behaviorTrigger->name;
		},
	    ],
		[
		'attribute' => 'event_id',
		'value' => function($data) {
		    if (empty($data->event_id)) {
			return \Yii::t('translation', 'trigger.all_events');
		    }
		    return Yii::t('translation', $data->event->name_i18n);
		},
	    ],
		[
		'attribute' => 'risk_id',
		'value' => function($data) {
		    if (empty($data->risk_id)) {
			return \Yii::t('translation', 'trigger.all_risks');
		    }
		    return Yii::t('translation', $data->risk->name_i18n);
		},
	    ],
		[
		'attribute' => 'alert_status_id',
		'value' => function($data) {
		    if (empty($data->alert_status_id)) {
			return \Yii::t('translation', 'trigger.all_alerts_status');
		    }
		    return Yii::t('translation', $data->alertStatus->name_i18n);
		}
	    ],
	    'description',
	],
    ])
    ?>

    <?php if ($model->type == Trigger::TYPE_INTERNAL) { ?>
        <p class="text-right">
	    <?= Html::a(Yii::t('translation', 'trigger.associate_workgroup_btn'), ['trigger/associate-workgroup', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>
        <h3><?= Yii::t('translation', 'workgroups') ?></h3>
	<?php
	$workgroups = $model->getWorkgroups()->all();
	$dataProvider = new ArrayDataProvider([
	    'allModels' => $workgroups,
	    'sort' => [
		'attributes' => ['name'],
	    ],
	    'pagination' => [
		'pageSize' => 10,
	    ],
	]);

	echo GridView::widget([
	    'dataProvider' => $dataProvider,
	    'columns' => [
		'name',
		    [
		    'attribute' => 'description',
		    'contentOptions' => ['class' => 'text-wrap'],
		],
		    [
		    'label' => \Yii::t('translation', 'workgroup.has_filter_label'),
		    'format' => 'raw',
		    'value' => function ($workgroup) {

			$filter = TriggerWorkgroupFilter::find([
				    'trigger_id' => $model->id,
				    'workgroup_id' => $workgroup->id
				])->one();
			if (!empty($filter)) {
			    return Html::a(\Yii::t('translation', 'workgroup.has_filter_label_yes'), \yii\helpers\Url::toRoute(
						    ['trigger-workgroup-filter/view',
							'workgroup_id' => $filter->workgroup_id,
							'trigger_id' => $filter->trigger_id,
			    ]));
			}
			return \Yii::t('translation', 'workgroup.has_filter_label_no');
		    },
		],
		    [
		    'attribute' => 'status',
		    'value' => function($data) {
			return webapp\modules\operative\models\Workgroup::getStatusLabel($data->status);
		    },
		],
		    [
		    'class' => 'yii\grid\ActionColumn',
		    'contentOptions' => ['class' => 'text-right'],
		    'template' => '{view}',
		    'urlCreator' => function ($action, $model, $key, $index) {
			if ($action === 'view') {
			    return Url::to(['/operative/workgroup/view', 'id' => $model->id]);
			}
		    }
		],
	    ],
	]);
    } elseif ($model->type == Trigger::TYPE_EXTERNAL) {
	?>

        <p class="text-right">
	    <?= Html::a(Yii::t('translation', 'trigger.associate_group_btn'), ['trigger/associate-group', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>
        <h3><?= Yii::t('translation', 'groups') ?></h3>
	<?php
	$groups = $model->getGroups()->all();
	$dataProvider = new ArrayDataProvider([
	    'allModels' => $groups,
	    'sort' => [
		'attributes' => ['name'],
	    ],
	    'pagination' => [
		'pageSize' => 10,
	    ],
	]);

	echo GridView::widget([
	    'dataProvider' => $dataProvider,
	    'columns' => [
		'name',
		    [
		    'attribute' => 'description',
		    'contentOptions' => ['class' => 'text-wrap'],
		],
		    [
		    'label' => \Yii::t('translation', 'group.has_filter_label'),
		    'format' => 'raw',
		    'value' => function ($group) {

			$filter = TriggerGroupFilter::find([
				    'trigger_id' => $model->id,
				    'group_id' => $group->id
				])->one();
			if (!empty($filter)) {
			    return Html::a(\Yii::t('translation', 'group.has_filter_label_yes'), \yii\helpers\Url::toRoute(
						    ['trigger-group-filter/view',
							'group_id' => $filter->group_id,
							'trigger_id' => $filter->trigger_id,
			    ]));
			}
			return \Yii::t('translation', 'group.has_filter_label_no');
		    },
		],
		    [
		    'attribute' => 'status',
		    'value' => function($data) {
			return webapp\modules\communication\models\Group::getStatusLabel($data->status);
		    },
		],
		    [
		    'class' => 'yii\grid\ActionColumn',
		    'contentOptions' => ['class' => 'text-right'],
		    'template' => '{view}',
		    'urlCreator' => function ($action, $model, $key, $index) {
			if ($action === 'view') {
			    return Url::to(['group/view', 'id' => $model->id]);
			}
		    }
		],
	    ],
	]);
    }
    ?>


</div>
