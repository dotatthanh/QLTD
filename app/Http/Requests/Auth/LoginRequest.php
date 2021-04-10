<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'email.min' => 'Tên sách không được trống.',
    //         'name.unique' => 'Sách đã tồn tại.',
    //         'name.max'  => 'Tên sách không được phép vượt quá 100 kí tự.',
    //         'img.required'  => 'Ảnh không được trống.',
    //         'amount.required'  => 'Số lượng không được trống.',
    //         'amount.min'  => 'Số lượng lớn hơn 0.',
    //         'price.required'  => 'Đơn giá không được trống.',
    //         'price.min'  => 'Đơn giá lớn hơn 0.',
    //         'cover_price.required'  => 'Giá bìa không được trống.',
    //         'cover_price.min'  => 'Giá bìa lớn hơn 0.',
    //         'sale.required'  => 'Giảm giá không được trống.',
    //         'sale.min'  => 'Giảm giá lớn hơn hoặc bằng 0.',
    //         'content.required'  => 'Tóm tắt nội dung không được trống.',
    //     ];
    // }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        // dd($this->email);
        // dd(User::where('email', $this->email)->first()->status < 1);

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->filled('remember')) || User::where('email', $this->email)->first()->status < 1) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}
