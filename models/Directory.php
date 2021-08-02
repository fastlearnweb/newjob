<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "directory".
 *
 * @property int $id
 * @property string $lastname
 * @property string $firstname
 * @property string $middlename
 * @property string|null $date
 */
class Directory extends \yii\db\ActiveRecord
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
        return 'directory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lastname', 'firstname', 'middlename'], 'required'],
            [['id'], 'integer'],
            [['date'], 'safe'],
            [['lastname', 'firstname', 'middlename'], 'string', 'min'=>'2', 'max' => 128],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lastname' => 'Lastname',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'date' => 'Date',
        ];
    }
	
	
	 public function fields()
    {
        $fields = ["id", "firstname", "lastname", "middlename", "date", "phones"];
        if (self::SCENARIO_LIGHT_FIELDS === $this->scenario) {
            // ТОЛЬКО поля "id" и "profile" выведутся при сценарии "lightFields"
            // При том, что поле "profile" - это relation hasOne к модели Profile
            $fields =  array_intersect($fields, ['id', 'phones']);
        }
        return $fields;
    }
    
	
public function getPhones()
    {
        return $this->hasMany(Phones::className(), ['user_id' => 'id']);
    }
}
