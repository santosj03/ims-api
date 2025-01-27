<?php

namespace Modules\Products\Http\Controllers;

use App\Domain\GenericDomain;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GenericException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Products\Models\Category;
use Modules\Products\Http\Requests\GenericRequest;

class CategoryController extends Controller
{
    public function list()
    {
        $data =  Cache::rememberForever(GenericDomain::CACHE_TYPE['CATEGORIES'], function(){
            return Category::get();
        });
        
        return response()->json([
            "data" => $data
        ]);
    }

    public function create(GenericRequest $request)
    {
        $request['code'] = strtolower(preg_replace('/\s+/', '_', $request['name']));
        try{
            DB::beginTransaction();
                Category::create($request->only('code', 'name', 'is_active'));
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
