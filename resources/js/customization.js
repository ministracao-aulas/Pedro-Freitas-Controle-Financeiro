import PagePreferences from '@resources/js/src/PagePreferences/';

window.PagePreferences = PagePreferences;
window.__preferences = new PagePreferences();

if (window.__preferences && ('callStatic' in window.__preferences)) {
    window.__preferences.callStatic('loadPreferences');
    window.__preferences.callStatic('removeShowOnToggled');
    window.removeShowOnToggled = (event, element) => {
        window.counter = window.counter ?? 0;
        console.log("fora", ++window.counter, element);
        window.__preferences.callStatic('removeShowOnToggled');
    };
}

document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('[data-parent="#accordionSidebar"].collapse.to_show_on_load')
    .forEach(el => {
        el.classList.remove('to_show_on_load');
        el.classList.add('show');
    });

    window.__preferences.callStatic('removeShowOnToggled');

    document.querySelectorAll('a[data-prevent-default-onclick="true"]').forEach(
        link => link.addEventListener('click', event => event.preventDefault(), false)
    )
});
