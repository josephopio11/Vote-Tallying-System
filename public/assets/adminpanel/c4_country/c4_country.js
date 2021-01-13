        
var c4_country = function () {

    var tableID = 'table_c4_country';
    var page_slug = 'c4_country';
    var tableUrlExt = ''; //Datatabel Url Extension
    var form_sizes = {"c4_country":"lg"};
    var DT1 = false; //datatable handle
    var selected = {}; //datatable selected

    var get_selectedIds = function () {
        return DT1.rows({selected: true}).ids().toArray();
    };

    var get_url = function (param) {
    
        if (typeof param === 'undefined') {
            param = '';
        }else{
            param = '/' + param;
        }
    
        return panel_url('c4_country' + param);
        
    };

    var getTableUrl = function () {

        if(tableUrlExt !== ''){
            return $('#' + tableID).data('url') + '?' + tableUrlExt;
        }

        return $('#' + tableID).data('url');
    };
            
    // -- Relation  Lang Function 
    var c4_zoneLang = function (param, paramsub) {
        return getLang('c4_zone', param, paramsub);
    };

    var c4_zoneUrl = function(param){

        if (typeof param === 'undefined'){
            param = '';
        }

        var panel_language = homeLang('panel_language');

        return document.location.origin + '/adminpanel/' + panel_language + '/c4_zone/' +  param;
    };

            

    //Module Lang
    var c4_countryLang = function (param, paramsub) {
        return getLang('c4_country', param, paramsub);
    };  

    var init_datatable = function () {
        function subTable(d) {

            var rowID = d.DT_RowId;

            var div = $('<div class="slider pl-3 pr-3" id="slider_' + rowID + '"></div>');

        
            var childTableID = 'child_c4_zone' + rowID;
            var cardHeader = c4_zoneLang('_page_c4_zone');

            var $cardHtml = `<div class="card border-info  mt-2 mb-1">
            
            <div class="card-header text-white bg-info">
            
                <div class="float-left text-center">
                    <h6><i class="fas fa-map-marker"></i> `+ cardHeader +` <small><span class="date_title"></span></small></h6>
                </div>
                <ul class="nav nav-pills card-header-pills float-right">`;

            
                                    $cardHtml += `<button href="javascript:;"       
                                            href="` + c4_zoneUrl('showForm/c4_zone') + `" 
                                            data-modalsize="lg"
                                            data-datatable="child_c4_zone` + rowID + `"
                                            data-table="child_c4_zone` + rowID + `"
                                            data-modalurl="` + c4_zoneUrl('showForm/c4_zone') + `"
                                            data-modaldata='\{"c4_country_id":"` + rowID + `"\}'
                                            data-action="openformmodal"                        
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-map-marker"></i>
                                    </button>`;                             
            
            $cardHtml += `
                <button class="btn btn-sm btn-primary dropdown-toggle ml-1"
                    data-toggle="collapse" 
                    href="#body_`+ childTableID +`" 
                    role="button"
                    aria-expanded="true"
                    aria-controls="body_`+ childTableID +`" >
                </button>
            `;


            $cardHtml += `</ul>
            </div>
            <div class="card-body collapse show" id="body_`+ childTableID +`">

                <table id="` + childTableID + `" class="table responsive no-wrap" width="100%"><table/> 

            </div>
        </div>`;
        
            div.append($cardHtml);

            div.find('#' + childTableID).DataTable({
                "lengthMenu": [ 5, 10, 20, 50, 100 ],
                "processing": true,
                "serverSide": true,
                stateSave: true,
                "ajax": {
                    url: get_url('readC4_zone/read_c4_country_TO_c4_zone'),
                    "type": 'POST',
                    "data": function (d) {

                        d.formFilter = 'c4_country_id=' + rowID;

                        var $order_column = d.order[0]['column'];
                        var $order_name =  d.columns[$order_column]['name'];
                        d.order[0]['name'] = $order_name;

                    }
                },

                    
            order: [[1, 'desc']],

                columns: [
                                
                {   
                    sortable : true,
                    name: 'c4_country_RELATIONAL_name',
                    title: c4_zoneLang('c4_country_id'),
                    data: function ( row, type, set, meta ) 
                    {
                        var txt = !isEmpty(row.c4_country_RELATIONAL_name)? escapeHtml(row.c4_country_RELATIONAL_name) : '';
                        return '<span title="ID : ' + escapeHtml(row.c4_country_id) + '">' + txt + '</span>';
                     }
                },
            {   
                sortable : true,
 
                name: 'name',
                title: c4_zoneLang('name'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.name !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.name);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {   
                sortable : true,
 
                name: 'code',
                title: c4_zoneLang('code'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.code !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.code);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {
                name: 'Actions',
                title: homeLang('action'),  
                sortable: false,
                textAlign: 'right',
                overflow: 'visible',
                className: 'text-right',
                width:50,
        
                data: function (row) {
                    var id = row.c4_zone_id;
                    var child_id = d.c4_country_id;
                    var $link = ``;
        
                                                    $link += `<div class="btn-group" role="group" aria-label="">`;

                                    
                                    //c4_zone relation form button
                                    $link += `<button  
                                            href="` + c4_zoneUrl('showForm/c4_zone/' + id) + `" 
                                            data-modalsize="lg"
                                            data-datatable="child_c4_zone` + rowID + `"
                                            data-modalurl="` + c4_zoneUrl('showForm/c4_zone/' + id) + `"
                                            data-modaldata='\{"c4_country_id":"` + rowID + `"\}'
                                            data-action="openformmodal"  
                                            class="btn btn-sm btn-primary"
                                            title="` + c4_zoneLang('_form_c4_zone') + `">
                                            <i class="fas fa-map-marker"></i>
                                    </button>`;

                                    

                                
                                $link += `<div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">`;                                    //Sub Delete Link
                                   $link += `<a 
                                            href="` + c4_zoneUrl('delete/' + id) + `" 
                                            data-datatable="child_c4_zone` + rowID + `"
                                            data-actionurl="` + c4_zoneUrl('delete/' + id) + `"
                                            data-action="apirequest"
                                            data-question="areyousure"
                                            data-subtitle="will_be_deleted"
                                            data-usehomelang="true"
                                            data-ajaxmethod="DELETE"
                                            class="dropdown-item btn btn-sm btn-danger"  
                                            title="` + homeLang('delete') + `" 
                                            class="dropdown-item btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i> ` + homeLang('delete') + `
                                        </a>`;
                                      
                                $link += `</div>
                                  </div>`;
                            $link += `</div>`;
                            return $link;


                    
                    },
            } //End Action



        ],
        }).on('draw', function () {
        _callback_subdatatable_drawed();
        });
    
    
            return div;
        }

        if ($('#' + tableID).length === 0) {
            return;
        }

        if ($.fn.DataTable.isDataTable('#' + tableID)) {
            console.log('Datatable init has been already launched');
            return DT1;
        }

        DT1 = $('#' + tableID).DataTable({
            "retrieve": true,
            "dom": 'rt<"row"<"col-auto mr-auto"i><"col-auto pt-2"l><"col-auto"p>>',
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": getTableUrl(),
                "type": 'POST',
                "data": function (d) {
                    d.formFilter = $('#form_c4_country').serialize();

                    var $order_column = d.order[0]['column'];
                    var $order_name = d.columns[$order_column]['name'];
                    d.order[0]['name'] = $order_name;

                },
                error: function (jqXHR, error, thrown) {
                    alertFail(_getApiErrorString(jqXHR));
                    checkResponse(jqXHR);
                }
            },
            columnDefs: [
                {
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    width: 30
                }
            ],

            select: {
                style: 'multi',
                selector: '.select-checkbox',
                width: 30
            },
            order: [[2, 'desc']],
            columns: [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": '',
                    "searchable": false,
                    "targets": 0,
                    width: 30,
                },
                {
                    "searchable": false,
                    "targets": 1,
                    title: '<label for="c4_countryselectAll" class="text-center" style="width: 100%"><div class="text-center"><input type="checkbox" class="selectAll" id="c4_countryselectAll"/></div></label>',
                    defaultContent: '',
                    "data": null,
                    orderable: false,
                    className: 'select-checkbox',
                    width: 30
                },
            {   
                sortable : true,
 
                name: 'name',
                title: c4_countryLang('name'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.name !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.name);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {   
                sortable : true,
 
                name: 'iso_code_2',
                title: c4_countryLang('iso_code_2'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.iso_code_2 !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.iso_code_2);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {   
                sortable : true,
 
                name: 'iso_code_3',
                title: c4_countryLang('iso_code_3'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.iso_code_3 !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.iso_code_3);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {   
 
                sortable : true,
 
                name: 'address_format',
                title: c4_countryLang('address_format'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.address_format !== 'string'){
                        return '';
                    }
             
                    var text = escapeHtml(row.address_format);

                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }
                    
                    return text; 
                }
            },
            {   
                sortable : true,
 
                name: 'postcode_required',
                title: c4_countryLang('postcode_required'),
                className: "text-center",
                data: function ( row, type, set, meta ) {
                
                    var data_list = c4_countryLang('list_postcode_required');
               
                                    
                
                if(row.postcode_required == '1'){
                      return '<span class="badge badge-danger">' + data_list[row.postcode_required] + '</span>';
                }
                else if(row.postcode_required == '0' || row.postcode_required == '2'){
                      return '<span class="badge badge-success">' + data_list[row.postcode_required] + '</span>';
                }

                return !isEmpty(row.postcode_required)? escapeHtml(data_list[row.postcode_required]) : '';
                
                                
                  
                 }
            },
                    {
                        name: 'Actions',
                        title: homeLang('action'),
                        sortable: false,
                        textAlign: 'right',
                        overflow: 'visible',
                        className: 'text-right',
                        width:100,

                        data: function (row) {
                            var id = row.c4_country_id;
                            var $link = ``;

                                var $link =`<div class="btn-group" role="group" aria-label="">`;
        
                            //c4_country form button
                            
                            $link += `<a
                               href="` + get_url('showForm/c4_country/' + id) + `" 
                               data-modalsize="lg"
                               data-datatable="table_c4_country"
                               data-modalurl="` + get_url('showForm/c4_country/' + id) + `"
                               data-modaldata='{"c4_country_id":"` + id + `"}'
                               data-action="openformmodal"
                               data-modalview="centermodal"
                               data-modalbackdrop="true"
                               class="btn btn-sm btn-primary"
                               title="` + c4_countryLang('_form_c4_country') + `" 
                               > <i class="fas fa-map"></i> 
                            </a>`;             
                                                        //Dropdown Menu
                            $link += `<div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">`
                                   //Delete Link
                                $link += `    
                                   <a
                                    href="` + get_url('delete/' + id) + `" 
                                    data-datatable="table_c4_country"
                                    data-actionurl="` + get_url('delete/' + id) + `"
                                    data-action="apirequest"
                                    data-question="areyousure"
                                    data-subtitle="will_be_deleted"
                                    data-usehomelang="true"
                                    class="dropdown-item btn btn-sm btn-danger"  
                                    title="` + homeLang('delete') + `">
                                        <i class="fa fa-trash"></i> ` + homeLang('delete') + `</a>`;
                            $link += `
                                </div>
                            </div>`;        
                            $link += `</div>`;

                            return $link;


                        }
                } //And Action
            ],

            "rowCallback": function (row, data) {

                if (typeof selected[data.DT_RowId] !== 'undefined') {
                    DT1.row('#' + data.DT_RowId).select();
                }
            },
        })
                .on('select', function (e, dt, type, indexes) {

                    $('#batch_c4_country').collapse('show');
                    if (type === 'row') {
                        var selectedIDs = DT1.rows({selected: true}).ids().toArray();
                        
                        //keep ids on memory 
                        for (var key in selectedIDs) {
                            selected[selectedIDs[key]] = selectedIDs[key];
                        }
                            
                        $('.selectedCount').html(selectedIDs.length);
                    }
                })
                .on('deselect', function (e, dt, type, indexes) {

                    if (type === 'row') {

                        var deletedIDs = DT1.rows(indexes).ids().toArray();
                       
                        //remove ids from memory
                        for (var key in deletedIDs) {

                            if (typeof selected[deletedIDs[key]] !== 'undefined') {
                                delete selected[deletedIDs[key]];
                            }
                        }

                        var selectedIDs = DT1.rows({selected: true}).ids().toArray();
                        var count = selectedIDs.length;
                    
                        if (count === 0) {
                            $('#batch_c4_country').collapse('hide');
                        }

                        $('.selectedCount').html(count);
                    }
                })
                .on('draw', function () {

                    var $selectAll = $('#c4_countryselectAll');

                    if ($selectAll.is(":checked")) {
                        DT1.rows().select();
                    }

                    $selectAll.on('click', function () {
                        if ($(this).is(":checked")) {
                            DT1.rows().select();
                        } else {
                            DT1.rows().deselect();
                        }
                    });
                    
                    //Send call back to generaljs to init otherthings.
                    _callback_datatable_drawed();
        });
        // Add event listener for opening and closing details
        $('#' + tableID + ' tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = DT1.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                $('div.slider', row.child()).slideUp(function () {
                    row.child.hide();
                    tr.removeClass('shown');
                });
            } else {
                // Open this row
                row.child(subTable(row.data()), 'no-padding').show();
                tr.addClass('shown');

                $('div.slider', row.child()).slideDown();
            }
        });

        //Form
        $('#form_c4_country').find('.generalSearch').bind("keyup search", function () {
            console.log('Searching..');
            DT1.ajax.reload();
        });

        $('#form_c4_country').find('.formSearch').on('change', function (e) {

            //e.stopImmediatePropagation();

            if ($(this).attr('name') === 'deleted_at') {

                var column = DT1.column('deleted_at:name');

                if ($(this).val() === '1') {
                    column.visible(true);
                    $('.delete_link').hide();
                    $('.undelete_link').show();
                } else {
                    column.visible(false);

                    $('.delete_link').show();
                    $('.undelete_link').hide();
                }

            }

            reload_datatable();
        });
        
        return DT1;

    };
    var reload_datatable = function () {

        if (typeof DT1 === 'object') {
            
            if(tableUrlExt !== '')
            {
                DT1.ajax.url(getTableUrl()).load()
            }
            else{
                DT1.ajax.reload( null, false );
            }
            
        } else {
            init_datatable();
        }

        if (get_selectedIds().length === 0) {
            $('#batch_c4_country').collapse('hide');
        }

    };

    var destroyDatatable = function () {
        if (typeof DT1 == 'object') {
            DT1.destroy();
        }
    };

    var getModalSize = function (form_slug) {
        return typeof form_sizes[form_slug] != 'undefined' ? form_sizes[form_slug] : 'lg';
    };

    return {

        init_datatable: function () {
            return init_datatable();
        },

        reload_datatable: function () {
            reload_datatable();
        },

        returnDataUrl: function (url) {
            return url;
        },

        returnLang: function (param, paramsub) {
            return c4_countryLang(param, paramsub);
        },

        destroyDatatable: function () {
            destroyDatatable();
        },

        setTableUrlExt: function (param) {
            tableUrlExt = param;
        },

        get_url: function (param) {

            return get_url(param);
        },

        get_selectedIds: function () {
            return get_selectedIds();
        },
            
        getDT1: function () {
            return DT1;
        },
    }
}();

document.addEventListener('DOMContentLoaded', function () {

    if ($('#table_c4_country').length > 0) {
    
        general.loadPackage('dataTable', function () {
            loadDatatableLang(function () {
                c4_country.init_datatable();
            });
        });

        if ($('.select2_js').length > 0) {
            general.loadPackage('select2_js', function () {
                init_select2_js();
            });
        }
    }
 
    if ($('.daterangefilter').length > 0) {
        general.loadPackage('daterangepicker', function () {
            $('.daterangefilter').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear'
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }).on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                $(this).trigger("change");
            }).on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
                $(this).trigger("change");
            });
        });
    }
});
