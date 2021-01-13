 

function init_calender_admin_panel_calendar(){

        general.loadPackage('calendar', function () {

            var calendarEl = document.getElementById('calendar_admin_panel_calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['interaction', 'dayGrid', 'timeGrid', 'list', 'bootstrap'],
                themeSystem: 'bootstrap',
                locale: getLocale(),
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                },
                editable: false,
                navLinks: true, // can click day/week names to navigate views
                eventLimit: true, // allow "more" link when too many events
                eventSources: [

                            {
                                events: function (info, successCallback, failureCallback) {
                                    $.ajax({
                                        url: panel_url('c4_log/readC4_log/c4_log'),
                                        dataType: 'json',
                                        type: 'POST',
                                        data: {
                                                'dateRangeStart[created_at]': moment(info.startStr).format('YYYY-MM-DD'),
                                                'dateRangeEnd[created_at]': moment(info.endStr).format('YYYY-MM-DD'),
                                                //formFilter: $('#form_calendar').serialize()
                                        },
                                        success: function (doc) {

                                            for(key in doc.data){                                            
                                                
                                                    doc.data[key]['title'] = doc.data[key]['level'];
                                                    doc.data[key]['start'] = doc.data[key]['created_at'];
                                                    doc.data[key]['end'] = doc.data[key][' '];
                                                    doc.data[key]['modalLink'] = 'c4_log/showForm/c4_log' + '/' + doc.data[key]['DT_RowId']; 
                                            }

                                            successCallback(doc.data);
                                        }
                                    });
                                },
                                color: '#007bff',
                                textColor: '#000000'
                            },
                ],

                loading: function (bool) {
                    document.getElementById('loading').style.display = bool ? 'block' : 'none';
                },
                eventSourceSuccess: function (content, xhr) {
                    console.log(content['data'], 'content');
                    return content['data'];
                },
                bootstrapFontAwesome: {
                    close: 'fa-times',
                    prev: 'fa-chevron-left',
                    next: 'fa-chevron-right',
                    prevYear: 'fa-angle-double-left',
                    nextYear: 'fa-angle-double-right'
                },
                eventClick: function (info) {

                    //console.log(info.event._def.extendedProps, 'info.event._def.extendedProps');

                    var DT_RowId = info.event._def.extendedProps.DT_RowId;
                    var modalurl = info.event._def.extendedProps.modalLink;
                    general.setModalSize('lg').showFormModal(panel_url(modalurl));


                },
                dateClick: function (info) {
                    //            var modalurl = '<?= admin_url('calendar / showForm / calendar'); ?>';
                    //            general.setModalSize('lg').showFormModal(modalurl, {start: info.dateStr});
                },
            });

            calendar.render();

            $(document).on("onFormDone", function (event, param) {
                calendar.refetchEvents();
            });

            $(document).on("onDeleted", function (event, param) {
                calendar.refetchEvents();
                hide_ajax_modal();
            });

            $('#form_calendar').find('.generalSearch').bind("keyup search", function () {
                calendar.refetchEvents();
            });

        });


}

document.addEventListener('DOMContentLoaded', function () {

    init_calender_admin_panel_calendar();
});

