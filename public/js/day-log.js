$(document).ready(function () {
    initJalaliDatePicker();

    const context = window.dayLogContext;

    if (!context || !context.date) {
        console.error('dayLogContext not found.');
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    let activeTimer = null;


    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    
    function formatTime(value) {

        if (!value) {
            return '';
        }

        const date = new Date(value);

        if (isNaN(date.getTime())) {
            return '';
        }

        return date.toLocaleTimeString('fa-IR', {
            hour: '2-digit',
            minute: '2-digit'
        });
    }


    function getDayName(dateString) {

        const date = new Date(
            dateString + 'T00:00:00'
        );

        const days = [
            'یکشنبه',
            'دوشنبه',
            'سه‌شنبه',
            'چهارشنبه',
            'پنجشنبه',
            'جمعه',
            'شنبه'
        ];

        return days[date.getDay()];
    }


    function changeDate(dateString, numberOfDays) {

        const parts = dateString.split('-');
    
        const date = new Date(
            Number(parts[0]),
            Number(parts[1]) - 1,
            Number(parts[2])
        );
    
        date.setDate(
            date.getDate() + numberOfDays
        );
    
        const year = date.getFullYear();
        const month = String(
            date.getMonth() + 1
        ).padStart(2, '0');
    
        const day = String(
            date.getDate()
        ).padStart(2, '0');
    
        return `${year}-${month}-${day}`;
    }

    /*
    |--------------------------------------------------------------------------
    | Header
    |--------------------------------------------------------------------------
    */

    function updateDayHeader() {

        if (typeof convertToShamsi !== 'function') {
            console.error('convertToShamsi is not available');
            return;
        }
    
        $('#dayOfWeek').text(
            getDayName(context.date)
        );
    
        convertToShamsi(context.date)
    
            .done(function (data) {
    
                $('#dayLogTitle').text(
                    data.covertMiladiToShansi
                );
    
            })
    
            .fail(function (xhr) {
    
                console.error(
                    'convertToShamsi failed:',
                    xhr.status,
                    xhr.responseText
                );
    
            });
    }

    $(document).on('click', '#dayLogCreate', function () {

        resetInfoModal();
    
        $('#myTab button')
            .removeClass('active disabled')
            .attr('disabled', false);
    
        createCKEditor('#description1', '');
        createCKEditor('#description2', '');
    });

    /*
    |--------------------------------------------------------------------------
    | Modal
    |--------------------------------------------------------------------------
    */

    $('#infoModal').on('shown.bs.modal', function () {

        const context = window.dayLogContext;
    
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
        */
    
        if (
            !$('#note_id').val() &&
            !$('#task_id').val() &&
            !$('#event_id').val()
        ) {
    
            setTimeout(function () {
    
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
                            'خطا در تبدیل تاریخ Day Log:',
                            xhr.responseText
                        );
    
                    });
    
            }, 0);
        }
    
    });

    $('#infoModal').on(
        'hidden.bs.modal',
        function () {
            resetInfoModal();
        }
    );

    $(document).on('click', '.delete-task', function (e) {

        e.preventDefault();
    
        const taskId = $(this).data('id');
    
        if (!taskId) {
            return;
        }
    
        if (!confirm('این وظیفه حذف شود؟')) {
            return;
        }
    
        deleteTask(taskId)
            .done(function () {
    
                loadDay(context.date);
    
            })
            .fail(function (xhr) {
    
                console.error(
                    'خطا در حذف وظیفه:',
                    xhr.responseText
                );
    
            });
    
    });

    $(document).on('click', '.delete-note', function (e) {

        e.preventDefault();
    
        const noteId = $(this).data('id');
    
        if (!noteId) {
            return;
        }
    
        if (!confirm('این یادداشت حذف شود؟')) {
            return;
        }
    
        deleteNote(noteId)
            .done(function () {
    
                loadDay(context.date);
    
            })
            .fail(function (xhr) {
    
                console.error(
                    'خطا در حذف یادداشت:',
                    xhr.responseText
                );
    
            });
    
    });

    $(document).on('click', '.delete-event', function (e) {

        e.preventDefault();
    
        const eventId = $(this).data('event-id');
    
        if (!eventId) {
            return;
        }
    
        if (!confirm('این رویداد حذف شود؟')) {
            return;
        }
    
        deleteEvent(eventId)
            .done(function () {
    
                loadDay(context.date);
    
            })
            .fail(function (xhr) {
    
                console.error(
                    'خطا در حذف رویداد:',
                    xhr.responseText
                );
    
            });
    
    });

    /*
    |--------------------------------------------------------------------------
    | Render Day
    |--------------------------------------------------------------------------
    */

    function renderDay(data) {

        let html = '';


        /*
        | Events
        */

        data.events.forEach(function (event) {

            const eventInfo = encodeURIComponent(
                JSON.stringify({
                    id: event.id,
                    title: event.title,
                    start: event.start,
                    end: event.end
                })
            );
            
            
            html += `
                <div class="journal-item event">
            
                    <span class="journal-symbol">
                        ○
                    </span>
            
                    <div class="journal-content">
            
                        <div class="journal-main">
            
                            <div class="journal-title">
                                ${event.title}
                            </div>
            
                            <small class="journal-time">
                                ${formatTime(event.start)}
                            </small>
            
                        </div>
            
                        <div class="journal-actions">
            
                            <button
                                type="button"
                                class="journal-action edit futurelogInfoEditModal"
                                data-event-info="${eventInfo}"
                                data-bs-toggle="modal"
                                data-bs-target="#infoModal"
                                title="ویرایش">
                                ✏️
                            </button>
            
                            <button
                                type="button"
                                class="journal-action delete delete-event"
                                data-event-id="${event.id}"
                                title="حذف">
                                🗑
                            </button>
            
                        </div>
            
                    </div>
            
                </div>
            `;

        });


        /*
        | Tasks
        */

        data.tasks.forEach(function (task) {

            const taskInfo = encodeURIComponent(
                JSON.stringify({
                    id: task.id,
                    title: task.title,
                    description: task.description ?? '',
                    log_date: task.log_date
                })
            );
            
            const symbol = task.completed
                ? '✓'
                : '□';
            
            
            html += `
                <div class="journal-item task">
            
                    <span class="journal-symbol">
                        ${symbol}
                    </span>
            
                    <div class="journal-content">
            
                        <div class="journal-main">
            
                            <div class="journal-title">
                                ${task.title}
                            </div>

                            ${
                                task.description
                                    ? `
                                        <div class="journal-description">
                                            ${task.description}
                                        </div>
                                    `
                                    : ''
                            }
                        </div>
            
            
                        <div class="journal-actions">
            
                            <button
                                type="button"
                                class="journal-action edit futurelogInfoEditModal"
                                data-task-info="${taskInfo}"
                                data-bs-toggle="modal"
                                data-bs-target="#infoModal"
                                title="ویرایش">
                                ✏️
                            </button>
            
                            <button
                                type="button"
                                class="journal-action delete delete-task"
                                data-id="${task.id}"
                                title="حذف">
                                🗑
                            </button>
            
                            <button
                                type="button"
                                class="task-timer"
                                data-task-id="${task.id}"
                                title="شروع زمان‌سنج">
                                ▶
                            </button>
            
                        </div>
            
                    </div>
            
                </div>
            `;
        
        });


        /*
        | Notes
        */

        data.notes.forEach(function (note) {

            const noteInfo = encodeURIComponent(
                JSON.stringify({
                    id: note.id,
                    title: note.title,
                    description: note.description ?? '',
                    log_date: note.log_date
                })
            );
            
            
            html += `
                <div class="journal-item note">
            
                    <span class="journal-symbol">
                        •
                    </span>
            
                    <div class="journal-content">
            
                        <div class="journal-main">
            
                            <div class="journal-title">
                                ${note.title}
                            </div>
            
                            ${
                                note.description
                                    ? `
                                        <div class="journal-description">
                                            ${note.description}
                                        </div>
                                    `
                                    : ''
                            }
                        </div>
            
            
                        <div class="journal-actions">
            
                            <button
                                type="button"
                                class="journal-action edit futurelogInfoEditModal"
                                data-note-info="${noteInfo}"
                                data-bs-toggle="modal"
                                data-bs-target="#infoModal"
                                title="ویرایش">
                                ✏️
                            </button>
            
                            <button
                                type="button"
                                class="journal-action delete delete-note"
                                data-id="${note.id}"
                                title="حذف">
                                🗑
                            </button>
            
                        </div>
            
                    </div>
            
                </div>
            `;
        });


        /*
        | Empty
        */

        if (
            data.events.length === 0 &&
            data.tasks.length === 0 &&
            data.notes.length === 0
        ) {

            html = `

                <div class="day-log-empty">
                    امروز هنوز چیزی ثبت نشده.
                </div>

            `;
        }


        $('#dayLogStream').html(html);
    }


    /*
    |--------------------------------------------------------------------------
    | Load Day
    |--------------------------------------------------------------------------
    */

    function loadDay(dateString) {

        $.get(
            context.dayDataUrl,
            {
                date: dateString
            }
        )

        .done(function (data) {

            context.date = data.date;

            updateDayHeader();

            renderDay(data);

        })

        .fail(function (xhr) {

            console.error(
                'خطا در دریافت اطلاعات روز:',
                xhr.responseText
            );

        });
    }


    /*
    |--------------------------------------------------------------------------
    | Save Task
    |--------------------------------------------------------------------------
    */

    $(document).on('click', '#saveTask', function (e) {

        e.preventDefault();

        const context = window.dayLogContext;

        if (!context) {
            console.error('Day Log context not found.');
            return;
        }


        const formTask =
            $('.formTask').serializeArray();


        const description =
            getCKEditorData('#description2');


        $.each(formTask, function () {

            if (this.name === 'description') {
                this.value = description;
            }

        });


        formTask.push({
            name: 'collection_id',
            value: context.collectionId
        });


        saveTask(formTask)

            .done(function (response) {

                console.log(
                    'DAY TASK SAVED:',
                    response
                );


                $('#infoModal').modal('hide');


                loadDay(context.date);

            })

            .fail(function (xhr) {

                console.error(
                    'خطا در ذخیره Task:',
                    xhr.responseText
                );

            });

    });


        /*
    |--------------------------------------------------------------------------
    | Save Note
    |--------------------------------------------------------------------------
    */

    $(document).on('click', '#saveNode', function (e) {

        e.preventDefault();

        const context = window.dayLogContext;

        if (!context) {
            console.error('Day Log context not found.');
            return;
        }


        const formNode =
            $('.formNode').serializeArray();


        const description =
            getCKEditorData('#description1');


        $.each(formNode, function () {

            if (this.name === 'description') {
                this.value = description;
            }

        });


        formNode.push({
            name: 'collection_id',
            value: context.collectionId
        });


        saveNote(formNode)

            .done(function (response) {

                console.log(
                    'DAY NOTE SAVED:',
                    response
                );


                $('#infoModal').modal('hide');


                loadDay(context.date);

            })

            .fail(function (xhr) {

                console.error(
                    'خطا در ذخیره Note:',
                    xhr.responseText
                );

            });

    });

    /*
    |--------------------------------------------------------------------------
    | Save Event
    |--------------------------------------------------------------------------
    */

    $(document).on('click', '#saveBtn', function (e) {

        e.preventDefault();

        const context = window.dayLogContext;

        if (!context) {
            console.error('Day Log context not found.');
            return;
        }


        const formData =
            $('.test').serializeArray();


        formData.push({
            name: 'col_id',
            value: context.collectionId
        });


        saveEvent(formData)

            .done(function (response) {

                console.log(
                    'DAY EVENT SAVED:',
                    response
                );


                $('#infoModal').modal('hide');


                loadDay(context.date);

            })

            .fail(function (xhr) {

                console.error(
                    'خطا در ذخیره Event:',
                    xhr.responseText
                );

            });

    });


    /*
    |--------------------------------------------------------------------------
    | Previous Day
    |--------------------------------------------------------------------------
    */


    $(document).on(
        'click',
        '#previousDay',
        function () {

            if (activeTimer) {
                stopTimer();
            }


            const newDate =
                changeDate(
                    context.date,
                    -1
                );


            loadDay(newDate);

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Next Day
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'click',
        '#nextDay',
        function () {

            if (activeTimer) {
                stopTimer();
            }


            const newDate =
                changeDate(
                    context.date,
                    1
                );


            loadDay(newDate);

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Task Timer
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'click',
        '.task-timer',
        function (e) {

            e.preventDefault();


            const $button =
                $(this);


            const taskId =
                $button.data('task-id');


            if (!taskId) {

                console.error(
                    'Task ID not found.'
                );

                return;
            }


            if (
                activeTimer &&
                activeTimer.taskId == taskId
            ) {

                stopTimer();

                return;
            }


            if (activeTimer) {
                stopTimer();
            }


            startTimer(
                taskId,
                $button
            );

        }
    );


    function startTimer(
        taskId,
        $button
    ) {

        activeTimer = {

            taskId: taskId,

            startedAt: Date.now(),

            button: $button,

            interval: null
        };


        $button
            .text('■')
            .addClass('active');


        activeTimer.interval =
            setInterval(function () {

                if (!activeTimer) {
                    return;
                }


                const elapsed =
                    Math.floor(
                        (
                            Date.now() -
                            activeTimer.startedAt
                        ) / 1000
                    );


                $button.text(
                    formatElapsed(elapsed)
                );

            }, 1000);

    }


    function stopTimer() {

        if (!activeTimer) {
            return;
        }


        const timer =
            activeTimer;


        const elapsed =
            Math.floor(
                (
                    Date.now() -
                    timer.startedAt
                ) / 1000
            );


        clearInterval(
            timer.interval
        );


        activeTimer = null;


        timer.button
            .text('▶')
            .removeClass('active');


        console.log(
            'Task:',
            timer.taskId,
            'Elapsed:',
            elapsed,
            'seconds'
        );

    }


    function formatElapsed(seconds) {

        const minutes =
            Math.floor(
                seconds / 60
            );


        const remainingSeconds =
            seconds % 60;


        return (
            String(minutes).padStart(2, '0') +
            ':' +
            String(remainingSeconds).padStart(2, '0')
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Initial Load
    |--------------------------------------------------------------------------
    */

    try {
        updateDayHeader();
        loadDay(context.date);
    } catch (error) {
        console.error('Day Log initial load error:', error);
    }


});