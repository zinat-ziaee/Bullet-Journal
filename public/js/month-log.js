$(function () {    
    // ==========================================
    // AJAX / CSRF
    // ==========================================

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    
    // ==========================================
    // Context
    // ==========================================

    window.monthLogContext = null;
    

    // ==========================================
    // Jalali DatePicker
    // ==========================================

    initJalaliDatePicker();


    // ==========================================
    // باز کردن Modal از روی روز ماهنگار
    // ==========================================
    // ==========================================
    // Day Overlay
    // ==========================================

    $(document).on('click', '.month-day', function (e) {

        e.preventDefault();

        const $day = $(this);

        window.monthLogContext = {
            collectionId: $day.data('collection-id'),
            date: $day.data('date'),
            day: $day.data('day')
        };


        // ==========================================
        // Load Day Data
        // ==========================================

        $.get(window.monthLogDayDataUrl, {

            collection_id: window.monthLogContext.collectionId,

            date: window.monthLogContext.date,

            year: $('.month-log').data('year'),

            month: $('.month-log').data('month')

        })
        .done(function(data){

            renderDayOverlayData(data);

        })
        .fail(function(xhr){

            console.error(
                'خطا در دریافت اطلاعات روز:',
                xhr.responseText
            );

        });


        // اگر Overlay قبلاً ساخته شده، فقط اطلاعاتش را عوض کن
        let $overlay = $('#dayDetailsOverlay');

        if (!$overlay.length) {

            $overlay = $(`
                <div id="dayDetailsOverlay" class="day-details-overlay">

                    <div class="day-overlay-card">

                        <div class="day-overlay-header">

                            <div class="day-overlay-title">

                                <strong id="selectedDayNumber"></strong>

                                <span id="selectedDayDate"></span>

                            </div>

                            <button
                                type="button"
                                id="addDayItem"
                                class="day-add-btn">
                                + افزودن
                            </button>

                            <button
                                type="button"
                                id="closeDayDetails"
                                class="day-overlay-close">
                                ×
                            </button>

                        </div>


                        <div class="day-overlay-content">

                            <section class="day-overlay-section">

                                <h4>✓ وظایف</h4>

                                <div id="dayTasks">
                                    <div class="day-item">
                                        فعلاً اطلاعاتی وجود ندارد
                                    </div>
                                </div>

                            </section>


                            <section class="day-overlay-section">

                                <h4>• یادداشت‌ها</h4>

                                <div id="dayNotes">
                                    <div class="day-item">
                                        فعلاً اطلاعاتی وجود ندارد
                                    </div>
                                </div>

                            </section>


                            <section class="day-overlay-section">

                                <h4>○ رویدادها</h4>

                                <div id="dayEvents">
                                    <div class="day-item">
                                           فعلاً اطلاعاتی وجود ندارد

                                    </div>
                                </div>

                            </section>

                        </div>

                    </div>

                </div>
            `);

            // بسیار مهم:
            // Overlay خارج از Grid ساخته می‌شود
            $('.month-log-layout').append($overlay);    }


        // شماره روز
        $('#selectedDayNumber')
            .text($day.data('day'));


        // فعلاً تاریخ
        $('#selectedDayDate')
            .text($day.data('date'));


        // باز کردن
        $overlay
            .stop(true, true)
            .fadeIn(180);

    });

    // ==========================================
    // Add item from Day Overlay
    // ==========================================

    $(document).on('click', '#addDayItem', function (e) {

        e.preventDefault();

        const context = window.monthLogContext;

        if (!context) {
            console.error('Month log context not found');
            return;
        }

        resetInfoModal();

        // همه تب‌ها فعال
        $('#myTab button')
        .removeClass('disabled')
        .attr('disabled', false);
    
        // آماده‌سازی CKEditor قبل از باز شدن Modal
        createCKEditor('#description1', '');
        createCKEditor('#description2', '');
        
        // باز کردن Modal
        $('#infoModal').modal('show');
    });

    // ==========================================
    // Close Day Overlay
    // ==========================================

    $(document).on('click', '#closeDayDetails', function () {

        $('#dayDetailsOverlay')
            .stop(true, true)
            .fadeOut(150);

        window.monthLogContext = null;

    });


    // ==========================================
    // Modal OPEN
    // ==========================================

    $('#infoModal').on('shown.bs.modal', function () {

        const context = window.monthLogContext;
    
        if (!context) {
            return;
        }
    
        const $noteDate = $('#note_log_date');
        const $taskDate = $('#task_log_date');
        const $eventStart = $('[name="start"]');
        const $eventEnd = $('[name="end"]');
    
        /*
        |--------------------------------------------------------------------------
        | Note / Task
        |--------------------------------------------------------------------------
        | تاریخ فقط نمایشی است
        */
    
        $noteDate
            .removeAttr('data-jdp')
            .removeAttr('data-jdp-only-date')
            .prop('readonly', true);
    
        $taskDate
            .removeAttr('data-jdp')
            .removeAttr('data-jdp-only-date')
            .prop('readonly', true);
    
    
        /*
        |--------------------------------------------------------------------------
        | Event
        |--------------------------------------------------------------------------
        | Datepicker فعال می‌ماند
        */
    
        $eventStart
            .attr('data-jdp', 'data-jdp')
            .attr('data-jdp-only-date', 'data-jdp-only-date')
            .prop('readonly', false);
    
        $eventEnd
            .attr('data-jdp', 'data-jdp')
            .attr('data-jdp-only-date', 'data-jdp-only-date')
            .prop('readonly', false);
    
    
        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        | فقط هنگام ایجاد، روز انتخاب‌شده را پیش‌فرض کن
        */
    
        if (
            !$('#note_id').val() &&
            !$('#task_id').val() &&
            !$('#event_id').val()
        ) {
    
            convertToShamsi(context.date)
                .done(function (data) {
    
                    const shamsiDate =
                        data.covertMiladiToShansi;
    
                    $noteDate.val(shamsiDate);
                    $taskDate.val(shamsiDate);
    
                    $eventStart.val(shamsiDate);
                    $eventEnd.val(shamsiDate);
    
                })
                .fail(function (xhr) {
    
                    console.error(
                        'خطا در تبدیل تاریخ Month Log:',
                        xhr.responseText
                    );
    
                });
        }
    
    });


    // ==========================================
    // Modal CLOSE
    // ==========================================

    $('#infoModal').on('hidden.bs.modal', function () {

        // پاک کردن Editorها

        createCKEditor('#description1', '');
        createCKEditor('#description2', '');

        // پاک کردن تاریخ‌ها

        const $dates = $('#note_log_date, #task_log_date, #start, #end');

        $dates
            .val('')
            .prop('readonly', false)
            .attr('data-jdp', 'data-jdp')
            .attr('data-jdp-only-date', 'data-jdp-only-date');

        // پاک کردن IDها
        $('#note_id, #task_id, #event_id').val('');
    });
  
    // ==============================
    // Save / Create / Update Task
    // ==============================
    $(document).on('click', '#saveTask', function (e) {

        e.preventDefault();

        const context = window.monthLogContext;

        if (!context) {
            console.error('Month log context not found');
            return;
        }

        const formTask = $('.formTask').serializeArray();

        // CKEditor
        const description = getCKEditorData('#description2');
        
        $.each(formTask, function () {
            if (this.name === 'description') {
                this.value = description;
            }
        });

        // collection
        formTask.push({
            name: 'collection_id',
            value: context.collectionId
        });
        
        // ======================================
        // Save / Update Task
        // ======================================
    
        saveTask(formTask)
    
            .done(async function (response) {
    
                console.log('TASK SAVED:', response);
    
                // ==================================
                // Reset Form
                // ==================================
    
                $('.default-form-class').trigger('reset');
    
                await createCKEditor(
                    '#description2',
                    ''
                );
    
                // ==================================
                // Close Modal
                // ==================================
    
                $('#infoModal').modal('hide');
    
                // ==================================
                // Refresh Day Overlay
                // ==================================
    
                loadDayData(context.date);
            })
            .fail(function (xhr, status, error) {
                console.error(
                    'خطا در ذخیره Task:',
                    xhr.responseText
                );
            });
    });

    // ==========================================
    // Delete Task From Day Overlay
    // ==========================================

    $(document).on('click', '.delete-task', function(e){

        e.preventDefault();


        const taskId = $(this).data('id');


        if(!confirm('وظیفه حذف شود؟')) {
            return;
        }

        deleteTask(taskId)

        .done(function(){

            console.log('Task deleted');


            loadDayData(
                window.monthLogContext.date
            );

        })

        .fail(function(xhr){

            console.error(
                'خطا در حذف تسک:',
                xhr.responseText
            );

        });

    });

    // ==========================================
    // Save Note (Month Log)
    // ==========================================

    $(document).on('click', '#saveNode', function (e) {

        e.preventDefault();
    
        const context = window.monthLogContext;
    
        if (!context) {
            console.error('Month log context not found');
            return;
        }
    
        const formNode = $('.formNode').serializeArray();
    
        // ======================================
        // CKEditor
        // ======================================
    
        const description = getCKEditorData('#description1');
    
        $.each(formNode, function () {
    
            if (this.name === 'description') {
                this.value = description;
            }
    
        });
    
        // ======================================
        // Collection
        // ======================================
    
        formNode.push({
            name: 'collection_id',
            value: context.collectionId
        });
    
        // ======================================
        // Save Note
        // ======================================
    
        saveNote(formNode)
    
            .done(async function (data) {
    
                console.log('NOTE SAVED:', data);
    
                // ==================================
                // Reset Form
                // ==================================
    
                $('.default-form-class').trigger('reset');
    
                await createCKEditor(
                    '#description1',
                    ''
                );
    
                // ==================================
                // بستن Modal
                // ==================================
    
                $('#infoModal').modal('hide');
    
                // ==================================
                // تازه‌سازی اطلاعات روز
                // ==================================
    
                loadDayData(context.date);
    
            })
    
            .fail(function (xhr, status, error) {
    
                console.error(
                    'خطا در ذخیره یادداشت:',
                    xhr.responseText
                );
    
            });
    
    });

        // ==========================================
        // Delete Note From Day Overlay
        // ==========================================

        $(document).on('click', '.delete-note', function(e) {

            e.preventDefault();

            const noteId = $(this).data('id');

            if (!confirm('یادداشت حذف شود؟')) {
                return;
            }

            deleteNote(noteId)

                .done(function() {

                    console.log('Note deleted');

                    loadDayData(
                        window.monthLogContext.date
                    );

                })

                .fail(function(xhr) {

                    console.error(
                        'خطا در حذف یادداشت:',
                        xhr.responseText
                    );

                });

        });
        // ==========================================
        // Save / Update Event - Month Log
        // ==========================================

        $(document).on('click', '#saveBtn', function (e) {

            e.preventDefault();

            const context = window.monthLogContext;
            console.log('MONTH CONTEXT:', context);
            if (!context) {
                console.error('Month log context not found');
                return;
            }

            const formData = $('.test').serializeArray();
            console.log('EVENT FORM:', formData);
            // ======================================
            // Collection
            // ======================================

            formData.push({
                name: 'col_id',
                value: context.collectionId
            });


        // ======================================
        // Save / Update
        // ======================================

        saveEvent(formData)

            .done(async function (data) {
                console.log('EVENT SAVED:', data);
                // ==================================
                // Reset Form
                // ==================================

                $('.default-form-class').trigger('reset');

                // ==================================
                // Close Modal
                // ==================================

                $('#infoModal').modal('hide');

                // ==================================
                // Refresh Day Overlay
                // ==================================

                loadDayData(context.date);

            })

            .fail(function (xhr, status, error) {

                console.error('خطا در ذخیره رویداد');
                console.error('STATUS:', status);
                console.error('ERROR:', error);
                console.error('RESPONSE:', xhr.responseText);

            });
    });

    // ==========================================
    // Delete Event From Day Overlay
    // ==========================================

    $(document).on('click', '.delete-event', function(e) {

        e.preventDefault();

        const eventId = $(this).data('event-id');

        if (!confirm('رویداد حذف شود؟')) {
            return;
        }

        deleteEvent(eventId)

            .done(function() {

                console.log('Event deleted');

                loadDayData(
                    window.monthLogContext.date
                );

            })

            .fail(function(xhr) {

                console.error(
                    'خطا در حذف رویداد:',
                    xhr.responseText
                );

            });

    });


    function renderDayOverlayData(data)
    {

        $('#dayTasks').empty();
        $('#dayNotes').empty();
        $('#dayEvents').empty();

        // Tasks

        if(data.tasks.length){

            data.tasks.forEach(function (task) {

                const taskInfo = encodeURIComponent(
                    JSON.stringify({
                        id: task.id,
                        title: task.title,
                        description: task.description ?? '',
                        log_date: task.log_date
                    })
                );

                $('#dayTasks').append(`

                    <div class="day-item" data-id="${task.id}">

                        <div class="day-item-title">
                            ${task.title}
                        </div>

                        ${task.description ? `
                            <div class="day-item-description">
                                ${task.description}
                            </div>
                        ` : ''}
                        

                        <div class="day-actions">

                            <button
                                type="button"
                                class="futurelogInfoEditModal"
                                data-task-info="${taskInfo}"
                                data-bs-toggle="modal"
                                data-bs-target="#infoModal">

                                ✏️

                            </button>
                    
                            <button
                                type="button"
                                class="delete-task"
                                data-id="${task.id}">

                                🗑

                            </button>

                        </div>

                    </div>

                `);

            });

        } else {

            $('#dayTasks').html(`
                <div class="day-item">
                    فعلاً اطلاعاتی وجود ندارد
                </div>
            `);

        }


        // Notes

        if(data.notes.length){

            data.notes.forEach(function(note){
                const noteInfo = encodeURIComponent(
                    JSON.stringify({
                        id: note.id,
                        title: note.title,
                        description: note.description ?? '',
                        log_date: note.log_date
                    })
                );

                $('#dayNotes').append(`
                    <div class="day-item" data-id="${note.id}">
            
                        <span>
                            ${note.title}
                        </span>
            
                        ${note.description ? `
                            <div class="day-item-description">
                                ${note.description}
                            </div>
                        ` : ''}
                        

                        <div class="day-actions">
            
                            <button
                                type="button"
                                class="futurelogInfoEditModal"
                                data-note-info="${noteInfo}"
                                data-bs-toggle="modal"
                                data-bs-target="#infoModal">
                                ✏️
                            </button>
            
                            <button
                                type="button"
                                class="delete-note"
                                data-id="${note.id}">
                                🗑
                            </button>
            
                        </div>
            
                    </div>
                `);
            });

        } else {

            $('#dayNotes').html(`
                <div class="day-item">
                    فعلاً اطلاعاتی وجود ندارد
                </div>
            `);

        }

        // Events

        if(data.events.length){

            data.events.forEach(function(event){

                const eventInfo = encodeURIComponent(
                    JSON.stringify({
                        id: event.id,
                        title: event.title,
                        start: event.start,
                        end: event.end
                    })
                );
                
                $('#dayEvents').append(`
                    <div class="day-item" data-id="${event.id}">
            
                        <span>
                            ${event.title}
                        </span>

                        <div class="day-actions">
            
                            <button

                                type="button"
                                class="btn btn-sm btn-info futurelogInfoEditModal"
                                data-event-info="${eventInfo}"
                                data-bs-toggle="modal"
                                data-bs-target="#infoModal">

                                ✏️

                            </button>
                
                            <button

                                type="button"
                                class="delete-event"
                                data-event-id="${event.id}">

                                🗑

                            </button>

                        </div>
            
                    </div>
                `);
            
            });
        } else {

            $('#dayEvents').html(`
                <div class="day-item">
                    فعلاً اطلاعاتی وجود ندارد
                </div>
            `);

        }

    }


    function loadDayData(date)
    {
        const context = window.monthLogContext;

        if (!context) {
            return;
        }

        $.get(window.monthLogDayDataUrl, {

            collection_id: context.collectionId,

            date: date,

            year: window.monthLogYear,

            month: window.monthLogMonth

        })

        .done(function(data) {

            renderDayOverlayData(data);
        
            // بروزرسانی خلاصه کارت روز
            const $day = $('.month-day[data-date="' + date + '"]');
        
            if ($day.length) {
        
                const allItems = [
                    ...data.tasks.map(function (task) {
                        return {
                            title: task.title,
                            type: 'task'
                        };
                    }),
        
                    ...data.events.map(function (event) {
                        return {
                            title: event.title,
                            type: 'event'
                        };
                    }),
        
                    ...data.notes.map(function (note) {
                        return {
                            title: note.title,
                            type: 'note'
                        };
                    })
                ];
        
                const visibleItems = allItems.slice(0, 3);
                const remainingItems =
                    allItems.length - visibleItems.length;
        
                let html = '';
        
                if (visibleItems.length) {
        
                    html += '<span class="day-items">';
        
                    visibleItems.forEach(function (item) {
        
                        let symbol = '-';
        
                        if (item.type === 'task') {
                            symbol = '•';
                        } else if (item.type === 'event') {
                            symbol = '○';
                        }
        
                        html += `
                            <span class="day-item-title">
                                ${symbol} ${item.title}
                            </span>
                        `;
                    });
        
                    if (remainingItems > 0) {
                        html += `
                            <span class="day-more">
                                + ${remainingItems} مورد دیگر...
                            </span>
                        `;
                    }
        
                    html += '</span>';
                }
        
                $day.find('.day-items').remove();
        
                if (html) {
                    $day.append(html);
                }
            }
        
        })

        .fail(function(xhr) {

            console.error(
                'خطا در بروزرسانی پنل:',
                xhr.responseText
            );

        });
    }

    $(document).on('click', '#openMonthSidebar', function () {
        $('.month-log-layout').removeClass('sidebar-closed');
    });
    
    $(document).on('click', '#closeMonthSidebar', function () {
        $('.month-log-layout').addClass('sidebar-closed');
    });
});
