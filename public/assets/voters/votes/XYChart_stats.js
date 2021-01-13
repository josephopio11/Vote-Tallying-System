document.addEventListener('DOMContentLoaded', function () {

    general.loadPackage('daterangepicker', function () {
        
    });
    
    general.loadPackage('amcharts', function () {
    var hidetable = $('#chartstats').data('hidetable');
    
    var sourceUrl = panel_url('votes/readChartData/stats') + '?';

    // predefined ranges
    var start = moment().startOf('month');
    var end = moment().endOf('month');
    var start_mysql = start.format('YYYY-MM-DD');
    var end_mysql = end.format('YYYY-MM-DD');
    
    $('#chartstats_daterangepicker .form-control').val(start.format('DD MMMM YYYY') + ' / ' + end.format('DD MMMM YYYY'));

    $('#chartstats_daterangepicker').daterangepicker({
        buttonClasses: 'm-btn btn',
        applyClass: 'btn-primary',
        cancelClass: 'btn-secondary',

        startDate: start,
        endDate: end,
        ranges: {
            [homeLang('today')]: [moment(), moment()],
            [homeLang('yesterday')]: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            [homeLang('this_month')]: [moment().startOf('month'), moment().endOf('month')],
            [homeLang('last_month')]: [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            [homeLang('this_year')] : [moment().startOf('year'), moment()],
            [homeLang('last_year')] : [moment().subtract(1, 'years').startOf('year'), moment().subtract(1, 'years').endOf('year')]
        }
    }, function (start, end, label) {

        start_mysql = start.format('YYYY-MM-DD');
        end_mysql = end.format('YYYY-MM-DD');

        chart.dataSource.url = sourceUrl + "&startDate=" + start_mysql + "&endDate=" + end_mysql;
        chart.dataSource.load();
   
        $('#chartstats_daterangepicker .form-control').val(start.format('DD MMMM YYYY') + ' / ' + end.format('DD MMMM YYYY'));

    
        if (typeof votes !== 'undefined') {
            //Datatable ... 
            votes.setTableUrlExt('dateRangeStart[pollstatid]=' + start_mysql + '&dateRangeEnd[pollstatid]=' + end_mysql);
            votes.reload_datatable();
            $(".date_title").html(start.format('DD MMMM YYYY') + ' - ' + end.format('DD MMMM YYYY') + '');
        }
    
    });

    var TableUrlExt = 'dateRangeStart[pollstatid]=' + start_mysql + '&dateRangeEnd[pollstatid]=' + end_mysql;
    am4core.useTheme(am4themes_animated);


    
    //Chart
    var chart = am4core.create("chartstats", am4charts.XYChart3D);
    chart.dataSource.url = sourceUrl + "startDate=" + start_mysql + "&endDate=" + end_mysql;

    // Create axes
    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "CATEGORY";
    categoryAxis.renderer.grid.template.location = 0;
    categoryAxis.renderer.minGridDistance = 30;

    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.title.text = getLang('votes', 'stats');

    
    
    
        //========SERIESS
        
            var series_356 = chart.series.push(new am4charts.ColumnSeries());
            series_356.dataFields.valueY = "series_356";
            series_356.dataFields.categoryX = "CATEGORY";
            series_356.name =  getLang('votes', 'series_356'); 
            series_356.clustered = false;
            series_356.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";

        

    

    

    //===========START DATATABLE      
    
    if (typeof votes !== 'undefined') {
        votes.setTableUrlExt(TableUrlExt);
        votes.reload_datatable();
        $(".date_title").html(start.format('DD MMMM YYYY') + ' - ' + end.format('DD MMMM YYYY') + '');
    }
        });
});