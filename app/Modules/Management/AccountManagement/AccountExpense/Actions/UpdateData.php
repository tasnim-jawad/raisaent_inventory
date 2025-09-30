<?php

namespace App\Modules\Management\AccountManagement\AccountExpense\Actions;

class UpdateData
{
    static $model = \App\Modules\Management\AccountManagement\AccountExpense\Models\Model::class;

    public static function execute($request, $slug)
    {
        try {
            if (!$data = self::$model::query()->where('slug', $slug)->first()) {
                return messageResponse('Data not found...', $data, 404, 'error');
            }

            if ($request->mark_as_seen == 1) {
                $data->is_seen = 1;
            }

            $requestData = $request->validated();
            if ($request->hasFile('document')) {
                $image = $request->file('document');
                $requestData['document'] = uploader($image, 'uploads/document');
            }

            $data->update($requestData);
            return messageResponse('Item updated successfully', $data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
