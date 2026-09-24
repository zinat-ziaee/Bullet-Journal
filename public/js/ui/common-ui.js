// ==========================================
// Tabs
// ==========================================

function activaTab(tab) {

    $("#infoModal .nav-link").addClass('disabled');

    $('#infoModal .nav-tabs button[data-bs-target="' + tab + '"]')
        .tab("show");

    $("#infoModal .nav-link")
        .filter('.active')
        .removeClass('disabled');

    return false;
}


// Reset Info Modal after closing

function resetInfoModal() {
    const $modal = $('#infoModal');

    $modal.find('form').each(function () {
        this.reset();
    });

    $modal.find('#event_id, #task_id, #note_id').val('');

    $modal.find('input, textarea, select').val('');

    $modal
        .find('input[type=checkbox], input[type=radio]')
        .prop('checked', false);


    // بعد از بستن مدال، تب‌ها دوباره فعال شوند
     
    $('#myTab button')
        .removeClass('active disabled')
        .attr('disabled', false);

    $('#myTabContent .tab-pane')
        .removeClass('show active');
        
    
    // پاک کردن CKEditor
    if (typeof resetCKEditors === 'function') {
        resetCKEditors();
    }
}



    