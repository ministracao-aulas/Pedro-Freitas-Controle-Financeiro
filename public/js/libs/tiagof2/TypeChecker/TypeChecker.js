var TypeChecker = (() => {
    let ucFirst = (word) => {
        if (!word || word.constructor.name != 'String') {
            return ''
        }

        let letters = (String(word)).split('')
        letters[0] = String(letters.at(0)).toUpperCase()
        return letters.join('')
    }

    let getTypeFromError = (errorMessage) => {
        // 'TypeError: XXX has no properties'
        try {
            errorMessage = String(errorMessage)

            if (errorMessage === '') {
                return 'EmptyString'
            }

            return (((errorMessage.split(' has no properties')).shift())
                .split(' ')).pop()

        } catch (error) {
            return 'UnknownType'
        }
    }

    let getType = (item) => {
        try {
            let type = (item).constructor.name

            return (type === 'Number') && isNaN(type) ? 'NaN' : type
        } catch (error) {
            return ucFirst(getTypeFromError(error))
        }
    }

    let firtLetterIsLower = (word) => {
        if (!word || word.constructor.name != 'String') {
            return false
        }

        let letters = (String(word)).split('')
        let firstLetter = String(letters.at(0))

        return firstLetter && (letters[0] === firstLetter.toLowerCase())
    }

    let typeIs = (item, itemTypeIs) => {
        if (getType(itemTypeIs) === "String") {
            if (firtLetterIsLower(itemTypeIs)) {
                return getType(item) === ucFirst(itemTypeIs)
            }

            return getType(item) === itemTypeIs
        }

        if (getType(itemTypeIs) === "Function") {
            let itemTypeIsAsString = String(itemTypeIs)
            let isNativeFunction = (itemTypeIsAsString).includes('native code')

            if (isNativeFunction) {
                return (item instanceof itemTypeIs)
            }

            return getType(item) === itemTypeIs
        }

        return getType(item) == getType(itemTypeIs)
    }

    let typeIsIn = (item, types = []) => {
        if (getType(types) != 'Array') {
            return false
        }

        return types.includes(getType(item))
    }

    return {
        ucFirst,
        getTypeFromError,
        getType,
        firtLetterIsLower,
        typeIs,
        typeIsIn
    }
})()
