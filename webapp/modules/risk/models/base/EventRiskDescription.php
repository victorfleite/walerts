<?php

namespace webapp\modules\risk\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "risk.event_risk_description".
 *
 * @property integer $id
 * @property string $name_i18n
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $risk_id
 * @property integer $event_id
 * @property string $hash
 *
 * @property \webapp\modules\risk\models\RiskEvent $event
 * @property \webapp\modules\risk\models\RiskRisk $risk
 */
class EventRiskDescription extends \yii\db\ActiveRecord {


    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames() {
	return [
	    'event',
	    'risk'
	];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
	return [
		[['name_i18n', 'risk_id', 'event_id'], 'required'],
		[['created_at', 'updated_at'], 'safe'],
		[['created_by', 'updated_by', 'risk_id', 'event_id'], 'integer'],
		[['hash'], 'string'],
		[['name_i18n'], 'string', 'max' => 300],
		[['risk_id', 'event_id'], 'unique', 'targetAttribute' => ['risk_id', 'event_id'], 'message' => 'The combination of Risk ID and Event ID has already been taken.']
	];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
	return 'risk.event_risk_description';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
	return [
	    'id' => Yii::t('translation', 'ID'),
	    'name_i18n' => Yii::t('translation', 'Name I18n'),
	    'risk_id' => Yii::t('translation', 'Risk ID'),
	    'event_id' => Yii::t('translation', 'Event ID'),
	    'hash' => Yii::t('translation', 'Hash'),
	];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent() {
	return $this->hasOne(\webapp\modules\risk\models\Event::className(), ['id' => 'event_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRisk() {
	return $this->hasOne(\webapp\modules\risk\models\Risk::className(), ['id' => 'risk_id']);
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors() {
	return [
	    'timestamp' => [
		'class' => TimestampBehavior::className(),
		'createdAtAttribute' => 'created_at',
		'updatedAtAttribute' => 'updated_at',
		'value' => new \yii\db\Expression('NOW()'),
	    ],
	    'blameable' => [
		'class' => BlameableBehavior::className(),
		'createdByAttribute' => 'created_by',
		'updatedByAttribute' => 'updated_by',
		'value' => \Yii::$app->user->id,
	    ],
	];
    }

}
