<?php

namespace webapp\modules\local\models;

use \Yii;
use webapp\modules\local\models\base\Region as BaseRegion;
use \common\components\behaviors\PolygonBehavior;

/**
 * This is the model class for table "local.region".
 */
class Region extends BaseRegion {

    /**
     * @inheritdoc
     */
    public function rules() {
	return [
		[['nm_meso', 'country_id', 'geom'], 'required'],
		[['geom'], 'string'],
		[['geom'], \common\components\validators\WktValidator::className()],
		[['country_id'], 'required'],
		[['country_id', 'batch_id'], 'integer'],
		[['nm_meso'], 'string', 'max' => 100],
		[['description'], 'string', 'max' => 1000],
		[['cd_geocodu'], 'string', 'max' => 2],
		[['description'], 'safe']
	];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
	return [
	    'gid' => Yii::t('translation', 'region.gid'),
	    'nm_meso' => Yii::t('translation', 'region.nm_meso'),
	    'cd_geocodu' => Yii::t('translation', 'region.cd_geocodu'),
	    'geom' => Yii::t('translation', 'region.geom'),
	    'country_id' => Yii::t('translation', 'region.country_id'),
	    'batch_id' => Yii::t('translation', 'region.batch_id'),
	    'description' => Yii::t('translation', 'region.description'),
	];
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors() {
	return array_merge(parent::behaviors(), [
	    'geometry' => [
		'class' => PolygonBehavior::className(),
		'attribute' => 'geom',
		'type' => PolygonBehavior::GEOMETRY_POLYGON,
		'pk_name' => 'gid',
	    ]
	]);
    }

}
