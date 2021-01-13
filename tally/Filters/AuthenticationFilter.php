<?php
namespace Tally\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthenticationFilter implements FilterInterface 
{
    public function before(RequestInterface $request) 
    {
        $authService = \Tally\Config\Services::auth();

        if ($authService->isLoggedIn() === false) 
        {
            helper('Tally\tally');

            $loginUrl = tally_url('auth/login');

            if (strpos(uri_string(), 'read') === false) 
            {
                $loginUrl = $loginUrl . '?goBack=' . uri_string();
            }

            if ($request->isAJAX()) 
            {
                $response = \Config\Services::response();
                $response->setStatusCode(401); // Unauthorized
                return $response->setJSON(['status' => 401,
                            'messages' => [lang('auth.errorAuthPleaseLogin')],
                            'redirectURL' => $loginUrl
                ]);
            }

            return redirect()->to($loginUrl);
        }

        $subscriptionService = \Tally\Config\Services::subscription();

        if ($subscriptionService->hasPermission() === false)
        {
            $segments = $request->uri->getSegments();

            // home/subscribe
            if (($segments[2] ?? null) != 'subscription')
            {
                helper('Tally\tally');
             
                $subscribePage = $subscriptionService->getPage();
                
                if ($request->isAJAX()) 
                {
                    $response = \Config\Services::response();
                    $response->setStatusCode(401); // Unauthorized
                    return $response->setJSON(['status' => 401,
                                'messages' => [$subscriptionService->getErrorString()],
                                'redirectURL' => $subscribePage
                    ]);
                }

                return redirect()->to($subscribePage);

            }
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response) 
    {
        // Do something here
    }

}
