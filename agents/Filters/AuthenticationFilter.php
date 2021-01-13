<?php
namespace Agents\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthenticationFilter implements FilterInterface 
{
    public function before(RequestInterface $request) 
    {
        $authService = \Agents\Config\Services::auth();

        if ($authService->isLoggedIn() === false) 
        {
            helper('Agents\agents');

            $loginUrl = agents_url('auth/login');

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

    }

    public function after(RequestInterface $request, ResponseInterface $response) 
    {
        // Do something here
    }

}
