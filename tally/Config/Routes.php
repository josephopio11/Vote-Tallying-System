<?php
//------------------------------------------------------------------------------
/**
 * Routes of Tally
 * 
 * Avaible MultiLanguage url structure
 * 
 * Url Structure 
 * {site_url}/{namespace}/{lang}/{controller}/{method}/{param}
 */
//------------------------------------------------------------------------------

$request  = \Config\Services::request();
$segments = $request->uri->getSegments();

if (($segments[0] ?? '') === 'tally')
{
    $locale = $segments[1] ?? NULL;

    if (empty($locale) || !in_array($locale, $request->config->supportedLocales))
    {
        //If locale is no in supportedList
        header('Location: ' . site_url('tally') . '/' . $request->getLocale());
        die();
    }

    //Set Locale
    $request->setLocale($locale);
    $routes->setDefaultNamespace('Tally');

    //General without Authication Filter
    $routes->get("tally/$locale/general", "General::index", ['namespace' => 'Tally\Controllers']);
    $routes->add("tally/$locale/general/(:segment)", "General::$1", ['namespace' => 'Tally\Controllers']);
    $routes->add("tally/$locale/general/(:segment)/(:any)", "General::$1/$2", ['namespace' => 'Tally\Controllers']);

    //Authication Links
    $routes->get("tally/$locale/auth", "Authentication::index", ['namespace' => 'Tally\Controllers']);
    $routes->add("tally/$locale/auth/(:segment)", "Authentication::$1", ['namespace' => 'Tally\Controllers']);
    $routes->add("tally/$locale/auth/(:segment)/(:any)", "Authentication::$1/$2", ['namespace' => 'Tally\Controllers']);
        
    //Add Authication Filter
    $option['filter'] = 'tallyAuthFilter';
    $option['namespace'] ='Tally\Controllers';

    $routes->get("tally", "Home::index", $option);
    $routes->get("tally/$locale", "Home::index", $option);

    if (isset($segments[2]))
    {
        //if there is controller name
        $moduleName  = $segments[2];
        $controllerName = ucfirst($segments[2]);
        
        $routes->get("tally/$locale/$moduleName", "$controllerName::index", $option);
        $routes->add("tally/$locale/$moduleName/(:segment)", "$controllerName::$1", $option);
        $routes->add("tally/$locale/$moduleName/(:segment)/(:any)", "$controllerName::$1/$2", $option);
    }
}
