<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index(Request $request): \Illuminate\View\View
    {
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

        $query = Bill::orderby('id', 'desc'); //

        if ($search) {
            // TODO: clear chars here

            $clearedSearch = \strtoupper($search);

            $query = $query->whereRaw(
                "UPPER(title) LIKE ?",
                ["%{$clearedSearch}%"]
            );
        }

        if ($filterByStatus) {
            $query = $query->whereStatus($filterByStatus);
        }

        $filterParams = collect($request->query())->only([
            'per_page',
            'filter_by',
            'search',
        ]);

        return view('admin.bills.index', [
            'request' => $request,
            'filterParams' => urldecode(http_build_query($filterParams->toArray())),
            'paginationValues' => $paginationValues,
            'perPage' => $perPage,
            'search' => $search,
            'bills' => $query->with([
                'creditor' => fn ($query) => $query->select(['id', 'name'])
            ])
                ->paginate($perPage),
            'deleteId' => $request->input('action') === 'delete' &&
                is_numeric($request->input('delete_id')) ? $request->input('delete_id') : null,
        ]);
    }

    public function create()
    {
        return view('admin.bills.create');
    }

    public function store(Request $request)
    {
        $billTypes = [
            Bill::TYPE_FIXED,
            Bill::TYPE_VARIABLE,
            Bill::TYPE_SEPARATE,
            Bill::TYPE_OTHER,
        ];

        $billStatus = [
            Bill::STATUS_OPENED,
            Bill::STATUS_PAID,
            Bill::STATUS_POSTPONED,
            Bill::STATUS_OTHER,
        ];

        $request->validate([
            'title' => 'required|string|min:3',
            'type' => 'required|integer|in:' . implode(',', $billTypes),
            'overdue_date' => 'nullable|date',
            'value' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'status' => 'required|integer|in:' . implode(',', $billStatus),
            'note' => 'nullable|string|min:3',
            'creditor_id' => 'nullable|integer|exists:App\Models\Creditor,id',
        ]);

        $createdBy = $request->user() ? $request->user()->id : \null;

        $billData = $request->only([
            'title',
            'type',
            'overdue_date',
            'value',
            'status',
            'note',
            'creditor_id',
        ]);

        if ($billData) {
            $billData['created_by'] = $createdBy;
        }

        $bill = Bill::create($billData);

        if (!$bill) {
            return redirect()->route('admin.contas.index')->with([
                'error' => __('Fail to save :resource', ['resource' => 'bill']),
            ]);
        }

        return redirect()->route('admin.contas.index')->with([
            'error' => __(':resource stored successfuly', ['resource' => 'Bill']),
        ]);
    }

    public function destroy(Request $request, $billId = null)
    {
        $billId ??= $request->integer('bill_id') ?: null;

        if (!$billId) {
            return \back()->with([
                'error' => __('Identificador de conta inválido')
            ]);
        }

        /**
         * @var Bill $bill
         */
        $bill = Bill::whereId($billId)->first();

        if (!$bill) {
            return \back()->with([
                'error' => __('Conta ::bill_id não encontrada', [
                    'bill_id' => $billId,
                ])
            ]);
        }

        $deleted = $bill->delete();

        return \redirect()
            ->route('admin.contas.index')
            ->with([
                $deleted ? 'success' : 'error' => __(
                    $deleted
                        ? 'Conta ::bill_id deletada com sucesso'
                        : 'Conta ::bill_id não encontrada',
                    [
                        'bill_id' => $billId,
                    ]
                )
            ]);
    }

    public function update(Request $request, $billId = null)
    {
        $billId ??= $request->integer('bill_id') ?: null;

        if (!$billId) {
            return \back()->with([
                'error' => __('Identificador de conta inválido')
            ]);
        }

        /**
         * @var Bill $bill
         */
        $bill = Bill::whereId($billId)->first();

        if (!$bill) {
            return \back()->with([
                'error' => __('Conta ::bill_id não encontrada', [
                    'bill_id' => $billId,
                ])
            ]);
        }

        $updated = $bill->update(
            $request->only([
                'title',
                'type',
                'overdue_date',
                'value',
                'status',
                'note',
                'creditor_id',
            ])
        );

        return \redirect()
            ->route('admin.contas.index')
            ->with([
                $updated ? 'success' : 'error' => __(
                    $updated
                        ? 'Conta ::bill_id deletada com sucesso'
                        : 'Conta ::bill_id não encontrada',
                    [
                        'bill_id' => $billId,
                    ]
                )
            ]);
    }
}
