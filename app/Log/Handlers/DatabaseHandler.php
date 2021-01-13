<?php

namespace App\Log\Handlers;

use CodeIgniter\Log\Handlers\BaseHandler;
use CodeIgniter\Log\Handlers\HandlerInterface;

class DatabaseHandler extends BaseHandler implements HandlerInterface
{

    protected $expiredPeriod;

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->expiredPeriod = $config['expiredPeriod'] ?? 30 * DAY;
    }

    //--------------------------------------------------------------------


    public function handle($level, $message): bool
    {

        $logModel = new \App\Log\LogModel();
        $request  = \Config\Services::request();

        session();

        $data['level']     = $level;
        $data['message']   = $message;
        $data['ip']        = (string) $request->getIPAddress();
        $data['userAgent'] = (string) $request->getUserAgent();
        $data['uri']       = (string) $request->uri;
        $data['session']   = json_encode($_SESSION, JSON_PRETTY_PRINT);
        
        $allGet = $request->getGet(null, FILTER_SANITIZE_STRING);
        $allPost = $request->getPost(null, FILTER_SANITIZE_STRING);
        
        $data['get']       = !empty($allGet) ? json_encode(esc($allGet), JSON_PRETTY_PRINT) : '';
        $data['post']      = !empty($allPost) ? json_encode(esc($allPost), JSON_PRETTY_PRINT) : '';

        $logModel->save($data);
        $logModel->deleteExperidData($this->expiredPeriod);

        return true;
    }

    //--------------------------------------------------------------------
}
