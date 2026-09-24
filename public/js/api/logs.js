function deleteEvent(eventId) {
    return $.ajax({
        url: 'events/' + eventId,
        type: 'DELETE'
    });
}

function deleteNote(noteId) {
    return $.ajax({
        url: 'notes/' + noteId,
        type: 'DELETE',
        data: noteId
    });
}

function deleteTask(taskId) {
    return $.ajax({
        url: 'tasks/' + taskId,
        type: 'DELETE',
        data: taskId
    });
}

function saveEvent(formData) {
    return $.ajax({
        url: '/events',
        type: 'POST',
        data: formData,
        dataType: 'json'
    });
}

function saveNote(formData) {
    return $.ajax({
        url: '/notes',
        type: 'POST',
        data: formData,
        dataType: 'json'
    });
}

function saveTask(formData) {
    return $.ajax({
        url: '/tasks',
        type: 'POST',
        data: formData,
        dataType: 'json'
    });
}