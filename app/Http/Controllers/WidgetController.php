<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    public function disableditems()
    {
        // dd(Item::paginate(5)->withQueryString());
        return Item::where('active', false)->get();
    }
    public function itemWithExportMport()
    {

        return Item::with(['imports', 'exports'])->get();
    }
}