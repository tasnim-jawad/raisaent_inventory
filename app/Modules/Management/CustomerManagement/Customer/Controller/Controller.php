<?php

namespace App\Modules\Management\CustomerManagement\Customer\Controller;
use App\Modules\Management\CustomerManagement\Customer\Actions\GetAllData;
use App\Modules\Management\CustomerManagement\Customer\Actions\DestroyData;
use App\Modules\Management\CustomerManagement\Customer\Actions\GetSingleData;
use App\Modules\Management\CustomerManagement\Customer\Actions\StoreData;
use App\Modules\Management\CustomerManagement\Customer\Actions\UpdateData;
use App\Modules\Management\CustomerManagement\Customer\Actions\UpdateStatus;
use App\Modules\Management\CustomerManagement\Customer\Actions\SoftDelete;
use App\Modules\Management\CustomerManagement\Customer\Actions\RestoreData;
use App\Modules\Management\CustomerManagement\Customer\Actions\ImportData;
use App\Modules\Management\CustomerManagement\Customer\Validations\BulkActionsValidation;
use App\Modules\Management\CustomerManagement\Customer\Validations\DataStoreValidation;
use App\Modules\Management\CustomerManagement\Customer\Actions\BulkActions;
use App\Http\Controllers\Controller as ControllersController;


class Controller extends ControllersController
{

    public function index( ){

        $data = GetAllData::execute();
        return $data;
    }

    public function store(DataStoreValidation $request)
    {
        $data = StoreData::execute($request);
        return $data;
    }

    public function show($slug)
    {
        $data = GetSingleData::execute($slug);
        return $data;
    }

    public function update(DataStoreValidation $request, $slug)
    {
        $data = UpdateData::execute($request, $slug);
        return $data;
    }
         public function updateStatus()
    {
        $data = UpdateStatus::execute();
        return $data;
    }

    public function softDelete()
    {
        $data = SoftDelete::execute();
        return $data;
    }
    public function destroy($slug)
    {
        $data = DestroyData::execute($slug);
        return $data;
    }
    public function restore()
    {
        $data = RestoreData::execute();
        return $data;
    }
    public function import()
    {
        $data = ImportData::execute();
        return $data;
    }
    public function bulkAction(BulkActionsValidation $request)
    {
        $data = BulkActions::execute($request);
        return $data;
    }

}