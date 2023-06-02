@php
    $defaultRange = $defaultRange ?? 'current_month';
    $dateRange = $dateRange ?? null;
    $startDate = $startDate ?? null;
    $endDate = $endDate ?? null;
@endphp
<div class="container-box">
    <div class="row">
        <div class="col-sm-12">
            <div x-data="filterByDate('{{ $defaultRange }}')">
                <div class="form-group">
                    <div class="dropdown d-grid gap-2">
                        <div type="button" data-bs-toggle="dropdown" aria-expanded="true" class="show d-block w-100 mb-0">
                            <select
                                id="range-select"
                                class="form-control"
                                x-model="range"
                                x-on:change="validateDatesAndCommit"
                                required>
                                <option value="" disabled>@lang('Date range') (@lang('Overdue date'))</option>
                                <option value="current_month">@lang('Current month')</option>
                                <option value="last_7_days">@lang('Last :count days', ['count' => 7])</option>
                                <option value="last_30_days">@lang('Last :count days', ['count' => 30])</option>
                                <option value="last_60_days">@lang('Last :count days', ['count' => 60])</option>
                                <option value="custom" x-on:click="showDateRangeSelector = true">@lang('Custom')</option>
                            </select>
                        </div>

                        <div
                            x-show="showDateRangeSelector"
                            style="display: none; position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 40px);"
                            class="dropdown-menu show w-100 mt-0"
                        >
                            <div
                                class="row d-flex align-items-center justify-content-end px-2">
                                <div class="col-sm-12 modal-header py-1 mb-1">
                                    <h5 class="modal-title" id="showBillModalLabel">
                                        @lang('Select a date range')
                                    </h5>
                                    <button
                                        type="button" class="close"
                                        x-on:click="showDateRangeSelector = false"
                                        aria-label="Close">
                                        <span class="p-2 px-3" aria-hidden="true">×</span>
                                    </button>
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label for="start-date">@lang('Start date'):</label>

                                    <input
                                        x-ref="startDateInput"
                                        x-init="flatpickr($refs.startDateInput, {
                                            locale: flatpickrPortuguese,
                                            altInput: true,
                                            altFormat: 'd F Y',
                                            dateFormat: 'Y-m-d',
                                            defaultDate: getStartDate(),
                                            parseDate: true,
                                            defaultDate: [],
                                            mode: 'single',
                                            onChange: function(selectedDates, dateStr, instance) {
                                                setStartDate(dateStr);

                                                {{-- validateDates() --}}
                                            },
                                        })"
                                        type="text"
                                        x-bind:placeholder="getStartDate()"
                                        placeholder="@lang('Start date')"
                                        class="form-control cursor-pointer bg-white"
                                        id="start-date"
                                        x-model="startDate"
                                        x-on:change="validateDates" />
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label for="end-date">@lang('End date'):</label>

                                    <input
                                        x-ref="endDateInput"
                                        x-init="flatpickr($refs.endDateInput, {
                                            locale: flatpickrPortuguese,
                                            altInput: true,
                                            altFormat: 'd F Y',
                                            dateFormat: 'Y-m-d',
                                            defaultDate: getEndDate(),
                                            parseDate: true,
                                            defaultDate: [],
                                            mode: 'single',
                                            onChange: function(selectedDates, dateStr, instance) {
                                                setEndDate(dateStr);

                                                {{-- validateDates() --}}
                                            },
                                        })"
                                        type="text"
                                        x-bind:placeholder="getEndDate()"
                                        placeholder="@lang('End date')"
                                        class="form-control cursor-pointer bg-white"
                                        id="end-date"
                                        x-model="endDate"
                                        x-on:change="validateDates" />
                                </div>

                                <div
                                    x-show="validationMessage"
                                    x-text="validationMessage"
                                    class="col-12 alert alert-danger"
                                    style="display: none"></div>

                                <div
                                    class="col-sm-12 my-2"
                                    x-show="!validationMessage"
                                    style="display: none">
                                    <button
                                        class="btn btn-outline-success float-end d-block d-md-inline w-100"
                                        type="button"
                                        x-on:click="confirmDateRange">
                                        @lang('Confirm')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('alpine:init', () => {
                        Alpine.data(
                            'filterByDate',
                            (defaultRange = 'current_month') => {
                                function getValidRange(range) {
                                    return range && [
                                        'current_month',
                                        'last_30_days',
                                        'last_60_days',
                                        'last_7_days',
                                        'custom',
                                    ].includes(range) ? range : 'current_month';
                                }

                                let range = defaultRange = getValidRange(defaultRange);
                                let startDate = "{{ $startDate ?: '' }}";
                                let endDate = "{{ $endDate ?: '' }}";
                                let showDateRangeSelector = false;

                                function getLastDayOfMonth(year, month) {
                                    return new Date(year, month, (new Date(year, month + 1, 0).getDate()));
                                }

                                function getFirstDayOfMonth(year, month) {
                                    return new Date(year, month, 1);
                                }

                                function getTimedDate(
                                    date,
                                    toCalc = 0,
                                    operation = 'sum'
                                ) {
                                    operation = ['sum', 'sub'].includes(operation) ? operation : null;

                                    toCalc = isNaN(parseInt(toCalc)) ? 0 : parseInt(toCalc)

                                    if (!date || toCalc <= 0 || !operation) {
                                        return new Date();
                                    }

                                    let today = new Date();
                                    let millisecondsPerDay = 24 * 60 * 60 * 1000;
                                    let newDate = operation === 'sub' ?
                                        new Date(today.getTime() - (toCalc * millisecondsPerDay)) :
                                        new Date(today.getTime() + (toCalc * millisecondsPerDay));

                                    return newDate;
                                }

                                function log(...toLog) {
                                    if (!toLog.length) {
                                        return;
                                    }

                                    console.log('    ');
                                    console.log('\n>-------------');
                                    toLog.forEach(item => console.log(item))
                                    console.log('-------------<\n');
                                    console.log('    ');
                                }

                                return {
                                    init() { // https://alpinejs.dev/directives/init#auto-evaluate-init-method
                                        this.startDate = this.getStartDate();
                                        this.endDate = this.getEndDate();
                                        // this.validateDates();
                                    },
                                    range,
                                    showDateRangeSelector,
                                    startDate,
                                    endDate,
                                    isoDate(...date) {
                                        try {
                                            if (!date || !date[0]) {
                                                return new Date().toISOString().slice(0, 10);
                                            }

                                            if (Object.keys(date).length === 1 && typeof date === 'string') {
                                                return new Date(date).toISOString().slice(0, 10);
                                            }

                                            return (new Date(...date)).toISOString().slice(0, 10);
                                        } catch (error) {
                                            return (new Date()).toISOString().slice(0, 10);
                                        }
                                    },
                                    isoToday() {
                                        return new Date().toISOString().slice(0, 10);
                                    },
                                    firstDayOfCurrentMonth() {
                                        let today = new Date();
                                        return getFirstDayOfMonth(today.getFullYear(), today.getMonth());
                                    },
                                    isoFirstDayOfCurrentMonth() {
                                        return this.isoDate(this.firstDayOfCurrentMonth());
                                    },
                                    setStartDate(startDate) {
                                        if (!startDate) {
                                            return;
                                        }

                                        this.startDate = startDate;
                                    },
                                    setEndDate(endDate) {
                                        if (!endDate) {
                                            return;
                                        }

                                        this.endDate = endDate;
                                    },
                                    getStartDate() {
                                        let today = new Date();

                                        switch (this.range) {
                                            case 'last_7_days':
                                                return this.isoDate(getTimedDate(today, 7, 'sub'));
                                                break;

                                            case 'last_30_days':
                                                return this.isoDate(getTimedDate(today, 30, 'sub'));
                                                break;

                                            case 'last_60_days':
                                                return this.isoDate(getTimedDate(today, 60, 'sub'));
                                                break;

                                            case 'custom':
                                                return !!this.startDate ?
                                                    this.isoDate(new Date(this.startDate)) :
                                                    this.isoFirstDayOfCurrentMonth();
                                                break;

                                            case 'current_month':
                                            default:
                                                return this.isoFirstDayOfCurrentMonth();
                                                break;
                                        }
                                    },
                                    getEndDate() {
                                        let today = new Date();

                                        if (this.range === 'current_month') {
                                            return this.isoDate(
                                                getLastDayOfMonth(today.getFullYear(), today.getMonth())
                                            )
                                        }

                                        return this.isoDate(this.endDate ? new Date(this.endDate) : today);
                                    },
                                    validateDates() {
                                        try {
                                            if (!this.startDate || !this.endDate) {
                                                return "{{ __('Please, select a valid date range.') }}";
                                            }

                                            let validDates = new Date(this.startDate) || new Date(this.endDate);

                                            if (this.startDate && this.endDate && new Date(this.startDate) > new Date(this.endDate)) {
                                                return "{{ __('Start date cannot be greater than end date.') }}";
                                            }

                                            this.startDate = this.getStartDate();
                                            this.endDate = this.getEndDate();

                                            if (!this?.startDate || !this?.endDate) {
                                                return
                                            }

                                            this.updateSearchParams()
                                        } catch (error) {
                                            return "{{ __('Please, select a valid date range.') }}";
                                        }
                                    },
                                    getLastDayOfMonth,
                                    get validationMessage() {
                                        return this.validateDates()
                                    },
                                    updateSearchParams() {
                                        if (!this?.startDate || !this?.endDate) {
                                            return;
                                        }

                                        let dateRangeFilter = {
                                            startDate: this.startDate,
                                            endDate: this.endDate
                                        }

                                        if (dateRangeFilter['startDate']) {
                                            searchHelpers.set('date_range[startDate]', dateRangeFilter['startDate']);
                                        }

                                        if (dateRangeFilter['endDate']) {
                                            searchHelpers.set('date_range[endDate]', dateRangeFilter['endDate']);
                                        }

                                        if (this.range) {
                                            searchHelpers.set('dateRangeMode', this.range);
                                        }

                                        if (!this?.startDate || !this?.endDate) {
                                            return;
                                        }
                                    },
                                    validateDatesAndCommit() {
                                        if (!this.range) {
                                            this.range = 'current_month';
                                        }

                                        if (this.range === 'custom') {
                                            this.showDateRangeSelector = true;
                                            log('é custom')
                                            return;
                                        }

                                        log('não é custom')

                                        this.confirmDateRange()
                                    },
                                    confirmDateRange() {
                                        if (this.validateDates()) {
                                            return;
                                        }

                                        this.updateSearchParams();

                                        searchHelpers?.commit && searchHelpers?.commit();
                                    },
                                }
                            })
                    })
                </script>
            </div>
        </div>
    </div>
</div>
