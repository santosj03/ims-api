<?php

namespace Modules\Products\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Modules\Products\Models\Branch;
use App\Exceptions\GenericException;
use App\Http\Controllers\Controller;
use Modules\Products\Http\Requests\GenericRequest;

class BranchController extends Controller
{
    public function list()
    {
        return response()->json([
            "data" => Branch::get()
        ]);
    }

    public function create(GenericRequest $request)
    {
        $request['code'] = strtolower(preg_replace('/\s+/', '_', $request['name']));
        try{
            DB::beginTransaction();
                Branch::create($request->only('code', 'name', 'is_active'));
                $columnName = $request['code'];
                DB::select("ALTER TABLE products ADD COLUMN $columnName INTEGER DEFAULT 0;");
            DB::commit();
            return response()->json([
                "is_success" => true
            ]);
        }catch(\Throwable $ex){
            DB::rollback();
            if ($ex instanceof \PDOException)
                throw new GenericException("DB-EXCP");
            throw new GenericException();
        }
    }
}
