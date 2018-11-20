<?php

namespace App\Traits;

use Dotenv\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait ApiResponer
{
    private function successResponse($data)
    {
        return response()->json(['data'=>$data,'status'=>true]);
    }

    protected function errorResponse($message)
    {
        return response()->json(['msg'=>$message,'status'=>false]);
    }

    protected function showAll(Collection $collection)
    {
        return response()->json(['data'=>$collection,'status'=>true]);
    }

    protected function showOne(Model $model)
    {
        return response()->json(['data'=>$model,'status'=>true]);
    }

    protected function showMessage($message)
    {
        return response()->json(['data'=>$message,'status'=>true]);
    }

    protected function sortData(Collection $collection)
    {
        if(request()->has('sort_by'))
        {
            $collection->sortBy(request('sort_by'));
        }
        return $collection;
    }

    protected function paginate(Collection $collection)
    {
        $rules = [
          'per_page'=>'integer|min:2|max:50'
        ];

        Validator::validate(request()->all(),$rules);

        $page = LengthAwarePaginator::resolveCurrentPage();

        $per_page = 10;

        $results = $collection->slice(($page - 1)* $per_page,$per_page)->values();

        if(request()->has('per_page'))
        {
            $per_page = (int)request()->per_page;
        }

        $paginated = new LengthAwarePaginator($results,$collection->count(),$per_page,$page,[
            'path'=>LengthAwarePaginator::resolveCurrentPage(),
            ]);

        $paginated->appends(request()->all());

        return $paginated;
    }
}
