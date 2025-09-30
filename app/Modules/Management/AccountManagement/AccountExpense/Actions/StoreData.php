<?php

namespace App\Modules\Management\AccountManagement\AccountExpense\Actions;

class StoreData
{
    static $model = \App\Modules\Management\AccountManagement\AccountExpense\Models\Model::class;

    public static function execute($request)
    {
        try {

            $requestData = $request->validated();

            $requestData['is_approved'] = auth()->user()->role_id == 1 ? 1 : 0;

            if ($request->hasFile('document')) {
                $image = $request->file('document');
                $requestData['document'] = uploader($image, 'uploads/document');
            }

            if ($data = self::$model::query()->create($requestData)) {
                return messageResponse('Item added successfully', $data, 201);
            }
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
