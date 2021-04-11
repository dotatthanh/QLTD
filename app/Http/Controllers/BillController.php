<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bill;
use DB;
use Auth;
use Illuminate\Support\Collection;
use DateTime;
use App\Exports\BillExport;
use Maatwebsite\Excel\Facades\Excel;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->search) {
            $bills = Bill::with('user')
            ->where('code', 'like','%'. $request->search. '%')
            ->paginate(10);
        }
        else {
            $bills = Bill::with('user')->paginate(10);
        }

        $data = [
            'search' => $request->search,
            'bills' => $bills,
        ];
        return view('bill.bill', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $today = date('H:i, d/m/Y');
        $bill = Bill::with('user')->find($id);

        $data = [
            'bill' => $bill,
            'today' => $today,
        ];
        return view('bill.print', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bill = Bill::findOrFail($id);

        $data = [
            'bill' => $bill,
        ];

        return view('bill.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $period = $request->period.'-01';

            $bill = Bill::find($id);

            $bill_count = Bill::where('customer_id', $bill->customer_id)->where('period', $period)->get()->whereNotIn('id', $id)->count();
            if ($bill_count > 0){
                return redirect()->route('bills.index')->with('notificationUpdateFail', 'Cập nhật hóa đơn thất bại! Kỳ thu '.date_format(new DateTime($request->period), 'm/Y').' đã có hóa đơn.');
            }

            if ($bill->status) {
                $bill->update([
                    'power_number' => $request->power_number,
                    'price' => $request->price,
                    'period' => $period,
                    'proceeds' => $request->proceeds,
                    'amount_return' => $request->amount_return,
                    'debit' => $request->debit,
                ]);
            }
            else {
                $bill->update([
                    'power_number' => $request->power_number,
                    'price' => $request->price,
                    'period' => $period,
                    'debit' => $request->price,
                ]);
            }

            DB::commit();
            return redirect()->route('bills.index')->with('notificationUpdate', 'Cập nhật hóa đơn thành công!');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
            return redirect()->route('bills.index')->with('notificationUpdateFail', 'Cập nhật hóa đơn thất bại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bill::destroy($id);

        return redirect()->route('bills.index', $id)->with('notificationDelete', 'Xóa hóa đơn thành công!');
    }

    public function import($id)
    {
        $customer = User::find($id);

        $data = [
            'customer' => $customer,
        ];
        return view('import-power-number', $data);
    }

    public function importPowerNumber(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $period = $request->period.'-01';

            $bill = Bill::where('customer_id', $id)->where('period', $period)->first();

            if ($bill){
                return redirect()->route('customers.index')->with('notificationImportFail', 'Kỳ thu đã nhập số điện!');
            }
            
            if ($request->power_number <= 50) {
                $price = $request->power_number * 1678;
            }
            elseif ($request->power_number >= 51 && $request->power_number <= 100) {
                $price = 50 * 1678 + ($request->power_number - 50) * 1734;
            }
            elseif ($request->power_number >= 101 && $request->power_number <= 200) {
                $price = 50 * 1678 + 50 * 1734 + ($request->power_number -100) * 2014;
            }
            elseif ($request->power_number >= 201 && $request->power_number <= 300) {
                $price = 50 * 1678 + 50 * 1734 + 100 * 2014 + ($request->power_number - 200) * 2536;
            }
            elseif ($request->power_number >= 301 && $request->power_number <= 400) {
                $price = 50 * 1678 + 50 * 1734 + 100 * 2014 + 100 * 2536 + ($request->power_number - 300) * 2834;
            }
            elseif ($request->power_number >= 401) {
                $price = 50 * 1678 + 50 * 1734 + 100 * 2014 + 100 * 2536 + 100 * 2834 + ($request->power_number - 400) * 2927;
            }

            Bill::create([
                'customer_id' => $id,
                'code' => 'HD'.strval(Bill::count()+1),
                'power_number' => $request->power_number,
                'price' => $price,
                'debit' => $price,
                'period' => $period,
                'status' => Bill::UNPAID,
            ]);

            DB::commit();
            return redirect()->route('customers.index')->with('notificationImportSuccess', 'Nhập số điện thành công!');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
            return redirect()->route('customers.index')->with('notificationImportFail', 'Nhập số điện thất bại!');
        }
    }

    public function dashboard(Request $request)
    {
        $notification = '';
        $bills = Bill::with('user')->where('customer_id', 0)->paginate(10);

        if ($request->key == 'code') {
            $customer = User::role('customer')->where('status', 1)->where('code', $request->search)->first();
            if ($customer) {
                $bills = Bill::with('user')->where('status', 0)->where('customer_id', $customer->id)->paginate(10);
                if ($bills->count() == 0) {
                    $notification = 'Khách hàng không nợ cước.';
                }
            }
            else {
                $bills = Bill::with('user')->where('customer_id', 0)->paginate(10);
                $notification = 'Khách hàng không tồn tại.';
            }
        }
        elseif ($request->key == 'phone') {
            $customer = User::role('customer')->where('status', 1)->where('phone', $request->search)->first();
            if ($customer) {
                $bills = Bill::with('user')->where('status', 0)->where('customer_id', $customer->id)->paginate(10);
                if ($bills->count() == 0) {
                    $notification = 'Khách hàng không nợ cước.';
                }
            }
            else {
                $bills = Bill::with('user')->where('customer_id', 0)->paginate(10);
                $notification = 'Khách hàng không tồn tại.';
            }
        }
        elseif ($request->key == 'name') {
            $customers = User::role('customer')->where('status', 1)->where('name', 'like', '%'.$request->search.'%')->get('id');

            $id = [];
            foreach ($customers as $customer) {
                array_push($id, $customer->id);
            }

            $bills = Bill::with('user')->where('status', 0)->whereIn('customer_id', $id)->paginate(10);

            if ($bills->count() == 0) {
                $notification = 'Khách hàng không nợ cước.';
            }
            if (!$id) {
                $notification = 'Khách hàng không tồn tại.';
            }
        }

        if (Auth::user()->hasRole('customer')) {
            $id = Auth::id();
            $bills = Bill::with('user')->where('customer_id', $id)->paginate(10);
            
            if ($request->code) {
                $bills = Bill::with('user')->where('customer_id', $id)->where('code', $request->code)->paginate(10);
            }
            elseif ($request->period) {
                $period = $request->period.'-01';
                $bills = Bill::with('user')->where('customer_id', $id)->where('period', $period)->paginate(10);
            }
        }

        $data = [
            'user' => Auth::user(),
            'bills' => $bills,
            'search' => $request->search,
            'key' => $request->key,
            'code' => $request->code,
            'period' => $request->period,
            'notification' => $notification,
        ];

        return view('dashboard', $data);
    }

    public function print(Request $request)
    {
        DB::beginTransaction();
        try {
            $bill = Bill::findOrFail($request->id);

            if ($request->proceeds < $bill->debit) {
                return redirect()->back()->with('notification', 'Số tiền thu không đủ để thanh toán hóa đơn.');
            }

            $bill->update([
                'proceeds' => $request->proceeds,
                'amount_return' => $request->proceeds - $bill->debit,
                'debit' => 0,
                'status' => Bill::PAID,
            ]);

            DB::commit();
            return redirect()->route('bills.show', $request->id);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
            return redirect()->route('dashboard')->with('notification', 'Thanh toán thất bại!');
        }
    }

    public function exportBill(Request $request) {
        return Excel::download(new BillExport($request->all()), 'Hoa_don.xlsx');
    }
}