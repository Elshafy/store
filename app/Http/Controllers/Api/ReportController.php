<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //
    public function customerRecord($id)
    {
        $recorde = DB::table('exports')
            ->join('customers', 'exports.customer_id', '=', 'customers.id')
            ->join('items', 'exports.item_id', '=', 'items.id')
            ->select(
                'exports.id',
                'exports.amount',
                'items.name',
                DB::raw(' items.price * exports.amount AS " total" , customers.name AS "customer" ')
                // DB::raw('"customer.name As "supplier"')

            )->where('exports.customer_id', $id)
            ->get();
        $total = $recorde->sum('total');
        $result = [
            'recored' => $recorde,
            'total' => $total
        ];
        return $this->sendResponse($result, 'data retrived successfully');
    }
    public function supplierRecord($id)
    {
        $recorde = DB::table('imports')
            ->join('suppliers', 'imports.supplier_id', '=', 'suppliers.id')
            ->join('items', 'imports.item_id', '=', 'items.id')
            ->select(
                'imports.id',
                'imports.amount',
                'items.name',
                DB::raw(' items.price * imports.amount AS " total" , suppliers.name AS "supplier" ')
                // DB::raw('"suppliers.name As "supplier"')

            )->where('imports.supplier_id', $id)
            ->get();
        $total = $recorde->sum('total');
        $result = [
            'recored' => $recorde,
            'total' => $total
        ];
        return $this->sendResponse($result, 'data retrived successfully');
    }
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];
        return response()->json($response, 200);
    }
}