<?php

/**
 * This is the model class for table "price_log".
 *
 * The followings are the available columns in table 'price_log':
 * @property string $id
 * @property integer $project_id
 * @property integer $goodscate_id
 * @property integer $place_id
 * @property integer $goods_id
 * @property string $price
 * @property integer $project_dates
 * @property string $project_first
 * @property string $project_second
 * @property integer $user_type
 * @property integer $user_id
 * @property string $reason
 * @property integer $created
 */
class PriceLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'price_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('times,project_id, goodscate_id, place_id, goods_id, project_dates, user_type, user_id, created', 'numerical', 'integerOnly'=>true),
			array('price', 'length', 'max'=>10),
			array('project_first, project_second,project_name', 'length', 'max'=>64),
			array('reason', 'length', 'max'=>512),
			array('date', 'length', 'max'=>8),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id,project_name,project_desc, project_id, goodscate_id, place_id, goods_id, price,project_dates, project_first, project_second, user_type, user_id, reason, created', 'safe', 'on'=>'search'),
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
                    'project'=>array(self::BELONGS_TO,'Project','project_id'),
                    'goodscate'=>array(self::BELONGS_TO,'GoodsCategory','goodscate_id'),
                    'place'=>array(self::BELONGS_TO,'Place','place_id'),
                    'goods'=>array(self::BELONGS_TO,'Goods','goods_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'project_id' => '项目ID',
			'goodscate_id' => '商品一级分类ID',
			'place_id' => '采价点ID',
			'goods_id' => '商品ID',
			'price' => '价格',
			'project_dates' => '项目日期段',
			'project_first' => '项目第一次采价时间',
			'project_second' => '项目第二次采价时间',
			'user_type' => '0是采价员，1是部门管理员，2是总管理员',
			'user_id' => '操作员ID',
			'reason' => '操作理由',
			'created' => '采价时间',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('goodscate_id',$this->goodscate_id);
		$criteria->compare('place_id',$this->place_id);
		$criteria->compare('goods_id',$this->goods_id);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('project_dates',$this->project_dates);
		$criteria->compare('project_first',$this->project_first,true);
		$criteria->compare('project_second',$this->project_second,true);
		$criteria->compare('user_type',$this->user_type);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('created',$this->created);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PriceLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
