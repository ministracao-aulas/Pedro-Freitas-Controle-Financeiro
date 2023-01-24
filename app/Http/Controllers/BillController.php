<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index()
    {
        return view('admin.bills.index', [
            'bills' => Bill::orderby('id', 'desc')->paginate(),
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
            'value' => 'required',
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
}
