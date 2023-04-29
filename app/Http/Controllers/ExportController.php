<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    protected static array $alowedResources = [
        'bills' => [
            'xlsx' => [ExportController::class, 'exportBillExcel'],
        ],
    ];

    /**
     * function getAllowedResources
     *
     * @return array
     */
    public static function getAllowedResources(): array
    {
        return array_keys(
            static::$alowedResources,
        );
    }

    /**
     * function allowedResource
     *
     * @param string $resource
     *
     * @return bool
     */
    public static function allowedResource(string $resource): bool
    {
        return \in_array(
            $resource,
            static::getAllowedResources(),
            true
        );
    }

    /**
     * function allowedResourceType
     *
     * @param string $resource
     * @param string $type
     *
     * @return bool
     */
    public static function allowedResourceType(string $resource, string $type): bool
    {
        if (!$resource || !$type) {
            return false;
        }

        return (bool) (static::$alowedResources[$resource][$type] ?? []);
    }

    /**
     * function getPipedAllowedResources
     *
     * @return string
     */
    public static function getPipedAllowedResources(): string
    {
        return implode(
            '|',
            static::getAllowedResources(),
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
        $data = Bill::requestFilterQuery(
            $request,
            [
                'request' => $request,
            ]
        );

        return $data; // WIP
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
