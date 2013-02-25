Yii-Currency-Manager-Module
===========================

Simple Currency Manager Module for Yii Framework
=================================================================================
INSTALLATION

1. Unzip

2. Copy the webin folder to protected/modules/

3. under config/main/

  'modules'=>array(
  
		'currencymanager',
    
	),
  
4 You are ready to go

=================================================================================
FEATURES

1. List of all currencies around the world

2. Update all or selected curriencies using google currency converter (requires admin login)

3. Widget for currency dropdown select box (Choosen enabled).

4. Currency converter with respect to USD

5. Set default currency in yii session as your desired currency code or get currency code based on user's geographical location

=================================================================================
USAGE

To display active and nonzero currency fields as DropDown , simply call "currencymanager.widgets.GetCurrencyDropdown"

//it sets Yii::app()->session['currency'] to the desired currency thru ajax post // no furthur coding required

//set reloadgrid as true (optional) if you have some gird to reload after changing the currency

//or change the view file "_select" of this widget under widgets/views

<?php 

	$this->widget('currencymanager.widgets.GetCurrencyDropdown'
  
						//,array(
            
							//'reloadgrid'=>true //Default False
              
							//,'filterzeros'=>false //Default true
              
							//)
              
				) 
        
?>
=================================================================================

To change $(USD) currency to XXX currency simply call


Yii::app()->getModule('currencymanager')->convertcurrency($to,$price); 


$to : (string) to the desired currency format eg: to change to european: "EUR"

$price : (numerical) the desired price to be converted


=================================================================================
To set the default currency to XXX simply call

Yii::app()->getModule('currencymanager')->setdefaultcurrency($currency_code);

it saves the currency code to yii session. to retrive this value simply call : Yii::app()->session['currency']

Note: $currencycode is optional. If it not set, it will find the user's ip and the geolocation and hence the currency code
 
