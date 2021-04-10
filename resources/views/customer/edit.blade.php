@extends('layouts.default')
@section('content')
	<div class="container">
		<h1 class="title-admin mt-5">CẬP NHẬT KHÁCH HÀNG</h1>
		@if(session('notificationUpdate'))
			<div class="alert alert-danger text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationUpdate') }}
            </div>
		@endif
		<div class="row justify-content-center">
			<div class="col-7">
				<form action="{{ route('customers.update', $customer->id) }}" method="POST" class="mt-3">
					@csrf
					@method('PUT')
					<div class="form-group row">
					    <label for="codeCustomer" class="col-sm-3 col-form-label">Mã khách hàng</label>
					    <div class="col-sm-9">
					    	{{-- <input name="code" type="text" class="form-control" id="codeCustomer" placeholder="Mã khách hàng" disabled value="{{ $customer->code }}">					     --}}
					    	<label class="col-sm-3 col-form-label">{{ $customer->code }}</label>
					    </div>
					</div>
					<div class="form-group row">
					    <label for="nameCustomer" class="col-sm-3 col-form-label">Tên khách hàng</label>
					    <div class="col-sm-9">
					    	<input name="name" type="text" class="form-control" id="nameCustomer" placeholder="Tên khách hàng" value="{{ $customer->name }}">
					    	@if($errors->has('name'))
								<span class="text-danger d-block mt-2">{{ $errors->first('name') }}</span>
							@endif
					    </div>
					</div>
					<div class="form-group row">
					    <label for="emailCustomer" class="col-sm-3 col-form-label">Email</label>
					    <div class="col-sm-9">
					    	<input name="email" type="text" class="form-control" id="emailCustomer" placeholder="Email" value="{{ $customer->email }}">
					    	@if($errors->has('email'))
								<span class="text-danger d-block mt-2">{{ $errors->first('email') }}</span>
							@endif
					    </div>
					</div>
					<div class="form-group row">
					    <label for="phoneCustomer" class="col-sm-3 col-form-label">Số điện thoại</label>
					    <div class="col-sm-9">
					    	<input name="phone" type="number" min="0" class="form-control" id="phoneCustomer" placeholder="Số điện thoại" value="{{ $customer->phone }}">
					    	@if($errors->has('phone'))
								<span class="text-danger d-block mt-2">{{ $errors->first('phone') }}</span>
							@endif
					    </div>
					</div>
					<div class="form-group row">
					    <label for="addressCustomer" class="col-sm-3 col-form-label">Địa chỉ</label>
					    <div class="col-sm-9">
					    	<input name="address" type="text" class="form-control" id="addressCustomer" placeholder="Địa chỉ" value="{{ $customer->address }}">
					    	@if($errors->has('address'))
								<span class="text-danger d-block mt-2">{{ $errors->first('address') }}</span>
							@endif
					    </div>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-success">Cập nhật khách hàng</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection