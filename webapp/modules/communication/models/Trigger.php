<?php

namespace webapp\modules\communication\models;

use Yii;
use \webapp\modules\communication\models\base\Trigger as BaseTrigger;

/**
 * This is the model class for table "communication.trigger".
 */
class Trigger extends BaseTrigger implements \common\components\traits\SimpleStatusInterface {

    use \common\components\traits\SimpleStatusTrait;

    const TYPE_INTERNAL = 'I';
    const TYPE_EXTERNAL = 'E';

    /**
     * @inheritdoc
     */
    public function rules() {
	return [
		[['behavior_id', 'event_id', 'risk_id', 'alert_status_id'], 'integer'],
		[['name', 'behavior_id', 'type', 'status'], 'required'],
		[['description'], 'safe'],
		[['behavior_id', 'event_id', 'risk_id', 'alert_status_id'], 'checkUnique'],
	];
    }

    public function checkUnique($attribute, $params, $validator) {

	$eventId = $this->event_id;
	if (empty($eventId)) {
	    $eventId = null;
	}
	$riskId = $this->risk_id;
	if (empty($riskId)) {
	    $riskId = null;
	}
	$alertStatusId = $this->alert_status_id;
	if (empty($alertStatusId)) {
	    $alertStatusId = null;
	}
	
	$query = Trigger::find()->where([
	    'behavior_id' => $this->behavior_id,
	    'event_id' => $eventId,
	    'risk_id' => $riskId,
	    'alert_status_id' => $alertStatusId,
	    'type' => $this->type]
	);

	if (!$this->isNewRecord) {
	    $query->andWhere(['<>', 'id', $this->id]);
	}
	$founded = $query->exists();
	if ($founded) {
	    $this->addError($attribute, \Yii::t('translation', 'trigger.unique_key_behavior_status_event_risk_type'));
	}
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
	return [
	    'id' => Yii::t('translation', 'trigger.id'),
	    'behavior_id' => Yii::t('translation', 'trigger.behavior_id'),
	    'type' => Yii::t('translation', 'trigger.type'),
	    'event_id' => Yii::t('translation', 'trigger.event_id'),
	    'risk_id' => Yii::t('translation', 'trigger.risk_id'),
	    'name' => Yii::t('translation', 'trigger.name'),
	    'description' => Yii::t('translation', 'trigger.description'),
	    'alert_status_id' => Yii::t('translation', 'trigger.alert_status_id'),
	];
    }

    /**
     * @return Array Groups
     */
    public function getAllGroupsIds() {
	$groups = parent::getGroups()->all();
	$groupsIds = [];
	if (is_array($groupsIds)) {
	    foreach ($groups as $g) {
		$groupsIds[] = $g->id;
	    }
	}

	return $groupsIds;
    }

    /**
     * @return All Workgroups
     */
    public function getAllWorkgroupsIds() {
	$workgroups = parent::getWorkgroups()->all();
	$workgroupsIds = [];
	if (is_array($workgroupsIds)) {
	    foreach ($workgroups as $w) {
		$workgroupsIds[] = $w->id;
	    }
	}
	return $workgroupsIds;
    }

    /**
     * Get the label of a type
     * @param type $type
     * @return type
     */
    public static function getTypeLabel($type) {
	switch ($type) {
	    case self::TYPE_INTERNAL:
		return \Yii::t('translation', 'trigger.type_internal');
		break;
	    case self::TYPE_EXTERNAL:
		return \Yii::t('translation', 'trigger.type_external');
		break;
	}
    }

    /**
     * Get the array of types
     * @return type
     */
    public static function getComboType() {
	$arr = [];
	$arr[self::TYPE_INTERNAL] = \Yii::t('translation', 'trigger.type_internal');
	$arr[self::TYPE_EXTERNAL] = \Yii::t('translation', 'trigger.type_external');
	return $arr;
    }

    public function afterSave($insert, $changedAttributes) {
	parent::afterSave($insert, $changedAttributes);

	/**
	 * Remove all references of relationals
	 */
	if ($this->type == Trigger::TYPE_EXTERNAL) {
	    RlTriggerWorkgroup::deleteAll(['trigger_id' => $this->id]);
	}

	/**
	 * Remove all references of relationals
	 */
	if ($this->type == Trigger::TYPE_INTERNAL) {
	    RlTriggerGroup::deleteAll(['trigger_id' => $this->id]);
	}
    }

}
