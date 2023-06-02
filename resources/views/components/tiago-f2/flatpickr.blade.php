<div class="flatpickr">
    <div
        x-data
        x-init="flatpickr($refs.dateInput, {
            locale: flatpickrPortuguese,
            altInput: true,
            altFormat: 'd F Y',
            dateFormat: 'Y-m-d',
            defaultDate: null,
            parseDate: true,
            defaultDate: [],
            mode: 'single',
            {{-- mode: 'single', //single|multiple|range --}}
            onChange: function(selectedDates, dateStr, instance) {
                {{-- console.log(selectedDates, dateStr, instance) --}}
                console.log(
                    selectedDates[0],
                    selectedDates[1],
                )
            },
        })">
        <input
            x-ref="dateInput"
            type="text"
            placeholder="{{ $placeholder ?? 'YYYY-MM-DD' }}"
            class="form-input"
        />
    </div>
</div>
