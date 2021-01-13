            
             <li class="nav-item">
                <a class="nav-link" href="<?=admin_url('pollstat/pollstat');?>">
                    <i class="fab fa-markdown"></i>
                    <span><?=lang('home._page_pollstat');?></span>
                </a>
            </li>   
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=admin_url('parish/parish');?>">
                    <i class="fas fa-archway"></i>
                    <span><?=lang('home._page_parish');?></span>
                </a>
            </li>   
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=admin_url('subcounty/subcounty');?>">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><?=lang('home._page_subcounty');?></span>
                </a>
            </li>   
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=admin_url('county/county');?>">
                    <i class="fab fa-app-store"></i>
                    <span><?=lang('home._page_county');?></span>
                </a>
            </li>   
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=admin_url('admin/admin');?>">
                    <i class="fas fa-user"></i>
                    <span><?=lang('home._page_admin');?></span>
                </a>
            </li>   
            


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-building"></i>
                    <span><?=lang('home._crud_company');?> </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <h6 class="dropdown-header"><?=lang('home._crud_company');?> </h6>    

                    
            <a class="dropdown-item" href="<?=admin_url('company/company');?>"><i class="fas fa-building"></i> <?=lang('home._page_company');?> </a>

            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header"><?=lang('home._crud_user');?> </h6>

            <a class="dropdown-item" href="<?=admin_url('user/user');?>"><i class="far fa-user"></i> <?=lang('home._page_user');?> </a>

            <a class="dropdown-item" href="<?=admin_url('user/showchart/user_statistic');?>"><i class="fas fa-chart-line"></i> <?=lang('home._chart_user_statistic');?> </a>

            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header"><?=lang('home._crud_c4_subscription');?> </h6>

            <a class="dropdown-item" href="<?=admin_url('c4_subscription/c4_subscription');?>"><i class="fas fa-compress"></i> <?=lang('home._page_c4_subscription');?> </a>
 


                </div>
            </li>            
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=admin_url('c4_log/c4_log');?>">
                    <i class="fab fa-blogger"></i>
                    <span><?=lang('home._page_c4_log');?></span>
                </a>
            </li>   
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=admin_url('c4_template/c4_template');?>">
                    <i class="fas fa-gopuram"></i>
                    <span><?=lang('home._page_c4_template');?></span>
                </a>
            </li>   
            


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-envelope-open-text"></i>
                    <span><?=lang('home._crud_c4_email_history');?> </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <h6 class="dropdown-header"><?=lang('home._crud_c4_email_history');?> </h6>    

                    
            <a class="dropdown-item" href="<?=admin_url('c4_email_history/c4_email_history');?>"><i class="fas fa-envelope-open-text"></i> <?=lang('home._page_c4_email_history');?> </a>

            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header"><?=lang('home._crud_c4_sms_history');?> </h6>

            <a class="dropdown-item" href="<?=admin_url('c4_sms_history/c4_sms_history');?>"><i class="fas fa-phone"></i> <?=lang('home._page_c4_sms_history');?> </a>

            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header"><?=lang('home._crud_c4_email_track');?> </h6>

            <a class="dropdown-item" href="<?=admin_url('c4_email_track/c4_email_track');?>"><i class="fas fa-envelope-open-text"></i> <?=lang('home._page_c4_email_track');?> </a>
 


                </div>
            </li>            
            


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fab fa-autoprefixer"></i>
                    <span><?=lang('home._crud_c4_auth_attempt');?> </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <h6 class="dropdown-header"><?=lang('home._crud_c4_auth_attempt');?> </h6>    

                    
            <a class="dropdown-item" href="<?=admin_url('c4_auth_attempt/authentication_attempt');?>"><i class="fab fa-autoprefixer"></i> <?=lang('home._page_authentication_attempt');?> </a>

            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header"><?=lang('home._crud_c4_auth_code');?> </h6>

            <a class="dropdown-item" href="<?=admin_url('c4_auth_code/c4_auth_code');?>"><i class="fas fa-qrcode"></i> <?=lang('home._page_c4_auth_code');?> </a>

            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header"><?=lang('home._crud_c4_auth_token');?> </h6>

            <a class="dropdown-item" href="<?=admin_url('c4_auth_token/c4_auth_token');?>"><i class="fas fa-code-branch"></i> <?=lang('home._page_c4_auth_token');?> </a>
 


                </div>
            </li>            
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=admin_url('c4_file/c4_file');?>">
                    <i class="far fa-file"></i>
                    <span><?=lang('home._page_c4_file');?></span>
                </a>
            </li>   
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=admin_url('c4_session/c4_session');?>">
                    <i class="fas fa-diagnoses"></i>
                    <span><?=lang('home._page_c4_session');?></span>
                </a>
            </li>   
            


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-map"></i>
                    <span><?=lang('home._crud_c4_country');?> </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <h6 class="dropdown-header"><?=lang('home._crud_c4_country');?> </h6>    

                    
            <a class="dropdown-item" href="<?=admin_url('c4_country/c4_country');?>"><i class="fas fa-map"></i> <?=lang('home._page_c4_country');?> </a>

            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header"><?=lang('home._crud_c4_zone');?> </h6>

            <a class="dropdown-item" href="<?=admin_url('c4_zone/c4_zone');?>"><i class="fas fa-map-marker"></i> <?=lang('home._page_c4_zone');?> </a>
 


                </div>
            </li>            
            


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-file-invoice"></i>
                    <span><?=lang('home._crud_c4_invoice');?> </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <h6 class="dropdown-header"><?=lang('home._crud_c4_invoice');?> </h6>    

                    
            <a class="dropdown-item" href="<?=admin_url('c4_invoice/c4_invoice');?>"><i class="fas fa-file-invoice"></i> <?=lang('home._page_c4_invoice');?> </a>

            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header"><?=lang('home._crud_c4_invoice_item');?> </h6>

            <a class="dropdown-item" href="<?=admin_url('c4_invoice_item/c4_invoice_item');?>"><i class="fas fa-file-invoice-dollar"></i> <?=lang('home._page_c4_invoice_item');?> </a>
 


                </div>
            </li>            
            


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fab fa-amazon-pay"></i>
                    <span><?=lang('home._crud_c4_payment');?> </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <h6 class="dropdown-header"><?=lang('home._crud_c4_payment');?> </h6>    

                    
            <a class="dropdown-item" href="<?=admin_url('c4_payment/c4_payment');?>"><i class="fab fa-amazon-pay"></i> <?=lang('home._page_c4_payment');?> </a>

            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header"><?=lang('home._crud_c4_payment_attempt');?> </h6>

            <a class="dropdown-item" href="<?=admin_url('c4_payment_attempt/c4_payment_attempt');?>"><i class="fas fa-drumstick-bite"></i> <?=lang('home._page_c4_payment_attempt');?> </a>
 


                </div>
            </li>            
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=admin_url('home/showCalendar/admin_panel_calendar');?>">
                    <i class="fas fa-calendar-alt"></i>
                    <span><?=lang('home._calendar_admin_panel_calendar');?></span>
                </a>
            </li>   
            