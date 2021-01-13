document.addEventListener('DOMContentLoaded', function () {

    general.loadPackage('daterangepicker', function () {
        
    });
    
    general.loadPackage('amcharts', function () {
    var hidetable = $('#chartuser_statistic').data('hidetable');
    
    var sourceUrl = panel_url('user/readChartData/user_statistic') + '?';

    // predefined ranges
    var start = moment().startOf('month');
    var end = moment().endOf('month');
    var start_mysql = start.format('YYYY-MM-DD');
    var end_mysql = end.format('YYYY-MM-DD');
    
    $('#chartuser_statistic_daterangepicker .form-control').val(start.format('DD MMMM YYYY') + ' / ' + end.format('DD MMMM YYYY'));

    $('#chartuser_statistic_daterangepicker').daterangepicker({
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
   
        $('#chartuser_statistic_daterangepicker .form-control').val(start.format('DD MMMM YYYY') + ' / ' + end.format('DD MMMM YYYY'));

    
        if (typeof user !== 'undefined') {
            //Datatable ... 
            user.setTableUrlExt('dateRangeStart[created_at]=' + start_mysql + '&dateRangeEnd[created_at]=' + end_mysql);
            user.reload_datatable();
            $(".date_title").html(start.format('DD MMMM YYYY') + ' - ' + end.format('DD MMMM YYYY') + '');
        }
    
    });

    var TableUrlExt = 'dateRangeStart[created_at]=' + start_mysql + '&dateRangeEnd[created_at]=' + end_mysql;
    am4core.useTheme(am4themes_animated);


    
    // ====================DATE BASED =====================================//
    //Chart
    var chart = am4core.create("chartuser_statistic", am4charts.XYChart);
    chart.dataSource.url = sourceUrl + "startDate=" + start_mysql + "&endDate=" + end_mysql;

    // Create axes
    var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

    
    //=================series 404    
    var series_404 = chart.series.push(new am4charts.LineSeries());
    series_404.dataFields.valueY = "series_404";
    series_404.dataFields.dateX = "CATEGORY";
    series_404.tooltipText = "{series_404} - " + getLang('user', 'series_404')
    series_404.strokeWidth = 2;
    series_404.minBulletDistance = 15;
    series_404.name = getLang('user', 'series_404'); 


    // Drop-shaped tooltips
    series_404.tooltip.background.cornerRadius = 20;
    series_404.tooltip.background.strokeOpacity = 0;
    series_404.tooltip.pointerOrientation = "vertical";
    series_404.tooltip.label.minWidth = 40;
    series_404.tooltip.label.minHeight = 40;
    series_404.tooltip.label.textAlign = "middle";
    series_404.tooltip.label.textValign = "middle";

    //==========bullet
    var bullet = series_404.bullets.push(new am4charts.CircleBullet());
    bullet.circle.strokeWidth = 2;
    bullet.circle.radius = 4;
    bullet.circle.fill = am4core.color("#fff");
    var bullethover = bullet.states.create("hover");
    bullethover.properties.scale = 1.3;

            
    // =============Make a panning cursor dddddd
    chart.cursor = new am4charts.XYCursor();
    chart.cursor.behavior = "panXY";
    chart.cursor.xAxis = dateAxis;
    chart.cursor.snapToSeries = series_404; //first key in array

    //=============== 

    if(hidetable){

        // Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

        // Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series_404);    
        chart.scrollbarX.parent = chart.bottomAxesContainer;

    }

    // Add legend
    chart.legend = new am4charts.Legend();

    chart.events.on("ready", function () {
        dateAxis.zoom({start: 0, end: 1});
    });
    

    

    //===========START DATATABLE      
    
    if (typeof user !== 'undefined') {
        user.setTableUrlExt(TableUrlExt);
        user.reload_datatable();
        $(".date_title").html(start.format('DD MMMM YYYY') + ' - ' + end.format('DD MMMM YYYY') + '');
    }
        });
});