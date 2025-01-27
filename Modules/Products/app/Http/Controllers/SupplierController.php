<?php

namespace Modules\Products\Http\Controllers;

use App\Domain\GenericDomain;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GenericException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Products\Models\Supplier;
use Modules\Products\Http\Requests\CreateSupplierRequest;

class SupplierController extends Controller
{
    public function list()
    {
        $data =  Cache::rememberForever(GenericDomain::CACHE_TYPE['SUPPLIERS'], function(){
            return Supplier::get();
        });
        return response()->json([
            "data" => $data
        ]);
    }

    public function create(CreateSupplierRequest $request)
    {
        $request['code'] = strtolower(preg_replace('/\s+/', '_', $request['name']));
        try{
            DB::beginTransaction();
                Supplier::create($request->all());
            DB::commit();
            return response()->json([
                "is_success" => true
            ]);
        }catch(\Throwable $ex){
            DB::rollback();
            dd($ex);
            if ($ex instanceof \PDOException)
                throw new GenericException("DB-EXCP");
            throw new GenericException();
        }
    }
}
