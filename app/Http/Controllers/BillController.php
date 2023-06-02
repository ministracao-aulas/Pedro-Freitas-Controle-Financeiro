<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function wip(Request $request): \Illuminate\View\View
    {
        $billQuery = Bill::requestFilterQuery($request);

        return view(
            'admin.bills.wip',
            [
                'bills' => $billQuery['bills']->get(),
                'dateRange' => $request->get('date_range'),
                'startDate' => $request->get('date_range')['startDate'] ?? \null,
                'endDate' => $request->get('date_range')['endDate'] ?? \null,
                'dateRangeMode' => $request->get('dateRangeMode', 'current_month'),
            ]
        );
    }

    public function index(Request $request): \Illuminate\View\View
    {
        $data  = Bill::requestFilterQuery(
            $request,
            [
                'request' => $request,
                'dateRange' => $request->get('date_range'),
                'startDate' => $request->get('date_range')['startDate'] ?? \null,
                'endDate' => $request->get('date_range')['endDate'] ?? \null,
                'dateRangeMode' => $request->get('dateRangeMode', 'current_month'),
            ]
        );

        $data['bills'] = $data['bills']->paginate($data['perPage'] ?? 10);

        return view(
            'admin.bills.index',
            $data
        );
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
