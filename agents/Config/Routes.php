<?php
//------------------------------------------------------------------------------
/**
 * Routes of Agents
 * 
 * Avaible MultiLanguage url structure
 * 
 * Url Structure 
 * {site_url}/{namespace}/{lang}/{controller}/{method}/{param}
 */
//------------------------------------------------------------------------------

$request  = \Config\Services::request();
$segments = $request->uri->getSegments();

if (($segments[0] ?? '') === 'agents')
{
    $locale = $segments[1] ?? NULL;

    if (empty($locale) || !in_array($locale, $request->config->supportedLocales))
    {
        //If locale is no in supportedList
        header('Location: ' . site_url('agents') . '/' . $request->getLocale());
        die();
    }

    //Set Locale
    $request->setLocale($locale);
    $routes->setDefaultNamespace('Agents');

    //General without Authication Filter
    $routes->get("agents/$locale/general", "General::index", ['namespace' => 'Agents\Controllers']);
    $routes->add("agents/$locale/general/(:segment)", "General::$1", ['namespace' => 'Agents\Controllers']);
    $routes->add("agents/$locale/general/(:segment)/(:any)", "General::$1/$2", ['namespace' => 'Agents\Controllers']);

    //Authication Links
    $routes->get("agents/$locale/auth", "Authentication::index", ['namespace' => 'Agents\Controllers']);
    $routes->add("agents/$locale/auth/(:segment)", "Authentication::$1", ['namespace' => 'Agents\Controllers']);
    $routes->add("agents/$locale/auth/(:segment)/(:any)", "Authentication::$1/$2", ['namespace' => 'Agents\Controllers']);
        
    //Add Authication Filter
    $option['filter'] = 'agentsAuthFilter';
    $option['namespace'] ='Agents\Controllers';

    $routes->get("agents", "Home::index", $option);
    $routes->get("agents/$locale", "Home::index", $option);

    if (isset($segments[2]))
    {
        //if there is controller name
        $moduleName  = $segments[2];
        $controllerName = ucfirst($segments[2]);
        
        $routes->get("agents/$locale/$moduleName", "$controllerName::index", $option);
        $routes->add("agents/$locale/$moduleName/(:segment)", "$controllerName::$1", $option);
        $routes->add("agents/$locale/$moduleName/(:segment)/(:any)", "$controllerName::$1/$2", $option);
    }
}
