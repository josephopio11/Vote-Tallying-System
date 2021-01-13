<?php
namespace App\Libraries\PaymentSystem;

use App\Libraries\PaymentSystem\Handlers\PaymentInterface;
use App\Libraries\PaymentSystem\PaymentConfig;

class PaymentSystem implements PaymentInterface
{
    // -------------------------------------------------------------------------

    /**
     * Paymnet Method Handle
     * @var Class 
     */
    protected $handle;
    // -------------------------------------------------------------------------

    protected $config;
    protected $paymentModel;
    protected $paymentHistoryModel;
    protected $paymentAttemptModel;
    protected $successPageUrl;

    /**
     * PaymentMethod Name inside handler
     * @param String $methodName
     */
    function __construct($methodName = null)
    {
        $this->config = new PaymentConfig();

        if (empty($methodName))
        {
            $methodName = $this->config->defaultMethod;
        }

        /**
         * handle will be activated in setPaymentMethod
         */
        $this->setPaymentMethod($methodName);
        $this->setCurrency($this->config->defaultCurrency);
    }

    //------------------------------------------------------------------------//

    public function setPaymentID($payment_id)
    {
        $this->handle->setPaymentID($payment_id);
    }

    public function getPaymentID()
    {
        return $this->handle->getPaymentID();
    }

    public function setInvoiceID($invoice_id)
    {
        return $this->handle->setInvoiceID($invoice_id);
    }

    public function getInvoiceID()
    {
        return $this->handle->getInvoiceID();
    }

    public function setOrderRef($order_ref)
    {
        $this->handle->setOrderRef($order_ref);
    }

    public function getOrderRef()
    {
        return $this->handle->getOrderRef();
    }

    public function setDate($date)
    {
        $this->handle->setDate($date);
    }

    public function getDate()
    {
        return $this->handle->getDate();
    }

    public function setAmount($amount)
    {
        $this->handle->setAmount($amount);
    }

    public function getAmount()
    {
        return $this->handle->getAmount();
    }

    public function setCurrency($currency)
    {
        $this->handle->setCurrency($currency);
    }

    public function getCurrency()
    {
        return $this->handle->getCurrency();
    }

    public function setPaymentMethod($payment_method)
    {
        if (!isset($this->config->handlers[$payment_method]))
        {
            die('Method Not in Handlers');
            return;
        }

        $this->handle = new $this->config->handlers[$payment_method];
        $this->handle->setPaymentMethod($payment_method);
    }

    public function getPaymentMethod()
    {
        return $this->handle->getPaymentMethod();
    }

    public function setJsonData($data)
    {
        $this->handle->setJsonData($data);
    }

    public function getJsonData(): array
    {
        return $this->handle->getJsonData();
    }

    public function setCheckoutStatus($checkout_status)
    {
        $this->handle->setCheckoutStatus($checkout_status);
    }

    public function getCheckoutStatus()
    {
        return $this->handle->getCheckoutStatus();
    }

    public function setResponseStatus($responseStatus)
    {
        $this->handle->setResponseStatus($responseStatus);
    }

    public function getResponseStatus()
    {
        return $this->handle->getResponseStatus();
    }

    public function setResponseID($response_id)
    {
        $this->handle->setResponseID($response_id);
    }

    public function getResponseID()
    {
        return $this->handle->getResponseID();
    }

    public function setResponseData($response)
    {
        $this->handle->setResponseData($response);
    }

    public function getResponseData()
    {
        return $this->handle->getResponseData();
    }

    public function setPaymentData($data)
    {
        $this->handle->setPaymentData($data);
    }

    public function getPaymentData()
    {
        return $this->handle->getPaymentData();
    }

    //------------------------------------------------------------------------//

    public function setLang($lang)
    {
        $this->handle->setResponseID($lang);
    }

    public function getLang()
    {
        return $this->handle->getLang();
    }

    //------------------------------------------------------------------------//

    public function getError(string $field = null): string
    {
        $errors = $this->getErrors();

        if ($field === null && count($errors) === 1)
        {
            reset($errors);
            $field = key($errors);
        }

        return array_key_exists($field, $errors) ? $errors[$field] : '';
    }

    public function getErrors($json = false)
    {
        if ($json)
        {
            return json_encode($this->handle->getErrors(), JSON_PRETTY_PRINT);
        }
        return $this->handle->getErrors();
    }

    public function setError($error_code, $error_message = null)
    {
        if (is_array($error_code))
        {

            foreach ($error_code as $key => $value)
            {
                $this->handle->setError($key, $value);
            }
            return;
        }

        return $this->handle->setError($error_code, $error_message);
    }

    //------------------------------------------------------------------------//

    public function getConfig()
    {
        return $this->handle->getConfig();
    }

    //------------------------------------------------------------------------//
    public function addProduct($productData)
    {

//        $productData['excise_duty_type']  = $productData['excise_duty_type'] ?? $productData['sales_excise_duty_type'] ?? 'percentage';
//        $productData['excise_duty_value'] = $productData['excise_duty_value'] ?? $productData['sales_excise_duty_value'] ?? 0;
//
//        $productData['communications_tax_type']  = $productData['communications_tax_type'] ?? $productData['sales_communications_tax_type'] ?? 'percentage';
//        $productData['communications_tax_value'] = $productData['communications_tax_value'] ?? $productData['sales_communications_tax_value'] ?? 0;

        $productData['vat_rate']     = $productData['vat_rate'] ?? 0;
        $productData['name']         = $productData['name'] ?? $productData['product_name'] ?? 'noProductName';
        $productData['product_code'] = $productData['product_code'] ?? substr(md5($productData['name']), 0, 10);

        if (!isset($productData['price']) && isset($productData['unit_price']))
        {
            $productData['price'] = $productData['unit_price'] * (($productData['vat_rate'] + 100) / 100);
        }

        $productData['category'] = $productData['category'] ?? 'nocategory';
        $productData['price']    = $productData['price'] ?? 0.0;

        $this->handle->addProduct($productData);
    }

    public function addProducts($products)
    {
        if (empty($products))
        {
            return false;
        }

        foreach ($products as $productData)
        {
            if (empty($productData))
            {
                continue;
            }

            $this->addProduct($productData);
        }
    }

    public function getProducts()
    {
        return $this->handle->getProducts();
    }

    //------------------------------------------------------------------------//

    public function setUrlBack($backUrl)
    {
        $this->handle->setUrlBack($backUrl);
    }

    public function getUrlBack()
    {
        return $this->handle->getUrlBack();
    }

    public function setUrl3Ds($url3Ds)
    {
        $this->handle->setUrl3Ds($url3Ds);
    }

    public function getUrl3Ds()
    {
        return $this->handle->getUrl3Ds();
    }

    public function setSuccessPageUrl($url3Ds)
    {
        $this->successPageUrl = $url3Ds;
    }

    public function getSuccessPageUrl()
    {
        return $this->successPageUrl;
    }

    //------------------------------------------------------------------------//

    public function setCardData($cardData, $validation = true)
    {
        if ($validation)
        {
            $validation = \Config\Services::validation();

            $validation->setRules([
                'card_number'    => ['label' => lang('home.card_number'), 'rules' => "required|alpha_numeric_space|min_length[12]|max_length[19]"],
                'card_name'      => ['label' => lang('home.card_name'), 'rules' => "required|string|max_length[50]"],
                'card_exp_month' => ['label' => lang('home.card_exp_month'), 'rules' => "required|valid_date[m]"],
                'card_exp_year'  => ['label' => lang('home.card_exp_year'), 'rules' => "required|valid_date[Y]"],
                'card_cvv'       => ['label' => lang('home.card_cvv'), 'rules' => "required|numeric|less_than_equal_to[9999]"],
            ]);

            if ($validation->run($cardData) === false)
            {
                $this->setError($validation->getErrors());
                return false;
            }
        }

        $this->handle->setCardData($cardData);
    }

    public function getCardData()
    {
        return $this->handle->getCardData();
    }

    //------------------------------------------------------------------------//

    public function setBuyerData($buyerData)
    {
        $this->handle->setBuyerData($buyerData);
    }

    public function getBuyerData()
    {
        return $this->handle->getBuyerData();
    }

    //------------------------------------------------------------------------//

    public function setBillingData($data)
    {
        $this->handle->setBillingData($data);
    }

    public function getBillingData()
    {
        return $this->handle->getBillingData();
    }

    //------------------------------------------------------------------------//

    public function setShippingData($data)
    {
        $this->handle->setShippingData($data);
    }

    public function getShippingData()
    {
        return $this->handle->getShippingData();
    }

    //------------------------------------------------------------------------//

    public function setAuthData($authServiceData)
    {
        $this->handle->setAuthData($authServiceData);
    }

    public function getAuthData()
    {
        $data = $this->handle->getAuthData();

        if (empty($data))
        {
            $defaultNamespace = service('routes')->getDefaultNamespace();
            $authServicePath  = "\\" . $defaultNamespace . "Config\Services::auth";
            $authService      = $authServicePath();
            $data             = $authService->getAllData();
        }

        return $data;
    }

    //------------------------------------------------------------------------//

    public function get3dHtmlContent()
    {
        return $this->handle->get3dHtmlContent();
    }

    //------------------------------------------------------------------------//

    private function _getAllJsonData()
    {
        return json_encode(
                [
                    'paymentData'    => $this->getPaymentData(),
                    'products'       => $this->getProducts(),
                    'error_message'  => $this->getErrors(),
                    'buyerData'      => $this->getBuyerData(),
                    'billingData'    => $this->getBillingData(),
                    'cardData'       => $this->getCardData(TRUE),
                    'shippingData'   => $this->getShippingData(),
                    'authData'       => $this->getAuthData(),
                    'successPageUrl' => $this->getSuccessPageUrl(),
                ]
        );
    }

    public function savePaymentAttempt()
    {

        $data['json_data']       = $this->_getAllJsonData();
        $data['order_ref']       = $this->getOrderRef();
        $data['checkout_status'] = $this->getCheckoutStatus();
        $data['error_message']   = $this->getErrors(true);
        $data['response_id']     = $this->getResponseID();
        $data['response_status'] = $this->getResponseStatus();
        $data['response_data']   = $this->getResponseData();

        $paymentAttemptModel = $this->getPaymentAttemptModel();
        $paymentAttemptModel->save($data);
    }

    public function getPaymentAttempt($where)
    {

        $paymentAttemptModel = $this->getPaymentAttemptModel();

        return $paymentAttemptModel->where($where)->first();
    }

    //------------------------------------------------------------------------//

    public function getPaymentModel()
    {
        if (!empty($this->paymentModel))
        {
            return $this->paymentModel;
        }

        $defaultNamespace   = service('routes')->getDefaultNamespace();
        $modelPath          = "\\" . $defaultNamespace . "Models\C4_paymentModel";
        return $this->paymentModel = new $modelPath();
    }

    public function getPaymentHistoryModel()
    {

        if (!empty($this->paymentHistoryModel))
        {
            return $this->paymentHistoryModel;
        }

        $defaultNamespace          = service('routes')->getDefaultNamespace();
        $modelPath                 = "\\" . $defaultNamespace . "Models\C4_payment_historyModel";
        return $this->paymentHistoryModel = new $modelPath();
    }

    public function getPaymentAttemptModel()
    {
        if (!empty($this->paymentAttemptModel))
        {
            return $this->paymentAttemptModel;
        }

        $defaultNamespace          = service('routes')->getDefaultNamespace();
        $modelPath                 = "\\" . $defaultNamespace . "Models\C4_payment_attemptModel";
        return $this->paymentAttemptModel = new $modelPath();
    }

    //------------------------------------------------------------------------//

    public function invoicePayment($invoice_id)
    {

        $invoice = new \App\Libraries\InvoiceSystem\InvoiceSystem();
        $invoice->read($invoice_id);

        if (empty($invoice->getInvoiceData()))
        {
            $this->setError($invoice->getErrors());
            $this->setCheckoutStatus('FAIL');
            return false;
        }

        if ($invoice->getRemaining() <= 0)
        {
            $this->setError('remainingError', 'Remaining Amount can not be zero');
            $this->setCheckoutStatus('FAIL');
            return false;
        }

        $this->setInvoiceID($invoice_id);
        $this->setCurrency($invoice->getCurrency());
        $this->addProducts($invoice->getItems());
        //For Partial Paid
        $this->setAmount($invoice->getRemaining());

        if (!empty($invoice->getBillingData()))
        {
            $this->setBillingData($invoice->getBillingData());
        }
        else
        {
            $this->setBillingData($this->getAuthData());
        }

        if (!empty($invoice->getShippingData()))
        {
            $this->setShippingData($invoice->getShippingData());
        }
        else
        {
            $this->setBillingData($this->getBillingData());
        }
    }

    //------------------------------------------------------------------------//

    public function read($where = [])
    {

        $paymentModel = $this->getPaymentModel();

        if (empty($where) && !empty($this->getPaymentID()))
        {
            $where['c4_payment_id'] = $this->getPaymentID();
        }

        if (empty($where) && !empty($this->getOrderRef()))
        {
            $where['order_ref'] = $this->getOrderRef();
        }

        return $paymentModel->where($where)->first();
    }

    protected function create()
    {
        if ($this->getCheckoutStatus() !== 'SUCCESS')
        {
            return;
        }

        $paymentModel = $this->getPaymentModel();
        $paymentData  = $this->getPaymentData();

        $paymentData['checkout_status'] = $this->getCheckoutStatus(); //SUCCESS
        $paymentData['response_status'] = $this->getResponseStatus();
        $paymentData['response_id']     = $this->getResponseID();
        $paymentData['response_data']   = $this->getResponseData();
        $paymentData['json_data']       = $this->_getAllJsonData();

        $paymentModel->save($paymentData);

        $this->setPaymentID($paymentModel->getInsertID());

        // Update Payment Attemp -----------------------------------------------
        $attempModel = $this->getPaymentAttemptModel();
        $attempModel->update(['order_ref' => $this->getOrderRef()], [
            'checkout_status' => $this->getCheckoutStatus(),
            'error_message'   => $this->getErrors(TRUE),
            'response_status' => $this->getResponseStatus(),
            'response_data'   => $this->getResponseStatus(),
                ]
        );

        // Create Invoice ------------------------------------------------------
        $invoiceID = $this->getInvoiceID();

        if (empty($invoiceID))
        {
            $invoiceName = $this->getProducts()[0]['name'];

            $invoice = new \App\Libraries\InvoiceSystem\InvoiceSystem();
            $invoice->setDesc($invoiceName);
            $invoice->setInvoiceStatus('PAID');
            $invoice->setCurrency($this->getCurrency());
            $invoice->addItems($this->getProducts());
            $invoice->setBillingData($this->getBillingData());
            $invoice->setShippingData($this->getShippingData());
            $invoice->setPayments(array($paymentData));
            $invoice->create();

            $invoice_id = $invoice->getInvoiceID();

            $this->setInvoiceID($invoice_id);

            // Update Payment with invoice_id
            $this->update(['c4_invoice_id' => $invoice_id]);
        }
        else
        {
            /**
             * For Partail Payments.. 
             */
            
            $invoice = new \App\Libraries\InvoiceSystem\InvoiceSystem();
            $invoice->read($invoiceID); //read and calculate payments
            //invoice system update with new invoicestatus..
            $invoice->update($invoice->getInvoiceData());
        }
    }

    public function update($updateData, $where = [])
    {
        $paymentModel = $this->getPaymentModel();

        if (empty($where) && !empty($this->getPaymentID()))
        {
            $where['c4_payment_id'] = $this->getPaymentID();
        }
        elseif (empty($where) && !empty($this->getOrderRef()))
        {
            $where['order_ref'] = $this->getOrderRef();
        }
        elseif (empty($where))
        {
            return false;
        }

        $paymentModel->update($where, $updateData);
    }

    //------------------------------------------------------------------------//

    public function checkout()
    {
        date_default_timezone_set('UTC');

        if (!empty($this->getErrors()))
        {
            $this->setCheckoutStatus('FAIL');
            return $this->getCheckoutStatus();
        }

        if (empty($this->getBuyerData()))
        {
            if (!empty($this->getBillingData()))
            {
                $this->setBuyerData($this->getBillingData());
            }
            elseif (!empty($this->getShippingData()))
            {
                $this->setBuyerData($this->getShippingData());
            }
            elseif (!empty($this->getAuthData()))
            {
                $this->setBuyerData($this->getAuthData());
            }
        }

        if (empty($this->getBillingData()))
        {
            if (!empty($this->getBuyerData()))
            {
                $this->setBillingData($this->getBuyerData());
            }
            elseif (!empty($this->getShippingData()))
            {
                $this->setBillingData($this->getShippingData());
            }
            elseif (!empty($this->getAuthData()))
            {
                $this->setBillingData($this->getAuthData());
            }
        }

        if (empty($this->getShippingData()))
        {
            if (!empty($this->getBuyerData()))
            {
                $this->setShippingData($this->getBuyerData());
            }
            if (!empty($this->getBillingData()))
            {
                $this->setShippingData($this->getBillingData());
            }
            elseif (!empty($this->getAuthData()))
            {
                $this->setShippingData($this->getAuthData());
            }
        }

        $this->setDate(null);
        $this->getAmount();

        $this->handle->checkout();

        $this->savePaymentAttempt();

        // SAVE PAYMENT IF SUCCESS ---------------------------------------------
        if ($this->getCheckoutStatus() === 'SUCCESS')
        {
            $this->create();
        }
        // ---------------------------------------------------------------------

        return $this->getCheckoutStatus();
    }

    public function check3dResponse()
    {
        $order_ref = $this->getOrderRef();

        $paymentAttemptData = $this->getPaymentAttempt(['order_ref' => $order_ref]);

        if (empty($paymentAttemptData))
        {
            $this->setError('NOPAYMENTDATA', 'There is no payment data for ' . $order_ref);
            return false;
        }

        $paymentData = $this->read(['order_ref' => $order_ref]);

        if (!empty($paymentData))
        {
            $this->setError('NOPROCESSED', 'This payment has been already saved');
            return false;
        }

        // Check oldest checkout_status
        $checkout_status = $paymentAttemptData['checkout_status'];

        if (!in_array($checkout_status, ['3DS_URL', '3DS_HTMLCONTENT']))
        {
            $this->setError('NOPROCESSED', 'This payment is not available');
            return false;
        }

        $jsonData = json_decode($paymentAttemptData['json_data'], TRUE);

        $this->setPaymentData($jsonData['paymentData']);
        $this->setBillingData($jsonData['billingData']);
        $this->setBuyerData($jsonData['buyerData']);
        $this->setShippingData($jsonData['shippingData']);
        $this->setAuthData($jsonData['authData']);
        $this->addProducts($jsonData['products']);
        $this->setCardData($jsonData['cardData'], false);
        $this->setSuccessPageUrl($jsonData['successPageUrl']);

        $this->handle->check3dResponse();

        // SAVE PAYMENT IF SUCCESS ---------------------------------------------
        if ($this->getCheckoutStatus() === 'SUCCESS')
        {
            $this->create();
        }
        else
        {
            $attempModel = $this->getPaymentAttemptModel();
            $attempModel->update($paymentAttemptData['payment_attempt_id'], [
                'checkout_status' => $this->getCheckoutStatus(),
                'error_message'   => $this->getErrors(true),
                'response_status' => $this->getResponseStatus(),
                'response_data'   => $this->getResponseStatus(),
                    ]
            );
        }
        // ---------------------------------------------------------------------

        return $this->getCheckoutStatus();
    }

}
