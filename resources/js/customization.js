import PagePreferences from '@resources/js/src/PagePreferences/';

window.PagePreferences = PagePreferences;
window.__preferences = new PagePreferences();

if (window.__preferences && ('callStatic' in window.__preferences)) {
    window.__preferences.callStatic('loadPreferences');
}
