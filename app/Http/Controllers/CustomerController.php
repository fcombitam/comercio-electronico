<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    //

    public function index(Request $request)
    {
        $itemsPerPage = 10;

        $search = $request->input('search');

        $query = User::query();

        $query->whereType(User::TYPE_CLIENT);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $customers = $query->paginate($itemsPerPage)->appends([
            'search' => $search
        ])->onEachSide(2);
        return view('customers.index', compact('customers'));
    }

    public function export(Request $request)
    {
        $search = $request->input('search');

        $query = User::query();

        $query->whereType(User::TYPE_CLIENT);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $customers = $query->get();

        return Excel::download(new CustomersExport($customers), 'clientes.xlsx');
    }

    public function show(User $customer)
    {
        $orders = $customer->orders()->whereIn('status',[Order::STATUS_COMPLETED, Order::STATUS_CANCELLED])->with(['items.product'])->get();
        
        return view('customers.show', compact('customer', 'orders'));
    }
}
