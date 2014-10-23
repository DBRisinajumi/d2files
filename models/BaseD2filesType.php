<?php

/**
 * This is the model base class for the table "d2files_type".
 *
 * Columns in table "d2files_type" available as properties of the model:
 * @property integer $id
 * @property string $type
 * @property string $model
 *
 * Relations of table "d2files_type" available as properties of the model:
 * @property D2files[] $d2files
 */
abstract class BaseD2filesType extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'd2files_type';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('type, model', 'required'),
                array('type, model', 'length', 'max' => 50),
                array('id, type, model', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->type;
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(), array(
                'savedRelated' => array(
                    'class' => '\GtcSaveRelationsBehavior'
                )
            )
        );
    }

    public function relations()
    {
        return array_merge(
            parent::relations(), array(
                'd2files' => array(self::HAS_MANY, 'D2files', 'type_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('D2filesModule.model', 'ID'),
            'type' => Yii::t('D2filesModule.model', 'Type'),
            'model' => Yii::t('D2filesModule.model', 'Model'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.type', $this->type, true);
        $criteria->compare('t.model', $this->model, true);


        return $criteria;

    }

}
