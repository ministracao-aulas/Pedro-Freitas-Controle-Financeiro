// New search values
var itemsOfParams = (params, asArray = false) => {
  let items = asArray ? [] : {};

  for (const [key, value] of params.entries()) {
    if (asArray) {
      items.push({key: key, value: value})
      continue;
    }

    items[key] = value
  }

  return items
}

// Update result
var updateList = () => {
  let changes = 0;
  let queryString = window.location.search;
  let parameters = new URLSearchParams(queryString);

  let searchInput = document.querySelector('[name="search"]')
  let searchInputValue = searchInput ? String(searchInput.value).trim() : null;
  let perPageInput = document.querySelector('[name="per_page"]')
  let perPageInputValue = perPageInput ? parseInt(perPageInput.value) : 10;

  let searchValueOnQuery = parameters.get('search')
  let perPageValueOnQuery = parameters.get('per_page')

  let isNewSearch = !searchValueOnQuery || (
    searchInputValue != searchValueOnQuery
  )

  let isNewPerPage = !perPageValueOnQuery || (
    perPageInputValue != perPageValueOnQuery
  )

  if (!searchInputValue && parameters.has('search')) {
    changes++;
    parameters.delete('search');
  }

  if (searchInputValue && isNewSearch) {
    changes++;
    parameters.set('search', String(searchInputValue))

    // Add new parameter (duplicate if exists)
    // parameters.append('search', searchInputValue)
  }

  if (perPageInputValue && isNewPerPage) {
    changes++;
    parameters.set('per_page', String(perPageInputValue))
  }

  if (!changes) {
    console.log('No changes')
    return;
  }

  // Update location/url/search
  window.location.search = parameters
}

var initSearch = (selector = '[name="search"]') => {
    if (!selector || (selector.constructor.name != 'String') || !String(selector).trim()) {
        return;
    }

    let searchInput = document.querySelector(selector);

    if (!searchInput) {
        return;
    }

    let runUpdateList = () => {
        if ('updateList' in window) {
            updateList()
        }
    }

    let callOnKey = (element, key, callable) => {
        if (!element || !key || !callable || !('addEventListener' in element)) {
            return;
        }

        element.addEventListener('keydown', e => {
            if ((e.key||e.keyCode) != key) {
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

                runUpdateList();
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
