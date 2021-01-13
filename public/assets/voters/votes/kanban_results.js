


function getKanbanPageElement(kanbangroup) {
return $('#kanban_page_navigator_' + kanbangroup);
}

function getKanbanCounter(kanbangroup) {
return parseInt($('#count_' + kanbangroup).html());
}

function setKanbanCounter(kanbangroup, value) {
return $('#count_' + kanbangroup).html(value);
}

function html_formLink(data) {

var id =  data.DT_RowId;

                            var $link =`<div class="btn-group" role="group" aria-label="">`;
        
                            //votes62729055 form button
                            
                            $link += `<a
                               href="` + panel_url('votes/showForm/votes62729055/' + id) + `" 
                               data-modalsize="lg"
                               data-datatable="table_results"
                               data-modalurl="` + panel_url('votes/showForm/votes62729055/' + id) + `"
                               data-modaldata='{"id":"` + id + `"}'
                               data-action="openformmodal"
                               data-modalview="centermodal"
                               data-modalbackdrop="true"
                               class="btn btn-sm btn-primary"
                               title="`+ getLang('votes','_form_votes62729055') + `" 
                               > <i class="fas fa-vote-yea"></i> 
                            </a>`;             
                                                        //Dropdown Menu
                            $link += `<div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" 
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">`
                    
                            //pdfLink
                    
                            
                            
                            $link += `<a
                               href="` + panel_url('createPdf/votes62729055/' + id) + `"
                               target="_blank"
                               class="dropdown-item btn btn-sm btn-danger" 
                               title="` + getLang('votes','pdf') + `" 
                               > <i class="fas fa-file-pdf"></i>  ` + getLang('votes','_form_votes62729055') + ' ' +  getLang('votes',('pdf') + `
                            </a>`;           
                               
                               
                            $link += `
                                </div>
                            </div>`;        
                            $link += `</div>`;

                            return $link;
return $link;

}

function html_kanvan_portlet(data) {

var viewtitle = escapeHtml(data.);

if (viewtitle.length > 25) {
viewtitle = viewtitle.substring(0, 25) + `<span title="` + viewtitle + `" data-toggle="tooltip" style="cursor:pointer">...</span>`;
}


    var descriptionView = '';



                       var file_view = '';

                   



                   var kanbanvalue = data['totalvoters'];

                   return ` <div class="card portlet" data-id="` + data.DT_RowId + `" data-kanbangroup="` + kanbanvalue + `">

        <div class="card-header portlet-header" style="cursor:move">
            ` + viewtitle + `
        </div>
        ` + file_view + `
        <div class="card-body portlet-content" style="">
            <p class="card-text">` + descriptionView + `</p>
            ` + html_formLink(data) + `
        </div>
    </div>`;

    }

function updateKanbanItem(ui) {

        if (!ui.sender) {

            var id = ui.item.data('id');
            var oldkanbangroup = ui.item.data('kanbangroup');
            var newkanbangroup = $(ui.item).closest(".kanbangroup").data('kanbangroup');
            var postion = ui.item.index();

            $.ajax({
                url: panel_url('votes/update/') + id,
                type: "POST",
                data: {['totalvoters']: newkanbangroup, 'sort_order': postion},
                dataType: 'json',
            }).done(function (data) {

                alertSuccess(_getApiSuccessString(data));

                setKanbanCounter(newkanbangroup, getKanbanCounter(newkanbangroup) + 1);
                setKanbanCounter(oldkanbangroup, getKanbanCounter(oldkanbangroup) - 1);

                $(ui.item).data('kanbangroup', newkanbangroup);

            }).fail(function (jqXHR, textStatus, errorThrown) {

                checkResponse(jqXHR);
                alertFail(_getApiErrorString(jqXHR));

            });
        }
    }

function init_kanban_sortable() {

    $(".kanbangroup").sortable({
        connectWith: ".kanbangroup",
        handle: ".portlet-header",
        cancel: ".portlet-toggle",
        placeholder: "portlet-placeholder ui-corner-all",

    update: function (e, ui) {
        if (!ui.sender) {
        updateKanbanItem(ui);
        }
    }
    });

    initToolTip();

    //    $(".portlet")
    //            .addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
    //            .find(".portlet-header")
    //            //.addClass("ui-widget-header ui-corner-all")
    //            .prepend("<span class='ui-icon ui-icon-plusthick portlet-toggle'></span>");
    //
    //    $(".portlet-toggle").on("click", function () {
    //        var icon = $(this);
    //        icon.toggleClass("ui-icon-minusthick ui-icon-plusthick");
    //        icon.closest(".portlet").find(".portlet-content").toggle();
    //    });


    }

function loadKanbanGroup(kanbangroup, activepage) {

        var PAGE_LENGT = 20;

        if (typeof activepage === 'undefined' || activepage < 0) {
            activepage = 1;
        }

        var start = (activepage - 1) * PAGE_LENGT;
        var kanban_area = 'kanvan_' + kanbangroup;

        $.ajax({
            url: panel_url('votes/readVotes/results/'),
            dataType: "json",
            async: false,
            cache: true,
            data: {
            start: start,
            length: PAGE_LENGT,
            formFilter: $('#form_results').serialize() + '&totalvoters=' + kanbangroup,
            'order[0][name]': 'updated_at',
            'order[0][dir]': 'desc'
        },

        }).done(function (data) {

            var $kanban_page_navigator = getKanbanPageElement(kanbangroup);
            var $kanban_count = $('#count_' + kanbangroup);

            if (!isEmpty(data.data)) {

                for (key in data.data) {
                    $('#' + kanban_area).append(html_kanvan_portlet(data.data[key]));
                }
            }

            if (!isEmpty(data.recordsTotal) && data.recordsTotal > (activepage * PAGE_LENGT)) {

                $kanban_page_navigator.show();

            } else {

                $kanban_page_navigator.hide();
            }

        $kanban_count.html(data.recordsTotal);

        $kanban_page_navigator.data('activepage', activepage);

        }).fail(function (jqXHR, textStatus, errorThrown) {

        });

}

function loadAllKanbanGroup() {

    $('.kanbangroup').each(function () {

        $(this).html('');

        var kanbangroup = $(this).data('kanbangroup');

        loadKanbanGroup(kanbangroup);

    });

    init_kanban_sortable();
}

document.addEventListener('DOMContentLoaded', function () {

    general.loadPackage('jquery-ui', function () {
        loadAllKanbanGroup();
    });

    $('.kanban_page_navigator').on('click', function () {

        var activepage = $(this).data('activepage');
        var kanbangroup = $(this).data('kanbangroup');

        loadKanbanGroup(kanbangroup, activepage + 1);
    });

    $(document).on("onFormDone", function (event, arg1) {

        loadAllKanbanGroup();

        // ---------------------------------------------------------------------
        if (arg1.id === 'formID') {

        }
        // ---------------------------------------------------------------------

    });

    $(document).on("onDeleted", function (event, arg1) {

        loadAllKanbanGroup();

    });

    $('#form_results').find('.generalSearch').bind("keyup search", function () {

        loadAllKanbanGroup();
    });


    $('#form_results').find('.formSearch').on('change', function () {

        loadAllKanbanGroup();

    });

});
