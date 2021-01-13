<?php
//------------------------------------------------------------------------------
/**
 * Routes of Admin
 * 
 * Avaible MultiLanguage url structure
 * 
 * Url Structure 
 * {site_url}/{namespace}/{lang}/{controller}/{method}/{param}
 */
//------------------------------------------------------------------------------

$request  = \Config\Services::request();
$segments = $request->uri->getSegments();

if (($segments[0] ?? '') === 'admin')
{
    $locale = $segments[1] ?? NULL;

    if (empty($locale) || !in_array($locale, $request->config->supportedLocales))
    {
        //If locale is no in supportedList
        header('Location: ' . site_url('admin') . '/' . $request->getLocale());
        die();
    }

    //Set Locale
    $request->setLocale($locale);
    $routes->setDefaultNamespace('Admin');

    //General without Authication Filter
    $routes->get("admin/$locale/general", "General::index", ['namespace' => 'Admin\Controllers']);
    $routes->add("admin/$locale/general/(:segment)", "General::$1", ['namespace' => 'Admin\Controllers']);
    $routes->add("admin/$locale/general/(:segment)/(:any)", "General::$1/$2", ['namespace' => 'Admin\Controllers']);

    //Authication Links
    $routes->get("admin/$locale/auth", "Authentication::index", ['namespace' => 'Admin\Controllers']);
    $routes->add("admin/$locale/auth/(:segment)", "Authentication::$1", ['namespace' => 'Admin\Controllers']);
    $routes->add("admin/$locale/auth/(:segment)/(:any)", "Authentication::$1/$2", ['namespace' => 'Admin\Controllers']);
        
    //Add Authication Filter
    $option['filter'] = 'adminAuthFilter';
    $option['namespace'] ='Admin\Controllers';

    $routes->get("admin", "Home::index", $option);
    $routes->get("admin/$locale", "Home::index", $option);

    if (isset($segments[2]))
    {
        //if there is controller name
        $moduleName  = $segments[2];
        $controllerName = ucfirst($segments[2]);
        
        $routes->get("admin/$locale/$moduleName", "$controllerName::index", $option);
        $routes->add("admin/$locale/$moduleName/(:segment)", "$controllerName::$1", $option);
        $routes->add("admin/$locale/$moduleName/(:segment)/(:any)", "$controllerName::$1/$2", $option);
    }
}
