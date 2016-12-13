<?php

/**
 * This is the model class for table "project_goodscate_relation".
 *
 * The followings are the available columns in table 'project_goodscate_relation':
 * @property integer $project_id
 * @property integer $goodscate_id
 */
class ProjectGoodscateRelation extends CActiveRecord {
    
    public static function batchInsert($project_id, $goodscate_ids) {
        $r = ProjectGoodscateRelation::model()->deleteAllByAttributes(array('project_id' => $project_id));
        if (!$goodscate_ids) {
            return true;
        }
        $sql = "insert into project_goodscate_relation (project_id,goodscate_id) values ";
        foreach ($goodscate_ids as $k => $v) {
            $sql .= "('{$project_id}','{$v}'),";
        }
        $sql = rtrim($sql, ',');
        return Yii::app()->db->createCommand($sql)->execute();
    }
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'project_goodscate_relation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('project_id, goodscate_id', 'required'),
            array('project_id, goodscate_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('project_id, goodscate_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'project_id' => '项目ID',
            'goodscate_id' => '商品ID',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('project_id', $this->project_id);
        $criteria->compare('goodscate_id', $this->goodscate_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProjectGoodscateRelation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
