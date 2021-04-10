@extends('layouts.default')
@section('content')
	<div class="container">
		<h1 class="title-admin mt-5">NHẬP SỐ ĐIỆN</h1>
			
		<div class="row justify-content-center">
			<div class="col-7">
				<form action="{{ route('import-power-number', $customer->id) }}" method="POST" class="mt-3">
					@csrf
					<div class="form-group row">
					    <label class="col-sm-3 col-form-label">Mã khách hàng</label>
					    <div class="col-sm-9">
					     	<input class="form-control" type="text" value="{{ $customer->code }}" disabled>
					    </div>
					</div>
					<div class="form-group row">
					    <label class="col-sm-3 col-form-label">Tên khách hàng</label>
					    <div class="col-sm-9">
					    	<input class="form-control" type="text" value="{{ $customer->name }}" disabled>
					    </div>
					</div>
					<div class="form-group row">
					    <label for="powerNumber" class="col-sm-3 col-form-label">Số điện</label>
					    <div class="col-sm-9">
					      <input type="number" min="0" class="form-control" name="power_number" id="powerNumber" placeholder="Số điện">
					    </div>
					</div>
					<div class="form-group row">
					    <label for="period" class="col-sm-3 col-form-label">Kỳ thu</label>
					    <div class="col-sm-9">
					    	<input type="month" id="period" name="period" class="form-control w-100">
					    </div>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-success">Lưu lại</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection