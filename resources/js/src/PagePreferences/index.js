class PagePreferences {
    static validSidebarMode = (mode) => {
        return mode && [
            'expand', 'retract'
        ].includes(mode);
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

        localStorage.setItem('sidebarMode', mode);

        if (mode == 'retract') {
            document.body.classList.add('sidebar-toggled');
            document.querySelectorAll('.sidebar').forEach(el => el.classList.add('toggled'));
            return;
        }

        document.body.classList.remove('sidebar-toggled');
        document.querySelectorAll('.sidebar').forEach(el => el.classList.remove('toggled'));
    }

    static toggleSidebarMode = () => {
        let currentMode = this.getSidebarMode('expand');

        let newMode = currentMode == 'expand' ? 'retract' : 'expand';

        this.setSidebarMode(newMode);
    }

    static loadPreferences() {
        this.setSidebarMode(this.getSidebarMode('retract'));
    }

    callStatic(staticMethod, ...params) {
        if (!staticMethod || (staticMethod?.constructor?.name != 'String') || !(staticMethod in PagePreferences)) {
          console.log('Error on "staticMethod"', staticMethod);
          return;
        }

        return PagePreferences[staticMethod](...params);
    }
}

export default PagePreferences
