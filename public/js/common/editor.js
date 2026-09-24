const editors = {};

function createCKEditor(elementId, val = '') {

    if (editors[elementId]) {
        editors[elementId].setData(val ?? '');
        return Promise.resolve(editors[elementId]);
    }

    return ClassicEditor
        .create(document.querySelector(elementId))
        .then(function (editor) {

            editors[elementId] = editor;

            editor.setData(val ?? '');

            return editor;
        })
        .catch(function (error) {

            console.error('CKEditor error:', error);

            throw error;
        });
}

function getCKEditorData(elementId) {

    if (!editors[elementId]) {
        console.error('CKEditor not found:', elementId);
        return '';
    }

    return editors[elementId].getData();
}


function resetCKEditors() {

    Object.keys(editors).forEach(function (elementId) {
        editors[elementId].setData('');
    });
}