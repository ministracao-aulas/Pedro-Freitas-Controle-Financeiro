<?php

namespace App\Models;

use Illuminate\Http\Request;
use Abbasudo\Purity\Traits\Sortable;
use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Bill
 *
 * @property int $id
 * @property string $title
 * @property int $type
 * @property \Illuminate\Support\Carbon|null $overdue_date
 * @property string|null $value
 * @property int $status
 * @property string|null $note
 * @property int|null $creditor_id
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\BillFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bill query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereCreditorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereOverdueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereValue($value)
 * @mixin \Eloquent
 * @property-read mixed $overdue
 * @property-read mixed $overdue_formated
 * @property-read mixed $status_color
 * @property-read mixed $status_name
 * @property-read mixed $type_color
 * @property-read mixed $type_name
 */
class Bill extends Model
{
    use HasFactory;
    use Sortable;
    use Filterable; // Exemplos em filter-demo.md

    public const TYPE_FIXED = 0;
    public const TYPE_VARIABLE = 1;
    public const TYPE_SEPARATE = 2;
    public const TYPE_OTHER = 3;

    public const STATUS_OPENED = 0;
    public const STATUS_PAID = 1;
    public const STATUS_POSTPONED = 2;
    public const STATUS_OTHER = 3;

    protected $fillable = [
        'title',
        'type',
        'overdue_date',
        'value',
        'status',
        'note',
        'creditor_id',
        'created_by',
    ];

    protected $dates = [
        'overdue_date',
    ];

    protected $casts = [
        'overdue_date' => 'datetime',
    ];

    protected $appends = [
        'overdue',
        'overdue_formated',
        'status_name',
        'status_color',
        'type_name',
        'type_color',
    ];

    /**
     * Get the creditor that owns the Bill
     *
     * @return BelongsTo
     */
    public function creditor(): BelongsTo
    {
        return $this->belongsTo(Creditor::class);
    }

    public function getOverdueAttribute()
    {
        if (!$this->overdue_date || $this->status === static::STATUS_PAID) {
            return null;
        }

        return now()->unix() > $this->overdue_date->unix();
    }

    public function getOverdueFormatedAttribute()
    {
        if (
            !$this->overdue_date ||
            !$this->overdue
        ) {
            return null;
        }

        $toReplace = [
            'days' => 'dias',
            'day' => 'dia',
            'months' => 'meses',
            'month' => 'mês',
            'years' => 'anos',
            'year' => 'ano',
            'ago' => 'de atraso',
        ];

        return __('Overdued') . ' ' . \str_replace(
            \array_keys($toReplace),
            \array_values($toReplace),
            now()->subDays(5)->diffForHumans()
        );
    }

    public function getStatusNameAttribute()
    {
        $statuses = [
            static::STATUS_OPENED => 'enums.status.opened',
            static::STATUS_PAID => 'enums.status.paid',
            static::STATUS_POSTPONED => 'enums.status.postponed',
            static::STATUS_OTHER => 'enums.status.other',
        ];

        return __($statuses[$this->status] ?? \null);
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            static::STATUS_OPENED => 'info',
            static::STATUS_PAID => 'success',
            static::STATUS_POSTPONED => 'warning',
            static::STATUS_OTHER => 'secondary',
        ];

        // if ($this->status != static::STATUS_PAID && $this->overdue) {
        //     return 'danger';
        // }

        return $colors[$this->status] ?? 'secondary';
    }

    public function getTypeNameAttribute()
    {
        $typees = [
            static::TYPE_FIXED => 'enums.type.fixed',
            static::TYPE_VARIABLE => 'enums.type.variable',
            static::TYPE_SEPARATE => 'enums.type.separate',
            static::TYPE_OTHER => 'enums.type.other',
        ];

        return __($typees[$this->type] ?? \null);
    }

    public function getTypeColorAttribute()
    {
        $colors = [
            static::TYPE_FIXED => 'primary',
            static::TYPE_VARIABLE => 'info',
            static::TYPE_SEPARATE => 'secondary',
            static::TYPE_OTHER => 'secondary',
        ];

        return $colors[$this->type] ?? 'secondary';
    }

    public function scopeOpened($billQuery)
    {
        return $billQuery->whereStatus(static::STATUS_OPENED);
    }

    /**
     * function requestFilterQuery
     *
     * @param Request $request
     * @param array $initialData
     *
     * @return array
     */
    public static function requestFilterQuery(
        Request $request,
        array $initialData = []
    ): array {
        $statusValues = [
            Bill::STATUS_OPENED => Bill::STATUS_OPENED,
            'opened' => Bill::STATUS_OPENED,
            Bill::STATUS_PAID => Bill::STATUS_PAID,
            'paid' => Bill::STATUS_PAID,
            Bill::STATUS_POSTPONED => Bill::STATUS_POSTPONED,
            'postponed' => Bill::STATUS_POSTPONED,
            Bill::STATUS_OTHER => Bill::STATUS_OTHER,
            'other' => Bill::STATUS_OTHER,
        ];

        $paginationValues = [
            10, 20, 30, 40, 50, 100, 150, 200,
        ];
        $defaultPerPage = 10;
        $perPage = $request->integer('per_page', $defaultPerPage);
        $perPage = \in_array($perPage, $paginationValues, true) ? $perPage : $defaultPerPage;
        $search = \trim((string) $request->string('search'));
        $filterBy = $request->get('filter_by');
        $filterByStatus = $filterBy ? $statusValues[$filterBy['status']] ?? \null : null;

        $dateRange = $request->get('date_range');
        $startDate = $request->get('date_range')['startDate'] ?? \null;
        $endDate = $request->get('date_range')['endDate'] ?? \null;
        $dateRangeMode = $request->get('dateRangeMode', 'current_month');

        $billQuery = Bill::orderby('id', 'desc'); //

        if ($search) {
            // TODO: clear chars here

            $clearedSearch = \strtoupper($search);

            $billQuery = $billQuery->whereRaw(
                "UPPER(title) LIKE ?",
                ["%{$clearedSearch}%"]
            );
        }

        if ($filterByStatus) {
            $billQuery = $billQuery->whereStatus($filterByStatus);
        }

        $overdueDateQuery = \null;

        if ($startDate || $endDate) {
            if ($startDate && $endDate && $startDate <= $endDate) {
                $overdueDateQuery = $billQuery->whereBetween(
                    'overdue_date',
                    [
                        "{$startDate} 00:00",
                        "{$endDate} 23:59"
                    ]
                );
            }

            if (!$overdueDateQuery && $startDate && !$endDate) {
                $overdueDateQuery = $billQuery->where('overdue_date', '>=', "{$startDate} 00:00");
            }

            if (!$overdueDateQuery && !$startDate && $endDate) {
                $overdueDateQuery = $billQuery->where('overdue_date', '<=', "{$endDate} 23:59");
            }
        }

        if ($overdueDateQuery) {
            $billQuery = $overdueDateQuery;
        }

        $filterParams = collect($request->query())->only([
            'per_page',
            'filter_by',
            'search',
        ]);

        return [
            ...$initialData,
            ...[
                'filterParams' => $filterParams,
                'filterParamsStr' => urldecode(http_build_query($filterParams->toArray())),
                'paginationValues' => $paginationValues,
                'perPage' => $perPage,
                'search' => $search,
                'bills' => $billQuery->with([
                    'creditor' => fn ($billQuery) => $billQuery->select(['id', 'name'])
                ]),
                'deleteId' => $request->input('action') === 'delete' &&
                is_numeric($request->input('delete_id')) ? $request->input('delete_id') : null,
            ]
        ];
    }
}
