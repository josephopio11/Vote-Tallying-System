<?php
/**
 * Agents Home Controller
 * Dashboard of the panel
 */

namespace Agents\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Libraries\PaymentSystem\PaymentSystem;
use App\Libraries\InvoiceSystem\InvoiceSystem;


class Subscription extends BaseController
{

    use ResponseTrait;

    //--------------------------------------------------------------------
    
    public function __construct()
    {
        helper(['Agents\email', 'Agents\sms',
            'Agents\c4_country', 'Agents\c4_zone']);
    }
    
    //--------------------------------------------------------------------

    public function index()
    {
        //Cache
        $this->response->setCache(['max-age' => 300, 's-maxage' => 900, 'etag' => '1499127']);

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
            echo agents_view('subscription/' . $page, $data);
        }
        else
        {
            echo agents_view('themes/' . $this->theme . '/header', $data);
            echo agents_view('subscription/' . $page, $data);
            echo agents_view('themes/' . $this->theme . '/footer', $data);
        }
    }

}