$(function () {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    window.monthLogContext = null;
    
    initJalaliDatePicker();

    $(document).on('click', '.month-day', function () {

        window.monthLogContext = {
            collectionId: $(this).data('collection-id'),
            date: $(this).data('date'),
            day: $(this).data('day')
        };

        $('#note_id, #event_id, #task_id').val('');

        $('#note input[name="title"], #task input[name="title"], #event input[name="title"]').val('');

        $('#note textarea[name="description"], #task textarea[name="description"]').val('');

        $('#event input[name="start"], #event input[name="end"]').val('');

        $('#infoModal').modal('show');
    });

    $('#infoModal').on('shown.bs.modal', function () {

        const context = window.monthLogContext;

        if (!context) return;

        const $dates = $('#note_log_date, #task_log_date');
        // در ماه‌نگار این دو فیلد نباید DatePicker داشته باشند
        $dates
        .removeAttr('data-jdp')
        .removeAttr('data-jdp-only-date')
        .prop('readonly', true);

        convertToShamsi(context.date).done(function (data) {

            const shamsiDate = data.covertMiladiToShansi;

            $dates.val(shamsiDate);

        });
    });


    $('#infoModal').on('hidden.bs.modal', function () {

        window.monthLogContext = null;

        const $dates = $('#note_log_date, #task_log_date');

        $dates
            .val('')
            .prop('readonly', false)
            .attr('data-jdp', 'data-jdp')
            .attr('data-jdp-only-date', 'data-jdp-only-date');
    });

    function convertToShamsi(date) {

        return $.ajax({
            type: 'POST',
            data: {
                date: date
            },
            url: '/convert_to_shamsi',
            dataType: 'JSON'
        });

    }
  
});