<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard.index', [
            'demoFilterParams' => [
                'filter_by' => [
                    'status' => 'opened'
                ],
                'per_page' => 10,
            ]
        ]);
    }
}
