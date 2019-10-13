<?php
namespace App\Http\Controllers\payment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\payment\TransactionRequestBean;
use App\Http\Controllers\payment\TransactionResponseBean;
//ob_start();

class techprocess extends Controller
{
    public static function paymentrequest($requesteddata)
    {
        //$requesteddata = array('Naveen','19872627','8807366672','620636','1.00','14-03-2017',url('paymentresponse'),'Naveen');

        //$requesteddata = array('Cutsomername','customerid','customermobileno','transactionno','amount','transactiondate','returnuel','yourreturndata');

        $transactionRequestBean = new TransactionRequestBean;
        $setMerchantCode        = 'T100775';
        $setAccountNo           = '';
        $setITC                 = $requesteddata[7];
        $setMobileNumber        = $requesteddata[2];
        $setCustomerName        = $requesteddata[0];
        $setRequestType         = 'T';
        $setMerchantTxnRefNumber= $requesteddata[3];
        $setAmount              = $requesteddata[4];
        $setCurrencyCode        = 'INR';
        $setReturnURL           = $requesteddata[6];
        $setS2SReturnURL        = 'https://tpslvksrv6046/LoginModule/Test.jsp';
        $setShoppingCartDetails = 'Test_1.0_0.0';
        $setTxnDate             = $requesteddata[5];
        $setBankCode            = '470';
        $setTPSLTxnID           = $requesteddata[3];
        $setCustId              = $requesteddata[1];
        $setCardId              = '';
        $setKey                 = '2639479625KICIXM';
        $setIv                  = '3974220337BANPMH';
        $setWebServiceLocator   = 'https://www.tekprocess.co.in/PaymentGateway/TransactionDetailsNew.wsdl';
        $setMMID                = '';
        $setOTP                 = '';
        $setCardName            = '';
        $setCardNo              = '';
        $setCardCVV             = '';
        $setCardExpMM           = '';
        $setCardExpYY           = '';
        $setTimeOut             = '';
        //Setting all values here
        $transactionRequestBean->setMerchantCode($setMerchantCode);
        $transactionRequestBean->setAccountNo($setAccountNo);
        $transactionRequestBean->setITC($setITC);
        $transactionRequestBean->setMobileNumber($setMobileNumber);
        $transactionRequestBean->setCustomerName($setCustomerName);
        $transactionRequestBean->setRequestType($setRequestType);
        $transactionRequestBean->setMerchantTxnRefNumber($setMerchantTxnRefNumber);
        $transactionRequestBean->setAmount($setAmount);
        $transactionRequestBean->setCurrencyCode($setCurrencyCode);
        $transactionRequestBean->setReturnURL($setReturnURL);
        $transactionRequestBean->setS2SReturnURL($setS2SReturnURL);
        $transactionRequestBean->setShoppingCartDetails($setShoppingCartDetails);
        $transactionRequestBean->setTxnDate($setTxnDate);
        $transactionRequestBean->setBankCode($setBankCode);
        $transactionRequestBean->setTPSLTxnID($setTPSLTxnID);
        $transactionRequestBean->setCustId($setCustId);
        $transactionRequestBean->setCardId($setCardId);
        $transactionRequestBean->setKey($setKey);
        $transactionRequestBean->setIv($setIv);
        $transactionRequestBean->setWebServiceLocator($setWebServiceLocator);
        $transactionRequestBean->setMMID($setMMID);
        $transactionRequestBean->setOTP($setOTP);
        $transactionRequestBean->setCardName($setCardName);
        $transactionRequestBean->setCardNo($setCardNo);
        $transactionRequestBean->setCardCVV($setCardCVV);
        $transactionRequestBean->setCardExpMM($setCardExpMM);
        $transactionRequestBean->setCardExpYY($setCardExpYY);
        $transactionRequestBean->setTimeOut($setTimeOut);

        // $url = $transactionRequestBean->getTransactionToken();
        //print_r($transactionRequestBean);
        $responseDetails = $transactionRequestBean->getTransactionToken();

        //print_r($responseDetails);
        $responseDetails = (array)$responseDetails;
        $response = $responseDetails[0];

        if(is_string($response) && preg_match('/^msg=/',$response)){
        $outputStr = str_replace('msg=', '', $response);
        $outputArr = explode('&', $outputStr);
        $str = $outputArr[0];

        $transactionResponseBean = new TransactionResponseBean();
        $transactionResponseBean->setResponsePayload($str);
        $transactionResponseBean->setKey($val['key']);
        $transactionResponseBean->setIv($val['iv']);

        $response = $transactionResponseBean->getResponsePayload();
        echo "<pre>";
        print_r($response);
        exit;
        }elseif(is_string($response) && preg_match('/^txn_status=/',$response)){
        echo "<pre>";
        print_r($response);
        exit;
        }
        //print_r($response);
        return $response;
        //echo "<script>window.location = '".$response."'</script>";
        //ob_flush();
    }
    public static function paymentresponse($response)
    {
        //$response = $_POST;
        if(is_array($response)){
            $str = $response['msg'];
        }else if(is_string($response) && strstr($response, 'msg=')){
            $outputStr = str_replace('msg=', '', $response);
            $outputArr = explode('&', $outputStr);
            $str = $outputArr[0];
        }else {
            $str = $response;
        }

        $transactionResponseBean = new TransactionResponseBean();

        $transactionResponseBean->setResponsePayload($str);
        $transactionResponseBean->setKey('2639479625KICIXM');
        $transactionResponseBean->setIv('3974220337BANPMH');

        $response = $transactionResponseBean->getResponsePayload();
        //echo "<pre>";
        //print_r($response);
        $array = array();
        preg_match_all("/([^|]+)=([^|]+)/", $response, $array);
 
        $output = array_combine($array[1], $array[2]);
        return $output;
    }
}
?>
