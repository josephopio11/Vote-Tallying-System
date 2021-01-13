<?php
//------------------------------------------------------------------------------
/**
 * Routes of Voters
 * 
 * Avaible MultiLanguage url structure
 * 
 * Url Structure 
 * {site_url}/{namespace}/{lang}/{controller}/{method}/{param}
 */
//------------------------------------------------------------------------------

$request  = \Config\Services::request();
$segments = $request->uri->getSegments();

if (($segments[0] ?? '') === 'voters')
{
    $locale = $segments[1] ?? NULL;

    if (empty($locale) || !in_array($locale, $request->config->supportedLocales))
    {
        //If locale is no in supportedList
        header('Location: ' . site_url('voters') . '/' . $request->getLocale());
        die();
    }

    //Set Locale
    $request->setLocale($locale);
    $routes->setDefaultNamespace('Voters');

    //General without Authication Filter
    $routes->get("voters/$locale/general", "General::index", ['namespace' => 'Voters\Controllers']);
    $routes->add("voters/$locale/general/(:segment)", "General::$1", ['namespace' => 'Voters\Controllers']);
    $routes->add("voters/$locale/general/(:segment)/(:any)", "General::$1/$2", ['namespace' => 'Voters\Controllers']);

    //Authication Links
    $routes->get("voters/$locale/auth", "Authentication::index", ['namespace' => 'Voters\Controllers']);
    $routes->add("voters/$locale/auth/(:segment)", "Authentication::$1", ['namespace' => 'Voters\Controllers']);
    $routes->add("voters/$locale/auth/(:segment)/(:any)", "Authentication::$1/$2", ['namespace' => 'Voters\Controllers']);
        
    //Add Authication Filter
    $option['filter'] = 'votersAuthFilter';
    $option['namespace'] ='Voters\Controllers';

    $routes->get("voters", "Home::index", $option);
    $routes->get("voters/$locale", "Home::index", $option);

    if (isset($segments[2]))
    {
        //if there is controller name
        $moduleName  = $segments[2];
        $controllerName = ucfirst($segments[2]);
        
        $routes->get("voters/$locale/$moduleName", "$controllerName::index", $option);
        $routes->add("voters/$locale/$moduleName/(:segment)", "$controllerName::$1", $option);
        $routes->add("voters/$locale/$moduleName/(:segment)/(:any)", "$controllerName::$1/$2", $option);
    }
}
