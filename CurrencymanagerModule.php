<?php

class CurrencymanagerModule extends CWebModule
{

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'currencymanager.models.*',
			'currencymanager.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

    public function convertcurrency($to,$price){
        //find the to conversion rate
        $model = Currency::model()->findByAttributes(array('currency_code'=>$to));
        return round($model->conversion_rate*$price,2);
    }
    
	public function setdefaultcurrency($currency=''){
        $currency = strtoupper($currency);
        if($currency==''){
            Yii::import('application.modules.currencymanager.extensions.EGeoIP.EGeoIP');
            $geoIp = new EGeoIP();
            $userip = self::getRealIpAddr();
            $geoIp->locate($userip);
            if($geoIp->currencyCode!='' || $geoIp->currencyCode!=false || $geoIp->currencyCode!=null)
                Yii::app()->session['currency'] = $geoIp->currencyCode;
            else
                Yii::app()->session['currency'] = 'USD';
        }elseif($currency!=''){
            Yii::app()->session['currency'] = $currency;
        }
        return true;
    }
}
