<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\User;
use App\Exports\RevenueExport;
use Maatwebsite\Excel\Facades\Excel;

class RevenueController extends Controller
{
    public function revenue(Request $request)
    {
    	$customers = User::role('customer')->where('status', User::ACTIVE)->paginate(10);

    	if ($request->name) {
    		$customers = User::role('customer')->where('status', User::ACTIVE)->where('name', 'like', '%'.$request->name.'%')->paginate(10);
    	}

    	$data = [
    		'customers' => $customers,
            'name' => $request->name,
            'fromMonth' => $request->fromMonth,
            'toMonth' => $request->toMonth,
    	];

        return view('revenue', $data);
    }

    public function exportRevenue(Request $request) {
        return Excel::download(new RevenueExport($request->all()), 'Doanh_thu.xlsx');
    }
}
