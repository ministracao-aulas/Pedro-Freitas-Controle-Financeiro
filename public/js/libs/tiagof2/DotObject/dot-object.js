var DotObject = {
    get: (notation, object) => {
        try {
            let keys = notation.split('.')

            let result = {
                ...object
            };

            keys.forEach(key => {
                if (!result) {
                    return
                }

                result = result[`${key}`]
            })

            return result
        } catch (err) {
            return null
        }
    }
}

/*
    Usage:

    data = {
        "a": {
            "b": {
                "z": "beee",
                "emails": [
                    "em1@dd.com",
                    "em2@dd.com"
                ]
            }
        }
    }

    DotObject.get('a.b.emails', data) // Array [ "em1@dd.com", "em2@dd.com" ]
    DotObject.get('a.b.emails.0', data) // "em1@dd.com"
    DotObject.get('a.b.emails.1', data) // "em2@dd.com"
    DotObject.get('a.b.emails.2', data) // null
*/

// export default DotObject
