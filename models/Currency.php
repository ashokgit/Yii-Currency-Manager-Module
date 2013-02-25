<?php

/**
 * This is the model class for table "{{currency}}".
 *
 * The followings are the available columns in table '{{currency}}':
 * @property integer $id
 * @property double $conversion_rate
 * @property string $country
 * @property string $currency
 * @property string $currency_code
 * @property integer $status
 * @property string $updated_time
 */
class Currency extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Currency the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{currency}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country, currency, currency_code, updated_time', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('conversion_rate', 'numerical'),
			array('country, currency', 'length', 'max'=>255),
			array('currency_code', 'length', 'max'=>55),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, conversion_rate, country, currency, currency_code, status, updated_time', 'safe', 'on'=>'search'),
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
			'conversion_rate' => 'Conversion Rate(USD:1)',
			'country' => 'Country',
			'currency' => 'Currency',
			'currency_code' => 'Currency Code',
			'status' => 'Status',
			'updated_time' => 'Updated Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('conversion_rate',$this->conversion_rate);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('currency_code',$this->currency_code,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('updated_time',$this->updated_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSave()

    {
        $this->updated_time = date ("Y-m-d H:i:s");
        return true;
    }
}