        
var admin = function () {

    var tableID = 'table_admin';
    var page_slug = 'admin';
    var tableUrlExt = ''; //Datatabel Url Extension
    var form_sizes = {"admin":"lg"};
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
    
        return panel_url('votes' + param);
        
    };

    var getTableUrl = function () {

        if(tableUrlExt !== ''){
            return $('#' + tableID).data('url') + '?' + tableUrlExt;
        }

        return $('#' + tableID).data('url');
    };


    //Module Lang
    var votesLang = function (param, paramsub) {
        return getLang('votes', param, paramsub);
    };  

    var init_datatable = function () {

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
                    d.formFilter = $('#form_admin').serialize();

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
            order: [[1, 'desc']],
            columns: [
                {
                    "searchable": false,
                    "targets": 0,
                    title: '<label for="adminselectAll" class="text-center" style="width: 100%"><div class="text-center"><input type="checkbox" class="selectAll" id="adminselectAll"/></div></label>',
                    defaultContent: '',
                    "data": null,
                    orderable: false,
                    className: 'select-checkbox',
                    width: 30
                },
                                
                {   
                    sortable : true,
                    name: 'c4_zone_RELATIONAL_name',
                    title: votesLang('districtid'),
                    data: function ( row, type, set, meta ) 
                    {
                        var txt = !isEmpty(row.c4_zone_RELATIONAL_name)? escapeHtml(row.c4_zone_RELATIONAL_name) : '';
                        return '<span title="ID : ' + escapeHtml(row.districtid) + '">' + txt + '</span>';
                     }
                },
                                
                {   
                    sortable : true,
                    name: 'subcounty_RELATIONAL_name',
                    title: votesLang('subcountyid'),
                    data: function ( row, type, set, meta ) 
                    {
                        var txt = !isEmpty(row.subcounty_RELATIONAL_name)? escapeHtml(row.subcounty_RELATIONAL_name) : '';
                        return '<span title="ID : ' + escapeHtml(row.subcountyid) + '">' + txt + '</span>';
                     }
                },
                                
                {   
                    sortable : true,
                    name: 'parish_RELATIONAL_name',
                    title: votesLang('parishid'),
                    data: function ( row, type, set, meta ) 
                    {
                        var txt = !isEmpty(row.parish_RELATIONAL_name)? escapeHtml(row.parish_RELATIONAL_name) : '';
                        return '<span title="ID : ' + escapeHtml(row.parishid) + '">' + txt + '</span>';
                     }
                },
                                
                {   
                    sortable : true,
                    name: 'pollstat_RELATIONAL_name',
                    title: votesLang('pollstatid'),
                    data: function ( row, type, set, meta ) 
                    {
                        var txt = !isEmpty(row.pollstat_RELATIONAL_name)? escapeHtml(row.pollstat_RELATIONAL_name) : '';
                        return '<span title="ID : ' + escapeHtml(row.pollstatid) + '">' + txt + '</span>';
                     }
                },
            {   
                sortable : true,
 
                name: 'candidate1',
                title: votesLang('candidate1'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.candidate1 !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.candidate1);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {   
                sortable : true,
 
                name: 'candidate2',
                title: votesLang('candidate2'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.candidate2 !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.candidate2);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {   
                sortable : true,
 
                name: 'candidate3',
                title: votesLang('candidate3'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.candidate3 !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.candidate3);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {   
                sortable : true,
 
                name: 'candidate4',
                title: votesLang('candidate4'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.candidate4 !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.candidate4);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {   
                sortable : true,
 
                name: 'totalvoters',
                title: votesLang('totalvoters'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.totalvoters !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.totalvoters);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {   
                sortable : true,
 
                name: 'validvotes',
                title: votesLang('validvotes'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.validvotes !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.validvotes);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {   
                sortable : true,
 
                name: 'invalidvotes',
                title: votesLang('invalidvotes'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.invalidvotes !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.invalidvotes);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {   
                sortable : true,
 
                name: 'notvoted',
                title: votesLang('notvoted'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.notvoted !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.notvoted);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {   
                sortable : true,
 
                name: 'totalballotiss',
                title: votesLang('totalballotiss'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.totalballotiss !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.totalballotiss);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
            {   
                sortable : true,
 
                name: 'totalballotuse',
                title: votesLang('totalballotuse'),
                data: function ( row, type, set, meta ) {
                    
                    if(typeof row.totalballotuse !== 'string'){
                        return '';
                    }
                                        
                    var text = escapeHtml(row.totalballotuse);
                    
                                        
                    if( text.length > 36 ){
                        return text.substring(0, 36) + ` <a href="#" class="badge badge-light" data-toggle="tooltip" data-placement="left" title="` + text + `">...</a>`; 
                    }

                    return text;

                    
                }
            },
    
            {   
                sortable : true,
                name: 'evidence',
                title: votesLang('evidence'),
                data: function ( row, type, set, meta ) 
                {
                    if(!isEmpty(row.evidence_c4_url_thumb))
                    {
                        $x =  '<img src="' + (row.evidence_c4_url_thumb) + '" onerror="this.src=\'https://resources.crud4.com/v1/images/notfound.png\'" class="img-thumbnail" width="60" height="60"></img>';
                        return $x; 
                    
                    }
                    return '';
                 }
            },
                                            
                {   
                    sortable : true,
                    name: 'users_RELATIONAL_firstname',
                    title: votesLang('userid'),
                    data: function ( row, type, set, meta ) 
                    {
                        var txt = !isEmpty(row.users_RELATIONAL_firstname)? escapeHtml(row.users_RELATIONAL_firstname) : '';
                        return '<span title="ID : ' + escapeHtml(row.userid) + '">' + txt + '</span>';
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
                            var id = row.id;
                            var $link = ``;

                                var $link =`<div class="btn-group" role="group" aria-label="">`;
        
                            //admin form button
                            
                            $link += `<a
                               href="` + get_url('showForm/admin/' + id) + `" 
                               data-modalsize="lg"
                               data-datatable="table_admin"
                               data-modalurl="` + get_url('showForm/admin/' + id) + `"
                               data-modaldata='{"id":"` + id + `"}'
                               data-action="openformmodal"
                               data-modalview="centermodal"
                               data-modalbackdrop="true"
                               class="btn btn-sm btn-primary"
                               title="` + votesLang('_form_admin') + `" 
                               > <i class="fas fa-user-cog"></i> 
                            </a>`;             
                                                        //Dropdown Menu
                            $link += `<div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">`
                                   //Delete Link
                                $link += `    
                                   <a
                                    href="` + get_url('delete/' + id) + `" 
                                    data-datatable="table_admin"
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

                    $('#batch_admin').collapse('show');
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
                            $('#batch_admin').collapse('hide');
                        }

                        $('.selectedCount').html(count);
                    }
                })
                .on('draw', function () {

                    var $selectAll = $('#adminselectAll');

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
        $('#form_admin').find('.generalSearch').bind("keyup search", function () {
            console.log('Searching..');
            DT1.ajax.reload();
        });

        $('#form_admin').find('.formSearch').on('change', function (e) {

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
            $('#batch_admin').collapse('hide');
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
            return votesLang(param, paramsub);
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

    if ($('#table_admin').length > 0) {
    
        general.loadPackage('dataTable', function () {
            loadDatatableLang(function () {
                admin.init_datatable();
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
