<?php

namespace App\Http\Controllers\Search;

use Illuminate\Support\Facades\Validator;

class Search
{
    public static function search(string $model, string $name, $col, $val)
    {
        $validator = Validator::make([
            'col' => $col,
            'val' => $val
        ], [
            'col' => ['required', 'in:' . implode(',', $model::fillables())],
            'val' => ['required', 'string'],
        ]);

        if ($validator->fails()) return;

        switch ($val) {
            case 'null':
                $real_val = null;
                goto equal;
            case 'true':
                $real_val = true;
                goto equal;
            case 'false':
                $real_val = false;
                goto equal;
        }

        $items = $model::where($col, 'like', "%$val%")->paginate();
        goto end;

        equal:
        $items = $model::where($col, $real_val ?? null)->paginate();

        end:
        return view($name . '.index')
            ->with('oldcol', $col)
            ->with('oldval', $val)
            ->with($name . 's', $items);
    }
}
