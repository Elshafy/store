<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //
    public function customerRecord()
    {
        $customer = request()->user()->customer;
        if (!$customer) {
            return $this->sendError('you dont have a customer or data');
        }
        $id = $customer->id;
        $recorde = DB::table('exports')
            ->join('customers', 'exports.customer_id', '=', 'customers.id')
            ->join('items', 'exports.item_id', '=', 'items.id')
            ->select(
                'exports.id',
                'exports.amount',
                'items.name',
                DB::raw(' items.price * exports.amount AS " total"  ')

            )->where('exports.customer_id', $id)
            ->get();
        $total = $recorde->sum('total');
        $result = [
            'number'    => $customer->exports()->count(),
            'total' => $total,
            'customer' => [
                'name' => $customer->user->name,
                'email' => $customer->user->email,

            ],
            'recored' => $recorde,
        ];
        return $this->sendResponse($result, 'data retrived successfully');
    }
    public function supplierRecord()
    {
        $supplier = request()->user()->supplier;
        if (!$supplier) {
            return $this->sendError('you dont have a supplier or data');
        }
        $id = $supplier->id;

        $recorde = DB::table('imports')
            ->join('suppliers', 'imports.supplier_id', '=', 'suppliers.id')
            ->join('items', 'imports.item_id', '=', 'items.id')
            ->select(
                'imports.id',
                'imports.amount',
                'items.name',
                DB::raw(' items.price * imports.amount AS " total"  ')

            )->where('imports.supplier_id', $id)
            ->get();
        $total = $recorde->sum('total');
        $result = [
            'number'    => $supplier->imports()->count(),

            'total' => $total,
            'supplier' => [
                'name' => $supplier->user->name,
                'email' => $supplier->user->email,

            ],
            'recored' => $recorde,
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
    public function sendError($error, $errorMessage = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error
        ];
        if (!empty($errorMessage)) {
            $response['data'] = $errorMessage;
        }
        return response()->json($response, $code);
    }
}
