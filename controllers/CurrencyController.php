<?php

class CurrencyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','updateconversionrate'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Currency;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Currency']))
		{
			$model->attributes=$_POST['Currency'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Currency']))
		{
			$model->attributes=$_POST['Currency'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionUpdateconversionrate($id=false){
		
		Yii::import('application.modules.currencymanager.extensions.ECurrencyHelper');
		$cc = new ECurrencyHelper();
		
		//update all
		if(!$id && !isset($_POST['id'])){
			$model = Currency::model()->findAll();
			foreach ($model as $row){
				//get currency Code
				$currency = $row->currency_code;
				//convert it with respect to one usd
				$conversion = $cc->convert('USD',$currency,1, ECurrencyHelper::USE_GOOGLE);
				//update this row
				Currency::model()->updateByPk($row->id, array('conversion_rate' =>$conversion));
			}
		}
        elseif(isset($_POST['id'])){
            $autoIdAll = $_POST['id'];
            if(count($autoIdAll)>0){
                foreach($autoIdAll as $autoId){
                    $model=$this->loadModel($autoId);
                    $currency = $model->currency_code;
                    $model->conversion_rate = $cc->convert('USD',$currency,1, ECurrencyHelper::USE_GOOGLE);
                    $model->save();
                }
            }
            echo 'ok';
            exit();
        }
        else{
			//load this id
			$model=$this->loadModel($id);
			$currency = $model->currency_code;
			$model->conversion_rate = $cc->convert('USD',$currency,1, ECurrencyHelper::USE_GOOGLE);
			$model->save();
		}
		//redirect to admin
		$this->redirect(array('currency/admin'));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Currency');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Currency('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Currency']))
			$model->attributes=$_GET['Currency'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Currency::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='currency-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
