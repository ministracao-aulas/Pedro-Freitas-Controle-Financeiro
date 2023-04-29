export const onClickOut = {
    add(element, callable) {
        try {
            if (!callable || callable.constructor.name !== 'Function') {
                console.log('callable:', callable);
                throw `Error: invalid [callable]`;
                return;
            }

            // void add new listener for 'click out'
            if (element.getAttribute('ibhash') == 'onClickOut.add-loaded') {
                console.log('Já foi adicionado ouvinte. Ignorando ouvinte.');
                return;
            }
        } catch (error) {
            console.error(error);
            return;
        }

        element.setAttribute('ibhash', 'onClickOut.add-loaded');

        document.body.addEventListener(
            'click', (event) => {
                let isTheSame = element === event.target;
                if (isTheSame) {
                    return;
                }

                callable(event, element);
            }
        );
    },

    loadAll() {
        document.querySelectorAll('[dz-on\\:click-out]')
            .forEach(element => {

                let functionName = element.getAttribute('dz-on\:click-out');
                if (!functionName) {
                    return;
                }

                let callable = window[functionName] ?? null;

                if (!callable) {
                    throw `Error: invalid callable [${functionName}]`
                }

                onClickOut.add(element, callable);
            })
    },
    init() {
        onClickOut.loadAll();
    },
    initOnLoad(afterLoad = 'dom') {
        let validValues = [
            'dom',
            'window',
        ];

        try {
            if (!validValues.includes(afterLoad)) {
                console.log('afterLoad:', afterLoad);
                throw new Error('');
            }
        } catch (error) {
            throw `Error: invalid initHandler afterLoad. Valid values: ${validValues.join(',')}`;
        }

        if (afterLoad === 'dom') {
            document.addEventListener('DOMContentLoaded', () => onClickOut.loadAll());

            return;
        }

        window.addEventListener('load', () => onClickOut.loadAll());
    }
}
