<?php
namespace App\Libraries\PaymentSystem\Handlers\IYZICO;

use App\Libraries\PaymentSystem\Handlers\PaymentInterface;
use App\Libraries\PaymentSystem\Handlers\IYZICO\IyzicoConfig;

class Iyzico implements PaymentInterface
{

    protected $paymentData;
    protected $config;
    protected $products;
    protected $errors;
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
        $this->config = new IyzicoConfig();

        $service = service('autoloader');
        $service->addNamespace('Iyzipay', APPPATH . 'ThirdParty/Iyzipay');
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

    // -------------------------------------------------------------------------

    public function checkout()
    {

        $this->createOrderRef();
 
        $options = new \Iyzipay\Options();
        $options->setApiKey($this->config->API_KEY);
        $options->setSecretKey($this->config->SECRET_KEY);
        $options->setBaseUrl($this->config->URL);

        $request = new \Iyzipay\Request\CreatePaymentRequest();

        $request->setLocale(strtolower($this->getLang()));
        $request->setConversationId($this->getOrderRef());
        $request->setPrice($this->getAmount());
        $request->setPaidPrice($this->getAmount());
        $request->setCurrency($this->getCurrency());
        $request->setInstallment(1);
//        $request->setBasketId($ORDER_REF);
//        $request->setPaymentChannel(\Iyzipay\Model\PaymentChannel::WEB);
//        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::SUBSCRIPTION);

        if ($this->config->use3d)
        {
            $request->setCallbackUrl($this->getUrlBack() . '?order_ref=' . $this->getOrderRef());
        }

        $cardData = $this->getCardData();
        
        $paymentCard = new \Iyzipay\Model\PaymentCard();
        $paymentCard->setCardHolderName($cardData['card_name']);
        $paymentCard->setCardNumber($cardData['card_number']);
        $paymentCard->setExpireMonth($cardData['card_exp_month']);
        $paymentCard->setExpireYear($cardData['card_exp_year']);
        $paymentCard->setCvc($cardData['card_cvv']);
        $paymentCard->setRegisterCard(0);
        $request->setPaymentCard($paymentCard);

        $buyerData = $this->getBuyerData();

        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId($buyerData['id']);
        $buyer->setName($buyerData['name']);
        $buyer->setSurname($buyerData['surname']);
        $buyer->setGsmNumber($buyerData['phone']);
        $buyer->setEmail($buyerData['email']);
        $buyer->setIdentityNumber($buyerData['identityNumber']);
//        $buyer->setLastLoginDate("2015-10-05 12:43:35");
//        $buyer->setRegistrationDate("2013-04-21 15:12:09");
        $buyer->setRegistrationAddress($buyerData['address']);
        $buyer->setIp(service('request')->getIPAddress());
        $buyer->setCity($buyerData['city_name']);
        $buyer->setCountry($buyerData['country_name']);
        $buyer->setZipCode($buyerData['zipcode']);
        $request->setBuyer($buyer);

        $shippingData = $this->getShippingData();

        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName($shippingData['fullName']);
        $shippingAddress->setCity($shippingData['city_name']);
        $shippingAddress->setCountry($shippingData['country_name']);
        $shippingAddress->setAddress($shippingData['address']);
        $shippingAddress->setZipCode($shippingData['zipcode']);
        $request->setShippingAddress($shippingAddress);

        $billingData = $this->getBillingData();

        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName($billingData['fullName']);
        $billingAddress->setCity($billingData['city_name']);
        $billingAddress->setCountry($billingData['country_name']);
        $billingAddress->setAddress($billingData['address']);
        $billingAddress->setZipCode($billingData['zipcode']);
        $request->setBillingAddress($billingAddress);

        foreach ($this->getProducts() as $key => $productData)
        {
            $basketItems       = array();
            $basketItem        = new \Iyzipay\Model\BasketItem();
            $basketItem->setId($productData['product_code']);
            $basketItem->setName($productData['name']);
            $basketItem->setCategory1($productData['category']);
            $basketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
            $basketItem->setPrice($productData['price']);
            $basketItems[$key] = $basketItem;
        }

        $request->setBasketItems($basketItems);

        # make request
//        $this->payResponse = \Iyzipay\Model\Payment::create($request, $options);

        if ($this->config->use3d)
        {
            $response = \Iyzipay\Model\ThreedsInitialize::create($request, $options);
        }
        else
        {
            $response = \Iyzipay\Model\Payment::create($request, $options);
        }

        $this->setResponseStatus($response->getStatus());
        $this->setResponseData($response->getRawResult());

        if ($response->getStatus() === 'failure')
        {
            $this->setCheckoutStatus('FAILED');
            $this->setError($response->getErrorCode(), $response->getErrorMessage());
        }
        elseif ($response->getStatus() === 'success')
        {
            if ($this->config->use3d && !empty($response->getHtmlContent()))
            {
                //Work on use3d = true
                $this->setCheckoutStatus('3DS_HTMLCONTENT');
                $this->set3dHtmlContent($response->getHtmlContent());
            }
            else
            {
                //Work only use3d = false
                $this->setResponseID($response->getPaymentId());
                $this->setCheckoutStatus('SUCCESS');
            }
        }

        return $this->getCheckoutStatus();
    }

    public function check3dResponse()
    {
        $order_ref = $this->getOrderRef();

        $statusList['0'] = '3-D Secure imzası geçersiz veya doğrulama';
        $statusList['1'] = 'SUCCESS';
        $statusList['2'] = 'Kart sahibi veya bankası sisteme kayıtlı değil';
        $statusList['3'] = 'Kartın bankası sisteme kayıtlı değil';
        $statusList['4'] = 'Doğrulama denemesi, kart sahibi sisteme daha sonra kayıt olmayı seçmiş';
        $statusList['5'] = 'Doğrulama yapılamıyor';
        $statusList['6'] = '3-D Secure hatası';
        $statusList['7'] = 'Sistem hatası';
        $statusList['8'] = 'Bilinmeyen kart no';

        $storedProduct = $this->getProducts();

        if (empty($storedProduct))
        {
            $this->setError('storedPaymentError', 'There is no payment data for ' . $order_ref);
            return $this->setCheckoutStatus('FAILED');
        }

        $request = service('request');

        $status           = $request->getPost('status');
        $paymentId        = $request->getPost('paymentId');
        $conversationData = $request->getPost('conversationData');
        $conversationId   = $request->getPost('conversationId');
        $mdStatus         = $request->getPost('mdStatus');

        $this->setResponseStatus($status);
        $this->setResponseData($request->getPost());
        $this->setResponseID($paymentId);

        if ($status !== 'success')
        {
            $this->setError('returnCodeError', $statusList[$mdStatus] ?? 'STATUS or RETURN_CODE Error');
            return $this->setCheckoutStatus('FAILED');
        }

        if ($conversationId !== $order_ref)
        {
            $this->setError('sessionNotMatched', 'ReturnCode not Matched with $order_ref');
            return $this->setCheckoutStatus('FAILED');
        }

        return $this->setCheckoutStatus('SUCCESS');
    }

    // -------------------------------------------------------------------------
}
