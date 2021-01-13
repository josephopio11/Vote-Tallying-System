            
             <li class="nav-item">
                <a class="nav-link" href="<?=voters_url('votes/votes');?>">
                    <i class="fas fa-vote-yea"></i>
                    <span><?=lang('home._page_votes');?></span>
                </a>
            </li>   
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=voters_url('pollstat/pollstat');?>">
                    <i class="fab fa-markdown"></i>
                    <span><?=lang('home._page_pollstat');?></span>
                </a>
            </li>   
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=voters_url('parish/parish');?>">
                    <i class="fas fa-archway"></i>
                    <span><?=lang('home._page_parish');?></span>
                </a>
            </li>   
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=voters_url('subcounty/subcounty');?>">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><?=lang('home._page_subcounty');?></span>
                </a>
            </li>   
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=voters_url('county/county');?>">
                    <i class="fab fa-app-store"></i>
                    <span><?=lang('home._page_county');?></span>
                </a>
            </li>   
            


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i>
                    <span><?=lang('home._crud_users');?> </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <h6 class="dropdown-header"><?=lang('home._crud_users');?> </h6>    

                    
            <a class="dropdown-item" href="<?=voters_url('users/users');?>"><i class="fas fa-user"></i> <?=lang('home._page_users');?> </a>

            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header"><?=lang('home._crud_usertype');?> </h6>

            <a class="dropdown-item" href="<?=voters_url('usertype/usertype');?>"><i class="fas fa-user-cog"></i> <?=lang('home._page_usertype');?> </a>
 


                </div>
            </li>            
            