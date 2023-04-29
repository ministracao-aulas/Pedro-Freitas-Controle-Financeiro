// New search values
var itemsOfParams = (params, asArray = false) => {
    let items = asArray ? [] : {};

    for (const [key, value] of params.entries()) {
        if (asArray) {
            items.push({ key: key, value: value })
            continue;
        }

        items[key] = value
    }

    return items
}

var incrementFilterChanges = () => {
    window.filter_changes = (window?.filter_changes || 0) + 1;
}

window.filterURLSearchParams = () => {
    if (!window?.filterParameters) {
        window.filterParameters = new URLSearchParams(window.location.search);
    }

    return window?.filterParameters || new URLSearchParams(window.location.search);
}


// Update result
var updateList = (element = null) => {
    window.filter_changes = window?.filter_changes || 0;

    let actionOnBypass = element ? element.dataset?.filterBypass : false;

    actionOnBypass = actionOnBypass && ['true', 'on', '1', true].includes(actionOnBypass)

    let searchInput = document.querySelector('[name="search"]')
    let searchInputValue = searchInput ? String(searchInput.value).trim() : null;
    let perPageInput = document.querySelector('[name="per_page"]')
    let perPageInputValue = perPageInput ? parseInt(perPageInput.value) : 10;

    let searchValueOnQuery = (window.filterURLSearchParams()).get('search')
    let perPageValueOnQuery = (window.filterURLSearchParams()).get('per_page')

    let isNewSearch = !searchValueOnQuery || (
        searchInputValue != searchValueOnQuery
    )

    let isNewPerPage = !perPageValueOnQuery || (
        perPageInputValue != perPageValueOnQuery
    )

    if (!searchInputValue && (window.filterURLSearchParams()).has('search')) {
        incrementFilterChanges();
        (window.filterURLSearchParams()).delete('search');
    }

    if (searchInputValue && isNewSearch) {
        incrementFilterChanges();
        (window.filterURLSearchParams()).set('search', String(searchInputValue))

        // Add new parameter (duplicate if exists)
        // (window.filterURLSearchParams()).append('search', searchInputValue)
    }

    if (element && !element?.value) {
        (window.filterURLSearchParams()).delete(element.getAttribute('name'));
        window.location.search = window.filterURLSearchParams()
        return;
    }

    if (perPageInputValue && isNewPerPage) {
        incrementFilterChanges();
        (window.filterURLSearchParams()).set('per_page', String(perPageInputValue))
    }

    if (!actionOnBypass && !(window?.filter_changes || 0)) {
        console.log('No changes', actionOnBypass)
        return;
    }

    // Update location/url/search
    window.location.search = window.filterURLSearchParams()
}

var initSearch = (selector = '[name="search"]') => {
    let filterByStatusInput = document.querySelector('[name="filter_by[status]"]');

    filterByStatusInput.addEventListener('change', (event) => {
        if (!event.target?.value) {
            (window.filterURLSearchParams()).delete('filter_by[status]')
            return;
        }

        (window.filterURLSearchParams()).set('filter_by[status]', String(event.target.value))
        incrementFilterChanges();
    });

    if (!selector || (selector.constructor.name != 'String') || !String(selector).trim()) {
        return;
    }

    let searchInput = document.querySelector(selector);

    if (!searchInput) {
        return;
    }

    let runUpdateList = (element = null) => {
        if ('updateList' in window) {
            updateList(element)
        }
    }

    let callOnKey = (element, key, callable) => {
        if (!element || !key || !callable || !('addEventListener' in element)) {
            return;
        }

        element.addEventListener('keydown', e => {
            if ((e.key || e.keyCode) != key) {
                return;
            }

            if (callable && callable.constructor.name == 'Function') {
                callable()
            }
        })
    }

    document.querySelectorAll('[data-filter-type="container"]')
        .forEach(container => {
            container.querySelectorAll('[data-filter-refresh-on]')
                .forEach(refreshCaller => {
                    let acceptedEvents = [
                        'click',
                        'change',
                        'key:Enter'
                    ];

                    let refreshOn = refreshCaller.dataset.filterRefreshOn;

                    if (!refreshOn || !(acceptedEvents.includes(refreshOn))) {
                        return
                    }

                    let isKeyAction = String(refreshOn).startsWith('key:');

                    let keyName = isKeyAction ? String(refreshOn).split(':')[1] : null;

                    let eventName = isKeyAction ? 'keydown' : refreshOn;

                    refreshCaller.addEventListener(eventName, e => {
                        if (isKeyAction && keyName) {
                            callOnKey(e.target, keyName, runUpdateList);
                            return;
                        }

                        runUpdateList(e.target);
                    })
                })
        })

    // searchInput.addEventListener('keydown', e => {
    //     if ((e.key||e.keyCode) != 'Enter') {
    //         return;
    //     }

    //     runUpdateList()
    // })
}
