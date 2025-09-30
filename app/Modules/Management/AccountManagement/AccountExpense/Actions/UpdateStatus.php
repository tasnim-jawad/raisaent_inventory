<?php

namespace App\Modules\Management\AccountManagement\AccountExpense\Actions;

class UpdateStatus
{
    static $model = \App\Modules\Management\AccountManagement\AccountExpense\Models\Model::class;

    public static function execute()
    {
        try {

            if (!$data = self::$model::query()->where('slug', request('slug'))->first()) {
                return messageResponse('Data not found...', $data, 404, 'error');
            }

            if (request('is_approved') !== null) {
                $data->is_approved = request('is_approved')  ? 1 : 0;
            } else {
                $data->status = ($data->status === 'active') ? 'inactive' : 'active';
            }

            $data->update();

            return messageResponse('Item updated successfully', $data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
