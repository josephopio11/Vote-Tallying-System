
<!-- Styles -->
<div class="card border-light mb-0">
    <div class="card-header bg-transparent">

        <div class="row">
            <div class="col-xl-8 col-md-6 col-sm-12">
                <h5 class=""><i class="fab fa-500px"></i> <?= lang('votes._chart_totals'); ?>   &nbsp; </h5> 
            </div>
<!--            <div class="col"> 

                <small><span class="date_title"></span> </small>


            </div>-->
            <div class="col-xl-4 col-md-6 col-sm-12 ml-auto float-right">

                <div class="input-group pull-right" id="charttotals_daterangepicker">
                    <input type="text" class="form-control" readonly="" placeholder=""/>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-body p-0">

        <div class="chart">
            <div id="charttotals" class="xyChartDiv" data-hidetable = "false"></div>

        </div>
    </div>

</div>



    
<?php 
//$hideTable is extra option expected come from dashboard panel_view function.

if(!isset($hideTable)){
    echo voters_view('votes/votes', ['extraCondition' => []]);
}
?>            
<script src="<?= site_url('assets/voters/votes/XYChart_totals.js');?>"></script>