$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN':
            $('meta[name="csrf-token"]').attr('content')
    }
});

function convertToShamsi(date) {

    return $.ajax({
        url: '/convert_to_shamsi',
        type: 'POST',
        data: {
            date: date
        }
    });

}
