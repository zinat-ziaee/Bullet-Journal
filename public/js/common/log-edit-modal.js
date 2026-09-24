// ==========================================
// Edit Task / Note / Event
// Shared between Future Log / Month Log / Day Log
// ==========================================

$(document).on('click', '.futurelogInfoEditModal', async function (e) {

    e.preventDefault();
    
    // ==========================================
    // EVENT
    // ==========================================

    const eventInfo = $(this).attr('data-event-info');

    if (eventInfo) {

        const data = JSON.parse(
            decodeURIComponent(
                eventInfo.replace(/\+/g, '%20')
            )
        );

        $('#event #event_id').val(data.id);
        $('#event #title').val(data.title);

        if (data.start) {

            const start = await convertToShamsi(data.start);

            $('#event #start').val(
                start.covertMiladiToShansi
            );

        } else {

            $('#event #start').val('');
        }


        if (data.end) {

            const end = await convertToShamsi(data.end);

            $('#event #end').val(
                end.covertMiladiToShansi
            );

        } else {

            $('#event #end').val('');
        }


        activaTab('#event');

        return;
    }


    // ==========================================
    // NOTE
    // ==========================================

    const noteInfo = $(this).attr('data-note-info');

    if (noteInfo) {

        const data = JSON.parse(
            decodeURIComponent(
                noteInfo.replace(/\+/g, '%20')
            )
        );

        $('#note #note_id').val(data.id);
        $('#note #title').val(data.title);

        if (data.log_date) {

            const date = await convertToShamsi(
                data.log_date
            );

            $('#note #note_log_date').val(
                date.covertMiladiToShansi
            );

        } else {

            $('#note #note_log_date').val('');
        }

        await createCKEditor(
            '#description1',
            data.description ?? ''
        );
        
        activaTab('#note');

        return;
    }


    // ==========================================
    // TASK
    // ==========================================

    const taskInfo = $(this).attr('data-task-info');

    if (taskInfo) {

        const data = JSON.parse(
            decodeURIComponent(
                taskInfo.replace(/\+/g, '%20')
            )
        );

        $('#task #task_id').val(data.id);
        $('#task #title').val(data.title);


        await createCKEditor(
            '#description2',
            data.description ?? ''
        );


        if (data.log_date) {

            const date = await convertToShamsi(
                data.log_date
            );

            $('#task #task_log_date').val(
                date.covertMiladiToShansi
            );

        } else {

            $('#task #task_log_date').val('');
        }


        activaTab('#task');

        return;
    }

});