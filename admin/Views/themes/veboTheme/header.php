<?php
$locale = service('request')->getLocale(); 
$authService = \Admin\Config\Services::auth();
$resourcesUrl = resources_url();
?>
<!DOCTYPE html>
<html lang="<?=$locale;?>">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content=""/>
        <meta name="author" content="CRUD4.com"/>
        <!-- csrf protection  -->
        <?= csrf_meta('csrf_header');?>
        
    <title><?= $page_title ??  'PANEL';?></title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?=$resourcesUrl;?>bootstrap/4.4.1/css/bootstrap.min.css"/>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"/>
    <!-- Sweet Alert2 -->
    <link rel="stylesheet" href="<?=$resourcesUrl;?>sweatalert2/9.8.2/sweetalert2.min.css"/>
    <!-- Theme Css-->
    <link href="<?=$resourcesUrl;?>themes/veboTheme/theme.css" rel="stylesheet" type="text/css"/>
    <!-- General Css -->
    <link rel="stylesheet" type="text/css" href="<?=$resourcesUrl;?>general.css"/>
<?php if(isset($cssList) && !empty($cssList)): 
    foreach ($cssList as $key => $cssFile):
    ?>

    <link rel="stylesheet" href="<?= $cssFile ?>"/>

<?php 
    endforeach;
    endif;?>


</head>

<body id="page-top" class="sidebar-toggled">

    <nav class="navbartop navbar navbar-expand  navbar-header static-top shadow-sm bg-white rounded">

        <a class="navbar-brand p-1 mr-1 text-center toggled" href="<?=admin_url('home/index');?>">
            <img src="<?= site_url('resources/images/logo.png') ?>" width="50"/>
        </a>

        <button class="btn btn-link btn-sm text-black order-1 order-sm-0 text-dark" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>

        <?php
                if (!empty($breadcrumb)):
                    ?>     
        <!-- Breadcrumbs-->
        <div class="collapse navbar-collapse ml-1" id="breadcrumb">
            <ol class="navbar-nav">
<?php 
                foreach ($breadcrumb as $key => $breadData) :

                $url = $breadData['url'] ?? null;
                $title = $breadData['title'] ?? null;
                $class = $breadData['class'] ?? null;

                if (!empty($url)):
                ?>
                <li class="breadcrumb-item <?php echo $class ?? ''; ?>">
                    <a href="<?php echo $url; ?>"><?php echo $title; ?></a>
                </li>
                <?php else: ?>
                <li class="breadcrumb-item <?php echo $class ?? ''; ?>" aria-current="page"><?php  echo $title; ?></li>
<?php endif;
                endforeach;
                ?>
            </ol>
        </div>
        <!-- / Breadcrumbs-->
<?php endif; ?>
        <!-- Navbar Search -->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <!--      <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>-->
        </form>
        <!-- Navbar -->

        <ul class="navbar-nav ml-auto ml-md-0">
            
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=strtoupper($locale);?></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
                    
                            <?php
                            $config = config( 'App' );
                            $current_url = current_url();

                            foreach($config->supportedLocales as $lang)
                            {
                                $change_url = str_replace("/$locale/", "/$lang/", $current_url);
                                echo '<a class="dropdown-item" href="' . $change_url. '">' . strtoupper($lang). '</a>';
                            }
                            ?>
          
                </div>
            </li>

                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle fa-fw"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

                        <div class="card border-light mb-2" style="width: 18rem;">
                            <div class="row no-gutters">
                                <div class="col-md-3 d-flex justify-content-center align-items-center">
                                    <i class="fas fa-user-circle fa-fw fa-3x"></i>
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body p-1 m-1">
                                        <h5 class="card-title"><?= $authService->getFullName(); ?></h5>
                                        <p class="card-text"><?= $authService->getEmail(); ?> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr/>

                        <a class="dropdown-item" href="<?=admin_url('home/account/personel');?>"><?=lang('home.account');?></a>
                        <a class="dropdown-item" href="<?=admin_url('auth/logout');?>" data-toggle="modal" data-target="#logoutModal"><?=lang('home.logout');?></a>
                    </div>
                </li>

        </ul>
        <!-- Navbar -->

    </nav>
    <!-- wrapper -->  
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav toggled pt-2">

<?php echo admin_view('themes/veboTheme/menu-part'); ?>
    </ul>
    <!-- / Sidebar -->

    <!-- content-wrapper -->
    <div id="content-wrapper">

        <!-- container-fluid -->    
        <div class="container-fluid">
