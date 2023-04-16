<?php

namespace App\AppData;

use App\Models\Bill;

class LoadBillAppData
{
    /**
     * function getStatus
     *
     * @return string
     */
    public static function getStatus(): string
    {
        return \json_encode([
            Bill::STATUS_OPENED => __('enums.status.opened'),
            'opened' => __('enums.status.opened'),
            Bill::STATUS_PAID => __('enums.status.paid'),
            'paid' => __('enums.status.paid'),
            Bill::STATUS_POSTPONED => __('enums.status.postponed'),
            'postponed' => __('enums.status.postponed'),
            Bill::STATUS_OTHER => __('enums.status.other'),
            'other' => __('enums.status.other'),
        ]);
    }

    /**
     * function getTypes
     *
     * @return string
     */
    public static function getTypes(): string
    {
        return \json_encode([
            Bill::TYPE_FIXED => __('enums.type.fixed'),
            'fixed' => __('enums.type.fixed'),
            Bill::TYPE_VARIABLE => __('enums.type.variable'),
            'variable' => __('enums.type.variable'),
            Bill::TYPE_SEPARATE => __('enums.type.separate'),
            'separate' => __('enums.type.separate'),
            Bill::TYPE_OTHER => __('enums.type.other'),
            'other' => __('enums.type.other'),
        ]);
    }
}
