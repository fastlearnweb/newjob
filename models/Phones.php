<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "phones".
 *
 * @property int $id
 * @property int $user_id
 * @property string $phone
 */
class Phones extends \yii\db\ActiveRecord
{
	
	    const SCENARIO_LIGHT_FIELDS = 'lightFields';
    
    public function scenarios()
    {
        return \yii\helpers\ArrayHelper::merge(parent::scenarios(), [
            // Пустой массив означает, что отработают все rules данной модели при валидации для этого сценария
            // см. валидаторы..
            self::SCENARIO_LIGHT_FIELDS => [],
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
			['phone', 'match', 'pattern' => '/^(8)(\d{10})$/', 'message' => 'Телефона, должно быть в формате 8XXXXXXXXXX' ],
			
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'phone' => 'Phone',
        ];
    }
	
	    public function fields()
    {
        $fields = ["id", "user_id", "phone"];
        if (self::SCENARIO_LIGHT_FIELDS === $this->scenario) {
            // ТОЛЬКО поля "first_name" и "last_name" выведутся при сценарии "lightFields"
            $fields =  array_intersect($fields, ['phone']);
        }
        return $fields;
    }
}
