<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExportController extends Controller
{
    protected static array $alowedResources = [
        'bills' => [
            'xlsx' => [ExportController::class, 'exportBillExcel'],
        ],
    ];

    /**
     * function getPipedAlowedResources
     *
     * @return string
     */
    public static function getPipedAlowedResources(): string
    {
        return implode(
            '|',
            array_keys(
                static::$alowedResources,
            )
        );
    }

    /**
     * function export
     *
     * @param \Illuminate\Http\Request request
     */
    public function export(Request $request, string $resource, string $type)
    {
        $resourceData = static::$alowedResources[$resource][$type] ?? \null;

        if (!$resourceData) {
            return \null;
        }

        return \call_user_func($resourceData, $request, $type);
    }

    /**
     * function exportBillExcel
     *
     * @param Request $request
     * @return
     */
    protected function exportBillExcel(Request $request) // [TODO] ver tipo retornado e colocar aqui
    {
        // WIP

        $filterParams = collect($request->query())->only([
            'per_page',
            'filter_by',
            'search',
        ]);
        return [
            'content' => 'EXCEL AQUI',
            'filterParams' => $filterParams,
        ];
    }

    /**
     * function exportBillPDF
     *
     * @param Request $request
     * @return
     */
    protected function exportBillPDF(Request $request) // [TODO] ver tipo retornado e colocar aqui
    {
        // TODO
        return ['PDF AQUI'];
    }
}
