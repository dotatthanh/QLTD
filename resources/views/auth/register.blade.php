<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="mt-3 d-block">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Họ và tên')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"  autofocus />
            </div>

            <!-- Address -->
            <div class="mt-4">
                <x-label for="address" :value="__('Địa chỉ')" />

                <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')"  autofocus />
            </div>

            <!-- phone -->
            <div class="mt-4">
                <x-label for="phone" :value="__('Số điện thoại')" />

                <x-input id="phone" class="block mt-1 w-full" type="number" name="phone" :value="old('phone')"  autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"  />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Mật khẩu')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                 autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Xác nhận mật khẩu')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation"  />
            </div>

            <div class="form-check mt-4">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="is_customer">
                <label class="form-check-label mt-1" for="exampleCheck1">Đăng ký là khách hàng</label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Đã đăng ký?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Đăng ký') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
