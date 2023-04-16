<script>
    window.__GlobalAppData = window.__GlobalAppData || {};

    document.addEventListener('DOMContentLoaded', (event) => {
        _.set(window.__GlobalAppData, 'app.locale', "{{ config('app.locale') }}");

        try {
            let toLoad = [
                {
                    key: 'lang.enums.type',
                    data: {!! \App\AppData\LoadBillAppData::getTypes() !!},
                },
                {
                    key: 'lang.enums.status',
                    data: {!! \App\AppData\LoadBillAppData::getStatus() !!},
                },
            ];

            toLoad.forEach(item => {
                let key = item.key;
                let data = item.data;

                data = !data.constructor || data.constructor == 'String' ? GlobalObject.toObject(data) : data;

                _.set(window.__GlobalAppData, key, data);
            });
        } catch (error) {
            @if(config('app.debug'))
            console.error(error);
            @endif
        }

        // let data = {!! \App\AppData\LoadBillAppData::getStatus() !!};
        // data = !data.constructor || data.constructor == 'String' ? GlobalObject.toObject(data) : data;

        // _.set(window.__GlobalAppData, 'lang.enums.status', data);
    });
</script>
