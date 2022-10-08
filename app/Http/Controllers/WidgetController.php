<?php

namespace App\Http\Controllers;

use App\Models\Import;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WidgetController extends Controller
{
    public function disableditems()
    {
        // dd(Item::where('active', false)->get());
        return Item::where('active', false)->get();
    }
    public function itemWithExportMport()
    {
        return   Item::withSum('imports', 'amount',)
            ->withSum('exports', 'amount')
            ->get();
    }
    public function LastMonth()
    {


        return   Item::withSum(
            [
                'imports' =>
                function ($q) {
                    $q->whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()]);
                }
            ],
            'amount'
        )->withSum(
            ['exports' => function ($q) {
                $q->whereBetween(
                    'created_at',

                    [Carbon::now()->subMonth(), Carbon::now()]

                );
            }],
            'amount'
        )->get();
    }

    public function TopImports()
    {

        $data = DB::table('imports')
            ->join('items', 'imports.item_id', '=', 'items.id')
            ->select(
                'imports.item_id',
                'imports.amount',
                'items.name',
                DB::raw(' SUM(imports.amount) AS "total" ')
            )
            ->groupBy('imports.item_id')->orderByDesc('total')->limit(5)->get();


        return $data;
    }
    public function MinItem()
    {

        return Item::whereColumn('amount', '<=', 'min')->get();
    }
}