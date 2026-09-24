document.addEventListener('DOMContentLoaded', function () {

    const layout = document.querySelector('.app-layout');
    const toggle = document.getElementById('sidebarToggle');

    if (!layout || !toggle) {
        return;
    }

    toggle.addEventListener('click', function () {
        layout.classList.toggle('sidebar-collapsed');
    });

});