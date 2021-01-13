<?php
$locale = service('request')->getLocale(); 
$resourcesUrl = resources_url();
?><!DOCTYPE html>
<html lang="<?=$locale;?>">

    <head>

        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content="PANEL"/>
        <meta name="author" content="crud4@crud4.com"/>
        <!-- csrf protection  -->
        <?= csrf_meta('csrf_header');?>
                
        <title><?= lang('auth.loginTitle'); ?></title>

        <!-- Custom fonts for this template-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"/>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="<?=$resourcesUrl;?>bootstrap/4.4.1/css/bootstrap.min.css"/>

        <!-- Theme/General Css-->
        <link href="<?=$resourcesUrl;?>themes/veboTheme/theme.css" rel="stylesheet" type="text/css"/>
        <link href="<?=$resourcesUrl;?>general.css" rel="stylesheet" type="text/css" />


    </head>

<body class="bg-dark">