<?php

namespace Modules\Stocks\Services;

use Illuminate\Support\Facades\DB;
use App\Exceptions\GenericException;
use App\Exceptions\DatabaseException;
use Modules\Stocks\Repositories\StockMovementRepository;

class StockMovementService
{
    public function list()
    {
        return (new StockMovementRepository)->get();
    }

    public function create($payload)
    {
        try{
            return DB::transaction(function () use ($payload) {
                return (new StockMovementRepository)->saveData($payload);
            });
        }catch(\Throwable $ex){
            if ($ex instanceof \PDOException)
                throw new DatabaseException();
            throw new GenericException();
        }
    }
}