<?php

/**
 * File Payu.php.
 *
 * @author Anish Madhu <anish.adm.madhu@gmail.com>
 * @see https://github.com/paypal/rest-api-sdk-php/blob/master/sample/
 * @see https://developer.paypal.com/webapps/developer/applications/accounts
 */

namespace Anish;

use yii\base\Component;
use OpenPayUBase;
use OpenPayU;
use OpenPayU_Order;
use OpenPayU_Configuration;

/**
 * Class Payu.
 *
 * @package Anish
 * @author Ainsh Madhu <anish.adm.madhu@gmail.com>
 */
class Payu extends Component {

    public function testDemo() {
        echo 'hay this is test method';
        OpenPayU_Configuration::setEnvironment('secure');
        OpenPayU_Configuration::setMerchantPosId('145227');
        OpenPayU_Configuration::setSignatureKey('13a980d4f851f3d9a1cfc792fb1f5e50');
        $openpay = new OpenPayU_Order();
        $order['continueUrl'] = 'http://localhost/'; //customer will be redirected to this page after successfull payment
        $order['notifyUrl'] = 'http://localhost/';
        $order['customerIp'] = $_SERVER['REMOTE_ADDR'];
        $order['merchantPosId'] = OpenPayU_Configuration::getMerchantPosId();
        $order['description'] = 'New order';
        $order['currencyCode'] = 'PLN';
        $order['totalAmount'] = 3200;
        $order['extOrderId'] = '6545651566456'; //must be unique!

        $order['products'][0]['name'] = 'Product1';
        $order['products'][0]['unitPrice'] = 1000;
        $order['products'][0]['quantity'] = 1;

        $order['products'][1]['name'] = 'Product2';
        $order['products'][1]['unitPrice'] = 2200;
        $order['products'][1]['quantity'] = 1;

//optional section buyer
        $order['buyer']['email'] = 'dd@ddd.pl';
        $order['buyer']['phone'] = '123123123';
        $order['buyer']['firstName'] = 'Jan';
        $order['buyer']['lastName'] = 'Kowalski';

        $response = $openpay->create($order);

        $res = $response->getResponse();
        if($res->status->statusCode == 'SUCCESS'){
            echo "Success";
        } exit;
        header('Location:' . $response->getResponse()->redirectUri);

        $openpay->create($order);
    }

}
