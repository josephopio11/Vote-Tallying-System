                    </div>
                    <!-- /.container-fluid -->

                    <!-- Sticky Footer -->
                    <!--        <footer class="sticky-footer">
                      <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                          <span><?=lang('home.copyright');?></span>
                        </div>
                      </div>
                    </footer>-->

            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
          <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?=lang('home.ready_to_leave');?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body"><?=lang('home.logout_warning');?></div>
              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><?=lang('home.cancel');?></button>
                <a class="btn btn-primary" href="<?=voters_url('auth/logout');?>"><?=lang('home.logout');?></a>
              </div>
            </div>
          </div>
        </div>

        <!-- GENERAL MODAL DO NOT DELETE -->
        <div class="modal fade" role="dialog" id="general_modal"  aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <?=lang('home.loading');?> 
                </div>
            </div>
        </div>
        <!--/ GENERAL MODAL DO NOT DELETE -->
    
<?php
$resourcesUrl = resources_url();
?>
        <!--  bootstrap -->
        <script src="<?= $resourcesUrl;?>jquery/jquery-3.4.1.min.js"></script>
        <script src="<?= $resourcesUrl;?>popper/1.12.9/popper.min.js"></script>
        <script src="<?= $resourcesUrl;?>bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <!--  moment.js -->
        <script src="<?= $resourcesUrl;?>moment/2.24.0/moment-with-locales.min.js"></script>
        <!-- sweetalert  -->
        <script src="<?= $resourcesUrl;?>sweatalert2/9.8.2/sweetalert2.all.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="<?=$resourcesUrl;?>jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="<?=$resourcesUrl;?>themes/veboTheme/theme.js"></script>
        <!-- CRUD4 js file -->
        <script src="<?= voters_url('home/langJS');?>"></script>
        <script src="<?=$resourcesUrl;?>generalv2.js?v=3.41"></script>
        
    <?php if(isset($jsList) && !empty($jsList)): 
        foreach ($jsList as $key => $jsFile):
    ?>

        <script src="<?= $jsFile ?>"></script>

    <?php
        endforeach;
    endif; 
    ?>

    </body>
</html>