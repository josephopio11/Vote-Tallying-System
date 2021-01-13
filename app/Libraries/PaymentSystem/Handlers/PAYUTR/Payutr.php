<?php
namespace App\Libraries\PaymentSystem\Handlers\PAYUTR;

use App\Libraries\PaymentSystem\Handlers\PaymentInterface;
use App\Libraries\PaymentSystem\Handlers\PAYUTR\PayutrConfig;

class Payutr implements PaymentInterface
{

    protected $paymentData;
    protected $config;
    protected $products;
    protected $errors = [];
    protected $urlBack;
    protected $url3Ds;
    protected $buyerData;
    protected $billingData;
    protected $shippingData;
    protected $authData;
    protected $cardData;
    protected $language;
    protected $threeDSHtmlContent;

    //------------------------------------------------------------------------//

    public function __construct()
    {
        $this->config = new PayutrConfig();
        $this->setPaymentMethod($this->config->paymentMethod);
    }

    //------------------------------------------------------------------------//

    public function setPaymentID($payment_id)
    {
        $this->paymentData['c4_payment_id'] = $payment_id;
    }

    public function getPaymentID()
    {
        return $this->paymentData['c4_payment_id'] ?? '';
    }

    public function setInvoiceID($invoice_id)
    {
        $this->paymentData['c4_invoice_id'] = $invoice_id;
    }

    public function getInvoiceID()
    {
        return $this->paymentData['c4_invoice_id'] ?? '';
    }

    public function setOrderRef($order_ref = null)
    {
        $this->paymentData['order_ref'] = $order_ref;
    }

    public function getOrderRef()
    {
        return $this->paymentData['order_ref'] ?? '';
    }

    public function createOrderRef()
    {
        $this->setOrderRef(md5(uniqid(mt_rand(), true)));
        return $this->getOrderRef();
    }

    public function setDate($date = null)
    {
        if (empty($date))
        {
            $date = date('Y-m-d H:i:s');
        }

        $this->paymentData['date'] = $date;
    }

    public function getDate()
    {
        return $this->paymentData['date'] ?? date('Y-m-d H:i:s');
    }

    public function setAmount($amount)
    {
        return $this->paymentData['amount'] = $amount;
    }

    public function getAmount()
    {
        if (isset($this->paymentData['amount']) && !empty($this->paymentData['amount']))
        {
            return $this->paymentData['amount'];
        }

        if (!empty($this->getProducts()))
        {
            $total = 0;

            foreach ($this->getProducts() as $productData)
            {
                $total += floatval($productData['price']);
            }

            $this->setAmount($total);
        }

        return $this->paymentData['amount'] ?? 0.0;
    }

    public function setCurrency($currency)
    {
        $this->paymentData['currency'] = strtoupper($currency);
    }

    public function getCurrency()
    {
        return $this->paymentData['currency'] ?? NULL;
    }

    public function setPaymentMethod($payment_method)
    {
        $this->paymentData['payment_method'] = $payment_method;
    }

    public function getPaymentMethod()
    {
        return $this->paymentData['payment_method'] ?? NULL;
    }

    public function setJsonData($json_data)
    {
        $this->paymentData['json_data'] = json_encode($json_data, JSON_PRETTY_PRINT);
    }

    public function getJsonData(): array
    {
        if (!empty($this->paymentData['json_data']))
        {
            return json_decode($this->paymentData['json_data'], true);
        }

        return [];
    }

    public function setCheckoutStatus($checkout_status)
    {
        //SUCCESS 3DS_URL 3DS_HTMLCONTENT FAILED REFUNDED

        $this->paymentData['checkout_status'] = $checkout_status;
    }

    public function getCheckoutStatus()
    {
        return $this->paymentData['checkout_status'] ?? NULL;
    }

    public function setResponseStatus($responseStatus)
    {
        $this->paymentData['response_status'] = $responseStatus;
    }

    public function getResponseStatus()
    {
        return $this->paymentData['response_status'] ?? NULL;
    }

    public function setResponseID($response_id)
    {
        $this->paymentData['response_id'] = $response_id;
    }

    public function getResponseID()
    {
        return $this->paymentData['response_id'] ?? '';
    }

    public function setResponseData($response_data)
    {
        if (is_array($response_data) || is_object($response_data))
        {
            $response_data = json_encode($response_data, JSON_PRETTY_PRINT);
        }

        $this->paymentData['response_data'] = $response_data;
    }

    public function getResponseData()
    {
        return $this->paymentData['response_data'];
    }

    public function getPaymentData()
    {
        return $this->paymentData;
    }

    public function setPaymentData($paymentData)
    {
        $this->paymentData = $paymentData;
    }

    //------------------------------------------------------------------------//
    public function getLang()
    {
        if (empty($this->language))
        {
            $this->setLang(NULL);
        }

        return $this->language;
    }

    public function setLang($locale = null)
    {
        if (empty($locale))
        {
            $locale = service('request')->getLocale();
        }

        $this->language = in_array($locale, ['tr', 'en']) ? strtoupper($locale) : "EN";
    }

    //------------------------------------------------------------------------//

    public function setError($error_code, $error_message)
    {
        $this->errors[$error_code] = $error_message;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    //------------------------------------------------------------------------//

    public function addProduct($productData)
    {
        $this->products[] = $productData;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function setUrlBack($urlBack)
    {
        $this->urlBack = $urlBack;
    }

    public function getUrlBack()
    {
        return $this->urlBack;
    }

    public function setUrl3Ds($url3Ds)
    {
        $this->url3Ds = $url3Ds;
    }

    public function getUrl3Ds()
    {
        return $this->url3Ds;
    }

    public function setBuyerData($buyerData)
    {
        $this->buyerData = $buyerData;
    }

    public function getBuyerData()
    {
        return !empty($this->buyerData) ? $this->buyerData : [];
    }

    // -------------------------------------------------------------------------
    public function setCardData($cardData)
    {
        $this->cardData = $cardData;
    }

    public function getCardData($hideCardNo = false)
    {
        if ($hideCardNo)
        {
            $carData = $this->cardData;

            if (isset($carData['cvv']))
            {
                unset($carData['cvv']);
            }
            if (isset($carData['card_number']))
            {
                $carData['card_number'] = substr($carData['card_number'], 0, 4) . ' *** **** **** ' . substr($carData['card_number'], -4);
            }

            return $carData;
        }

        return $this->cardData;
    }

    // -------------------------------------------------------------------------

    public function setBillingData($billingData)
    {
        $this->billingData = $billingData;
    }

    public function getBillingData()
    {
        return !empty($this->billingData) ? $this->billingData : [];
    }

    // -------------------------------------------------------------------------

    public function setShippingData($shippingData)
    {
        $this->shippingData = $shippingData;
    }

    public function getShippingData()
    {
        return !empty($this->shippingData) ? $this->shippingData : [];
    }

    public function setAuthData($data)
    {
        $this->authData = $data;
    }

    public function getAuthData()
    {
        return !empty($this->authData) ? $this->authData : [];
    }

    // -------------------------------------------------------------------------

    public function set3dHtmlContent($threeDSHtmlContent)
    {
        $this->threeDSHtmlContent = $threeDSHtmlContent;
    }

    public function get3dHtmlContent()
    {
        return $this->threeDSHtmlContent;
    }

    // -------------------------------------------------------------------------

    public function getConfig()
    {
        return $this->config;
    }

    public function checkout()
    {

        $this->createOrderRef();

        $MERCHANT   = $this->config->MERCHANT;
        $SECRET_KEY = $this->config->SECRET_KEY;
        $URL        = $this->config->URL;

        $arParams = array(
            "MERCHANT"        => $MERCHANT,
            "LANGUAGE"        => $this->getLang(),
            "ORDER_REF"       => $this->getOrderRef(),
            "ORDER_DATE"      => date('Y-m-d H:i:s'),
            "PAY_METHOD"      => "CCVISAMC",
            "BACK_REF"        => $this->getUrlBack() . '?order_ref=' . $this->getOrderRef(),
            "PRICES_CURRENCY" => $this->getCurrency(),
            "CLIENT_IP"       => $_SERVER["REMOTE_ADDR"]);

        foreach ($this->getProducts() as $key => $productData)
        {
            $arParams += array(
                "ORDER_PNAME[$key]"      => $productData['name'],
                "ORDER_PCODE[$key]"      => $productData['product_code'] ?? '',
                "ORDER_PINFO[$key]"      => $productData['product_info'] ?? '',
                "ORDER_PRICE[$key]"      => $productData['price'],
                "ORDER_VAT[$key]"        => $productData['vat_rate'] ?? 0,
                "ORDER_PRICE_TYPE[$key]" => 'GROSS',
                "ORDER_QTY[$key]"        => $productData['quantity'] ?? 1,
            );
        }

        $cardData = $this->getCardData();

        $arParams += array(
            "CC_NUMBER" => $cardData['card_number'],
            "EXP_MONTH" => $cardData['card_exp_month'],
            "EXP_YEAR"  => $cardData['card_exp_year'],
            "CC_CVV"    => $cardData['card_cvv'],
            "CC_OWNER"  => $cardData['card_name']);

        $billingData = $this->getBillingData();

        $arParams += array(
            "BILL_FNAME"       => $billingData['name'],
            "BILL_LNAME"       => $billingData['surname'],
            "BILL_EMAIL"       => $billingData['email'],
            "BILL_PHONE"       => $billingData['phone'],
            "BILL_ADDRESS"     => $billingData['address'],
            "BILL_ZIPCODE"     => $billingData['zipcode'],
            "BILL_CITY"        => $billingData['city_name'],
            "BILL_COUNTRYCODE" => $billingData['country_code'],
            "BILL_STATE"       => $billingData['state'] ?? 'SEYHAN',
        );

        $shippingData = $this->getShippingData();

        $arParams += array(
            "DELIVERY_FNAME"       => $shippingData['name'],
            "DELIVERY_LNAME"       => $shippingData['surname'],
            "DELIVERY_EMAIL"       => $shippingData['email'],
            "DELIVERY_PHONE"       => $shippingData['phone'],
            "DELIVERY_ADDRESS"     => $shippingData['address'],
            "DELIVERY_ZIPCODE"     => $shippingData['zipcode'],
            "DELIVERY_CITY"        => $shippingData['city_name'],
            "DELIVERY_COUNTRYCODE" => $shippingData['country_code'],
            "DELIVERY_STATE"       => $shippingData['state'] ?? 'SEYHAN',
        );

        ksort($arParams);

        $hashString = "";
        foreach ($arParams as $key => $val)
        {
            $hashString .= strlen($val) . $val;
        }

        $arParams["ORDER_HASH"] = hash_hmac("md5", $hashString, $SECRET_KEY);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arParams));

        $curlerrcode = curl_errno($ch);
        $curlerr     = curl_error($ch);

        if (!empty($curlerr) || !empty($curlerrcode))
        {
            $this->setCheckoutStatus('FAILED');
            $this->setError('CURL_ERROR', $curlerr);
        }

        $this->setResponseData((string) curl_exec($ch));

        $parsedXML = @simplexml_load_string($this->getResponseData());

        if ($parsedXML !== FALSE)
        {
            $payuTranReference = (string) $parsedXML->REFNO;

            $this->setResponseID($payuTranReference);
            $this->setResponseStatus((string) $parsedXML->STATUS);

            if ($parsedXML->STATUS == "SUCCESS")
            {
                if (($parsedXML->RETURN_CODE == "3DS_ENROLLED") && (!empty($parsedXML->URL_3DS)))
                {
                    $this->setCheckoutStatus('3DS_URL');
                    $this->setUrl3Ds((string) $parsedXML->URL_3DS);
                }
                else
                {
                    $this->setCheckoutStatus('SUCCESS');
                }
            }
            else
            {
                $RETURN_MESSAGE = (string) $parsedXML->RETURN_MESSAGE;
                $ERRORMESSAGE   = (string) $parsedXML->ERRORMESSAGE;

                $this->setCheckoutStatus('FAILED');
                $this->setError((string) $parsedXML->RETURN_CODE, (!empty($ERRORMESSAGE) ? $ERRORMESSAGE : $RETURN_MESSAGE));
            }
        }

        return $this->getCheckoutStatus();
    }

    public function check3dResponse()
    {

        $order_ref = $this->getOrderRef();

        $storedProduct = $this->getProducts();

        if (empty($storedProduct))
        {
            $this->setError('storedPaymentError', 'There is no payment data for ' . $order_ref);
            return $this->setCheckoutStatus('FAILED');
        }

        $request = service('request');

        $PAYU_REFNO       = $request->getPost('REFNO');
        $PAYU_ORDER_REF   = $request->getPost('ORDER_REF');
        $PAYU_STATUS      = $request->getPost('STATUS');
        $PAYU_RETURN_CODE = $request->getPost('RETURN_CODE');
        $ERRORMESSAGE     = $request->getPost('ERRORMESSAGE');
        $RETURN_MESSAGE   = $request->getPost('RETURN_MESSAGE');

        $this->setResponseData($request->getPost());
        $this->setResponseStatus($PAYU_STATUS);
        $this->setResponseID($PAYU_REFNO);

        if ($PAYU_ORDER_REF !== $order_ref)
        {
            $this->setError('sessionNotMatched', 'Payu Post Does not match with Session ORDER_REF');
            return $this->setCheckoutStatus('FAILED');
        }

        if ($PAYU_STATUS !== 'SUCCESS' || $PAYU_RETURN_CODE !== 'AUTHORIZED')
        {
            $this->setError((string) $PAYU_RETURN_CODE, (!empty($ERRORMESSAGE) ? $ERRORMESSAGE : $RETURN_MESSAGE));
            return $this->setCheckoutStatus('FAILED');
        }

        return $this->setCheckoutStatus('SUCCESS');
    }

    // -------------------------------------------------------------------------
}
