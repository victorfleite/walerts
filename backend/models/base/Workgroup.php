<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "operative.workgroup".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 * @property \app\models\OperativeRlWorkgroupJurisdiction[] $operativeRlWorkgroupJurisdictions
 * @property \app\models\OperativeJurisdiction[] $jurisdictions
 * @property \app\models\OperativeRlWorkgroupUser[] $operativeRlWorkgroupUsers
 * @property \app\models\User[] $users
 */
class Workgroup extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 150],
            [['description'], 'string', 'max' => 500]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operative.workgroup';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('translation', 'ID'),
            'name' => Yii::t('translation', 'Name'),
            'description' => Yii::t('translation', 'Description'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRlWorkgroupJurisdictions()
    {
        return $this->hasMany(\app\models\RlWorkgroupJurisdiction::className(), ['workgroup_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJurisdictions()
    {
        return $this->hasMany(\app\models\Jurisdiction::className(), ['id' => 'jurisdiction_id'])->viaTable('rl_workgroup_jurisdiction', ['workgroup_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRlWorkgroupUsers()
    {
        return $this->hasMany(\app\models\RlWorkgroupUser::className(), ['workgroup_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(\common\models\User::className(), ['id' => 'user_id'])->viaTable('rl_workgroup_user', ['workgroup_id' => 'id']);
    }
    
/**
     * @inheritdoc
     * @return array mixed
     */ 
    public function behaviors()
    {
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
            ],
            'uuid' => [
                'class' => UUIDBehavior::className(),
                'column' => 'id',
            ],
        ];
    }
}