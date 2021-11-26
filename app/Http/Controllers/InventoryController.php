<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(Request $request) 
    {
        $branchId = $request->has('branchId') ? $request->branchId : null;

        $query = Product::select(
            'order_products.quantity',
	        'order_products.quantity_sold',
            'products.name as product',
            'product_sizes.sale_price',
	        'product_sizes.price',
            'order_products.id',
            'products.expiry_days',
            'product_sizes.name as size',
            DB::raw('DATE_ADD( CAST(order_products.created AS DATE), INTERVAL 2 DAY) as entrega'),
            DB::raw('DATE_ADD( DATE_ADD( CAST(order_products.created AS DATE), INTERVAL 2 DAY), INTERVAL products.expiry_days - 1 DAY) as caducidad')
        )
        ->leftJoin('order_products', 'products.id', '=', 'order_products.product_id')
        ->leftJoin('orders', 'order_products.order_id', '=', 'orders.id')
        ->leftJoin('product_sizes', 'order_products.product_size_id', '=', 'product_sizes.id')
        ->whereRaw('orders.branch_id = 1 AND DATE_ADD( DATE_ADD( CAST(order_products.created AS DATE), INTERVAL 2 DAY), INTERVAL products.expiry_days DAY) >= CURDATE()')
        ->whereNotNull('order_products.quantity')
        ->where('orders.status', 1)
        ->whereRaw('DATE_ADD( CAST(orders.created AS DATE), INTERVAL 2 DAY) <= CURDATE()')
        ->orderBy('order_products.created', 'asc');

        if (!is_null($branchId)) {
            $query = $query->where('orders.branch_id', $branchId);
        }

        return response()->json($query->get());
    }
}
