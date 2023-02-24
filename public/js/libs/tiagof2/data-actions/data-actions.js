let checkIfTypeCheckerIsLoaded = () => {
    if (!window.TypeChecker) {
        throw new Error("'TypeChecker' must be loaded before 'data-actions'")
    }

    return true
}

let callAction = (element) => {
    checkIfTypeCheckerIsLoaded()

    if (!element || element.tagName === "") {
        return;
    }

    let actionName = element.dataset.actionName
    let actionType = element.dataset.actionType  //="trigger"

    if (!actionName || !actionType || actionType != 'trigger') {
        return;
    }

    let actionObjectContainerName = element.dataset.actionObjectContainer

    let actionObjectContainer = window[actionObjectContainerName] || window

    let actionCaller = (() => {
        try {
            if (!(actionName in actionObjectContainer)) {
                console.error(
                    `The action '${actionName}' do not exists in action container ` +
                    `'${element.dataset.actionObjectContainer}'`
                )

                return null
            }

            return actionObjectContainer[actionName]

        } catch (error) {
            console.error(error)
            return null
        }
    })()

    if (!TypeChecker.typeIs(actionCaller, 'Function')) {
        console.error(`Invalid 'actionCaller'.`, actionCaller)
        return
    }

    //TODO disparar o evento com esse nome e os dados abaixo
    let actionEventName = element.dataset.actionEventName

    let actionInfo = element.dataset.actionInfo

    // TODO validar aqui se o 'actionInfo' é do tipo informado
    let actionInfoType = element.dataset.actionInfoType

    if (!actionInfo) {
        return actionCaller()
    }

    return actionCaller(actionInfo)
}

window.addEventListener('load', (event) => {
    checkIfTypeCheckerIsLoaded()

    document.querySelectorAll('button[data-action-type="trigger"][data-action-name]')
        .forEach(actionElement => {
            actionElement.addEventListener('click', event => {
                event.stopPropagation()
                callAction(event.target)
            }, true)
        })
});
