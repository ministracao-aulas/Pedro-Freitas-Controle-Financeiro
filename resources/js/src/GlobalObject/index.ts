import _ from 'lodash';

const getGlobalAppData = (defaultData: object = {}) => {
    let window = globalThis;

    let globalAppData: object = window.__GlobalAppData || defaultData;

    return globalAppData
}

const loadGlobalAppData = (defaultData: object = {}) => {
    let window = globalThis;

    let globalAppData: object = window.__GlobalAppData || defaultData;

    window.__GlobalAppData = globalAppData;
}

const lang = (langRef: string, defaultValue: (null|string|object) = null): (null|string|object) => {
    try {
        defaultValue = defaultValue === null ? langRef : defaultValue;
        langRef = `lang.${langRef}`;
        let result: any = _.get(getGlobalAppData({}), langRef, defaultValue);

        if (!result || !(result.constructor && ['String', 'Object'].includes(result.constructor.name))) {
            return defaultValue;
        }

        return result || defaultValue;
    } catch (error) {
        return defaultValue;
    }
}

const toObject = (data: any): object => {
    try {
        console.log('data:', data);
        if (!data || !data.constructor || !(data.constructor.name != 'String')) {
            return {};
        }

        return JSON.parse(data);
    } catch (error) {
        return {};
    }
}

const GlobalObject =  {
    getGlobalAppData,
    loadGlobalAppData,
    lang,
    toObject,
}

export default GlobalObject;
