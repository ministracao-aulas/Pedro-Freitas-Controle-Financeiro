class PagePreferences {
    static validSidebarMode = (mode) => {
        return mode && [
            'expand', 'retract'
        ].includes(mode);
    }

    static setSidebarMode = (mode) => {
        mode = (!this.validSidebarMode(mode)) ? 'retract' : mode;

        localStorage.setItem('sidebarMode', mode);
    }

    static getSidebarMode = (defaultValue = null) => {
        let mode = localStorage.getItem('sidebarMode');
        defaultValue = this.validSidebarMode(defaultValue) ? defaultValue : 'retract';

        return mode && this.validSidebarMode(mode) ? mode : defaultValue;
    }

    static setSidebarMode = (mode) => {
        if (!this.validSidebarMode(mode)) {
            return;
        }

        if (mode == 'retract') {
            document.body.classList.add('sidebar-toggled');
            document.querySelectorAll('.sidebar').forEach(el => el.classList.add('toggled'));
            return;
        }

        document.body.classList.remove('sidebar-toggled');
        document.querySelectorAll('.sidebar').forEach(el => el.classList.remove('toggled'));
    }

    static loadPreferences() {
        this.setSidebarMode(this.getSidebarMode('retract'));
    }
}

window.page_preferences = PagePreferences;

window.addEventListener('load', () => {
    window.page_preferences.loadPreferences();
});
