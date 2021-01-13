<?php
/**
 * Tally Home Controller
 * Dashboard of the panel
 */

namespace Tally\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Libraries\PaymentSystem\PaymentSystem;
use App\Libraries\InvoiceSystem\InvoiceSystem;


class Subscription extends BaseController
{

    use ResponseTrait;

    //--------------------------------------------------------------------
    
    public function __construct()
    {
        helper(['Tally\email', 'Tally\sms',
            'Tally\c4_country', 'Tally\c4_zone']);
    }
    
    //--------------------------------------------------------------------

    public function index()
    {
        //Cache
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '93a9e83']);

        $paymentSystem = new PaymentSystem('PAYUTR');
 
        $this->response->CSP->addFormAction([$paymentSystem->getConfig()->URL]);
        $this->response->CSP->addScriptSrc('unsafe-inline');

        $data['page_title'] = lang('subscribe.page_title');

        $this->_render('subscribe', $data);
    }

    //---------------------------------------------------------------------

    /**
     * Render File 
     * if request comes not as ajax, _render show header and footer files in themes/{theme}
     *
     * @param tring $page
     * @param array $data
     */
    private function _render($page, $data = [])
    {
        helper('form');

        if ($this->request->isAJAX())
        {
            echo tally_view('subscription/' . $page, $data);
        }
        else
        {
            echo tally_view('themes/' . $this->theme . '/header', $data);
            echo tally_view('subscription/' . $page, $data);
            echo tally_view('themes/' . $this->theme . '/footer', $data);
        }
    }

}