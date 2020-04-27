<?php
class BraintreeController extends CController
{

	public $layout='singlemerchant.views.layouts.mobile_layout';
	
	public function __construct()
	{
		Yii::app()->setImport(array(			
		  'application.components.*',
		));		
		require_once 'Functions.php';
	}
	
	public function actionIndex()
	{
		require_once('buy.php');
		
		$device_id = isset($_GET['device_id'])?$_GET['device_id']:'';
		
		if(empty($error)){
			$merchant_type=1;
			if (FunctionsV3::isMerchantPaymentToUseAdmin($merchant_id)){
				$merchant_type=2;
			}
			if($client_token=BraintreeClass::generateCLientToken($merchant_type,$client_id,$merchant_id)){
				
				$success_url = websiteUrl()."/singlemerchant/braintree/verify/?reference_id=".urlencode($reference_id);
				$success_url.="&device_id=".urlencode($device_id);
				
				if($merchant_id>0){
				    $logo = FunctionsV3::getMerchantLogo($merchant_id);		
			    } else $logo = FunctionsV3::getDesktopLogo();							
					 
			    $cs = Yii::app()->getClientScript();
				$cs->registerScriptFile("https://js.braintreegateway.com/js/braintree-2.23.0.min.js");
				
				$cs->registerScript(
				  'clientToken',
				  "var clientToken = '$client_token'; ",
				  CClientScript::POS_HEAD
				);			
				
				$cs->registerScript(
				  'dropin',
				 'braintree.setup(clientToken, "dropin", {
				    container: "payment-form"
				  });',
				  CClientScript::POS_HEAD
				);			
				
				$this->render('singlemerchant.views.index.braintree_buy',array(				       
			       'logo'=>$logo,				
			       'reference_id'=>$reference_id,			       
			       'amount_to_pay'=>$amount_to_pay,	
			       'payment_description'=>$payment_description,		       
			       'client_token'=>$client_token,
			       'success_url'=>$success_url
			    ));
				
			} else $error = t("Failed generating client token");
		}
		
		if(!empty($error)){				
			$this->redirect(Yii::app()->createUrl('/singlemerchant/braintree/error',array(
			   'error'=>$error
			))); 
		}
	}
	
	public function actionverify()
	{		
		$error='';
		$reference_id = isset($_GET['reference_id'])?$_GET['reference_id']:'';
		$payment_method_nonce = isset($_POST['payment_method_nonce'])?$_POST['payment_method_nonce']:'';
		$device_id = isset($_GET['device_id'])?$_GET['device_id']:'';	
		
		if(!empty($payment_method_nonce)){
			if ($res = FunctionsV3::getOrderByToken($reference_id)){
				$merchant_id = $res['merchant_id'];
				$order_id = $res['order_id'];				
				$client_id = $res['client_id'];
				
				$amount_to_pay =  Yii::app()->functions->normalPrettyPrice($res['total_w_tax']);
				$amount_to_pay=unPrettyPrice($amount_to_pay);	   
				
				$merchant_type=1;				
				if (FunctionsV3::isMerchantPaymentToUseAdmin($merchant_id)){
		            $merchant_type=2;
	            }
	            
	            if($client_info = Yii::app()->functions->getClientInfo($client_id)){
	            	
	               $transaction_id=BraintreeClass::PaymentMethod(
				      $merchant_type,
				      $merchant_id,
				      $amount_to_pay,
				      $payment_method_nonce,
				      $client_info['first_name'],
				      $client_info['last_name']
			       );			       
			       if($transaction_id){
			       	
			       	    /*SEND EMAIL RECEIPT*/
			            SingleAppClass::sendNotifications($order_id);
			            
			       	    FunctionsV3::updateOrderPayment($order_id,'btr',
    	    		    $transaction_id,'',$reference_id);
    	    		    
    	    		    FunctionsV3::callAddons($order_id);
    	    		    
    	    		    /*CLEAR CART*/
	                    SingleAppClass::clearCartByCustomerID($client_id); 
    	    		    
    	    		    $message = Yii::t("singleapp","payment successfull with payment reference id [ref]",array(
                            '[ref]'=>$transaction_id
                        ));
                        $this->redirect(Yii::app()->createUrl('/singlemerchant/braintree/success',array(
						   'message'=>$message
						 ))); 	
	    		  	    Yii::app()->end();  
			       	
			       } else $error=t("Error processing transaction");
	            } else $error = t("client information not found");
	          
			} else $error = t("Failed getting order information");
		} else $error=t("Payment Failed");
		
		if(!empty($error)){									
			$this->redirect(Yii::app()->createUrl('/singlemerchant/braintree/error',array(
			   'error'=>$error
			))); 
		}
	}
	
	public function actionsuccess()
	{
		$msg = isset($_GET['message'])?$_GET['message']:'';
		if(!empty($msg)){
			echo $msg;
		} else {
			echo st("payment successfull");
		}
	}
	
	public function actionerror()
	{
		$error = isset($_GET['error'])?$_GET['error']:'';
		if(!empty($error)){
			echo $error;
		} else echo t("undefined error");
	}
	
}
/*END CLASS*/