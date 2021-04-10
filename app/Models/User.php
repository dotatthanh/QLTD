<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    const ACTIVE = 1;
    const UNACTIVE = 0;
    const DELETE = -1;
    use HasRoles, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'code',
        'address',
        'phone',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function bills()
    {
        return $this->hasMany(Bill::class, 'customer_id');
    }

    public function getPowerNumberAttribute() {
        $request = resolve(Request::class);
        $fromMonth = $request->fromMonth.'-01';
        $toMonth = $request->toMonth.'-01';
        $bills = $this->bills->where('status', Bill::PAID);

        if ($request->fromMonth && $request->toMonth) {
            return $bills->where('period', '>=', $fromMonth)->where('period', '<=', $toMonth)->sum('power_number');
        }
        elseif ($request->fromMonth) {
            return $bills->where('period', '>=', $fromMonth)->sum('power_number');
        }
        elseif ($request->toMonth) {
            return $bills->where('period', '<=', $toMonth)->sum('power_number');
        }

        return $bills->sum('power_number');
    }

    public function getRevenueAttribute() {
        $request = resolve(Request::class);
        $fromMonth = $request->fromMonth.'-01';
        $toMonth = $request->toMonth.'-01';
        $bills = $this->bills->where('status', Bill::PAID);

        if ($request->fromMonth && $request->toMonth) {
            $bills = $bills->where('period', '>=', $fromMonth)->where('period', '<=', $toMonth);
            $proceeds = $bills->sum('proceeds');
            $amount_return = $bills->sum('amount_return');

            return $proceeds - $amount_return;
        }
        elseif ($request->fromMonth) {
            $bills = $bills->where('period', '>=', $fromMonth);
            $proceeds = $bills->sum('proceeds');
            $amount_return = $bills->sum('amount_return');

            return $proceeds - $amount_return;
        }
        elseif ($request->toMonth) {
            $bills = $bills->where('period', '<=', $toMonth);
            // dd($request->toMonth);
            // dd($bills);
            $proceeds = $bills->sum('proceeds');
            $amount_return = $bills->sum('amount_return');

            return $proceeds - $amount_return;
        }

        $proceeds = $bills->sum('proceeds');
        $amount_return = $bills->sum('amount_return');

        return $proceeds - $amount_return;
    }

    public function getDebitAttribute() {
        return $this->bills->where('status', Bill::PAID)->sum('debit');
    }
}
