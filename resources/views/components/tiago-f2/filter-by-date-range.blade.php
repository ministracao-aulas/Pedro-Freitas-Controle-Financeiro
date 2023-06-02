@php
    $defaultRange = $defaultRange ?? 'current_month';
    $dateRange = $dateRange ?? null;
    $startDate = $startDate ?? null;
    $endDate = $endDate ?? null;
@endphp
<div class="container-box">
    <div class="row">
        <div class="col-sm-12 col-lg-4">
            <div x-data="filterByDate('{{ $defaultRange }}')">
                <div class="w-100">
                    Start date: <span x-text="getStartDate"></span> <br>
                    End date: <span x-text="getEndDate"></span> <br>
                </div>

                <div class="form-group">
                    <label for="range-select">@lang('Date range'):</label>
                    <select id="range-select" class="form-control" x-model="range" x-on:change="validateDates">
                        <option value="current_month">@lang('Current month')</option>
                        <option value="last_7_days">@lang('Last :count days', ['count' => 7])</option>
                        <option value="last_30_days">@lang('Last :count days', ['count' => 30])</option>
                        <option value="last_60_days">@lang('Last :count days', ['count' => 60])</option>
                        <option value="custom">@lang('Custom')</option>
                    </select>
                </div>

                <div
                    x-show="range === 'custom'"
                    class="row">
                    <div class="col-sm-12 form-group">
                        <label for="start-date">Start Date:</label>
                        <input type="date" id="start-date" class="form-control" x-model="startDate" x-on:change="validateDates">
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="end-date">End Date:</label>
                        <input type="date" id="end-date" class="form-control" x-model="endDate" x-on:change="validateDates">
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

                                        let dateRangeFilter = { startDate: this.startDate, endDate: this.endDate }

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
