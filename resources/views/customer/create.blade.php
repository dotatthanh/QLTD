@extends('layouts.default')
@section('content')
    <div class="container">
		<h1 class="title-admin mt-5">THÊM KHÁCH HÀNG</h1>

		@if(session('notificationAdd'))
			<div class="alert alert-danger text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationAdd') }}
            </div>
		@endif

		<div class="row justify-content-center">
			<div class="col-7">
				<form action="{{ route('customers.store') }}" method="POST" class="mt-3">
					@csrf
					<div class="form-group row">
					    <label for="emailCustomer" class="col-sm-3 col-form-label">Email khách hàng</label>
					    <div class="col-sm-9">
					      <input type="email" name="email" class="form-control" id="emailCustomer" placeholder="Email khách hàng" value="{{ old('email') }}">
					      @if($errors->has('email'))
								<span class="text-danger d-block mt-2">{{ $errors->first('email') }}</span>
							@endif
					    </div>
					</div>
					<div class="form-group row">
					    <label for="nameCustomer" class="col-sm-3 col-form-label">Tên khách hàng</label>
					    <div class="col-sm-9">
					      <input type="text" name="name" class="form-control" id="nameCustomer" placeholder="Tên khách hàng" value="{{ old('name') }}">
					      @if($errors->has('name'))
								<span class="text-danger d-block mt-2">{{ $errors->first('name') }}</span>
							@endif
					    </div>
					</div>
					<div class="form-group row">
					    <label for="phoneCustomer" class="col-sm-3 col-form-label">Số điện thoại</label>
					    <div class="col-sm-9">
					      <input type="number" name="phone" min="0" class="form-control" id="phoneCustomer" placeholder="Số điện thoại" value="{{ old('phone') }}">
					      @if($errors->has('phone'))
								<span class="text-danger d-block mt-2">{{ $errors->first('phone') }}</span>
							@endif
					    </div>
					</div>
					<div class="form-group row">
					    <label for="addressCustomer" class="col-sm-3 col-form-label">Địa chỉ</label>
					    <div class="col-sm-9">
					      <input type="text" name="address" class="form-control" id="addressCustomer" placeholder="Địa chỉ" value="{{ old('address') }}">
					      @if($errors->has('address'))
								<span class="text-danger d-block mt-2">{{ $errors->first('address') }}</span>
							@endif
					    </div>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-success">Thêm khách hàng</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection