<?php

/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 * @property integer $id
 * @property string $name
 * @property integer $begin_date
 * @property integer $end_date
 * @property string $desc
 * @property string $place_ids
 * @property string $goodscate_ids
 * @property string $first
 * @property string $second
 * @property string $depart_ids
 * @property integer $created
 */
class Project extends CActiveRecord
{
	public static function getUserProject($user_id){
		$userModel = User::model()->findByPk($user_id);
		$depart_id = $userModel->depart_id;
		$now = time();
		$sql = "select p.* from project_depart_relation r left join project p on r.project_id=p.id where r.depart_id=$depart_id and p.begin_date<=$now and p.end_date>=$now";
		return Project::model()->findAllBySql($sql);
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'project';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('depart_ids', 'required'),
			array('created', 'numerical', 'integerOnly'=>true),
			array('name, place_ids, goodscate_ids, depart_ids', 'length', 'max'=>64),
			array('first, second', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, dates, desc, place_ids, goodscate_ids, first, second, depart_ids, created', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '项目名称',
			'dates' => '日期段',
			'desc' => '项目简介',
			'place_ids' => '采价点IDs',
			'goodscate_ids' => '商品',
			'first' => '第一次采价时间',
			'second' => '第二次采价时间',
			'depart_ids' => '部门',
			'created' => '创建时间',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('dates',$this->dates);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('place_ids',$this->place_ids,true);
		$criteria->compare('goodscate_ids',$this->goodscate_ids,true);
		$criteria->compare('first',$this->first,true);
		$criteria->compare('second',$this->second,true);
		$criteria->compare('depart_ids',$this->depart_ids,true);
		$criteria->compare('created',$this->created);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Project the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
