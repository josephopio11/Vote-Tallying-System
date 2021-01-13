

<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="fas fa-calendar-alt"></i> <?=lang('home._calendar_admin_panel_calendar');?> &nbsp; <small><span class="date_title"></span></small></h5>
        </div>


        <!-- begin: Form Buttons -->
        <ul class="nav nav-pills card-header-pills float-right">
                       
            <?php
            $encoded = '';
            $url = admin_url('c4_log/showForm/c4_log');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>           
                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="fab fa-blogger"></i>
                                    <span><?=lang('c4_log._form_c4_log'); ?></span>
                                </span>
                            </a>
                        </li>                         

                        



        </ul>
        <!-- end: Form Buttons -->

    </div>
    <div class="card-body mb-0 pt-0">
        <br/>
        <div id='loading'>loading...</div>
        <div id='calendar_admin_panel_calendar' data-action="show_calendar"></div>
    </div>

</div>

<script src="<?php echo admin_assets('home/admin_panel_calendar.js');?>"></script>
