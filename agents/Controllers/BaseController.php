<?php

namespace Agents\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller
{
    protected $theme = 'veboTheme';

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        //$this->session = \Config\Services::session();
    
        helper(['Agents\agents']);

        $parse        = parse_url(resources_url());
        $resourcesUrl = $parse['host'];

        $response->CSP->addChildSrc([site_url(), 'https://www.google.com']);
        $response->CSP->addStyleSrc([site_url(), $resourcesUrl, 'https://use.fontawesome.com']);
        $response->CSP->addScriptSrc([site_url(), $resourcesUrl, 'https://www.google.com', 'https://www.gstatic.com', 'https://www.googletagmanager.com', 'https://www.google-analytics.com']);
        $response->CSP->addImageSrc([site_url(), $resourcesUrl, 'https://www.google-analytics.com']);
        $response->CSP->addConnectSrc([site_url(), $resourcesUrl]);
        $response->CSP->addFontSrc([site_url(), $resourcesUrl, 'https://use.fontawesome.com']);

    }
}
