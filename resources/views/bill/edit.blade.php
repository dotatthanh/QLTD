@extends('layouts.default')
@section('content')
	<div class="container">
		<h1 class="title-admin mt-5">CẬP NHẬT HÓA ĐƠN</h1>
		<div class="row justify-content-center">
			<div class="col-7">
				<form action="{{ route('bills.update', $bill->id) }}" method="POST" class="mt-3">
					@csrf
					@method('PUT')
					<div class="form-group row">
					    <label class="col-sm-3 col-form-label">Mã hóa đơn</label>
					    <div class="col-sm-9">
					    	<label class="col-sm-3 col-form-label">{{ $bill->code }}</label>
					    </div>
					</div>
					<div class="form-group row">
					    <label for="powerNumberBill" class="col-sm-3 col-form-label">Số điện</label>
					    <div class="col-sm-9">
					    	<input name="power_number" value="{{ $bill->power_number }}" type="number" min="0" class="form-control" id="powerNumberBill" placeholder="Số điện" onkeyup="billAmount()">
					    </div>
					</div>
					<div class="form-group row">
					    <label for="amountBill" class="col-sm-3 col-form-label">Số tiền</label>
					    <div class="col-sm-9">
					    	<input name="price" value="{{ $bill->price }}" type="number" min="0" class="form-control" id="amountBill" placeholder="Số tiền" readonly onkeyup="billAmount()">
					    </div>
					</div>
					@if ($bill->status == 1)
						<div class="form-group row">
						    <label for="proceedsBill" class="col-sm-3 col-form-label">Số tiền thu</label>
						    <div class="col-sm-9">
						    	<input name="proceeds" value="{{ $bill->proceeds }}" type="number" min="0" class="form-control" id="proceedsBill" placeholder="Số tiền thu" onkeyup="billAmount()">
						    </div>
						</div>
						<div class="form-group row">
						    <label for="amountReturnBill" class="col-sm-3 col-form-label">Số tiền trả lại</label>
						    <div class="col-sm-9">
						    	<input name="amount_return" value="{{ $bill->amount_return }}" type="number" min="0" class="form-control" id="amountReturnBill" placeholder="Số tiền trả lại">
						    </div>
						</div>
						<div class="form-group row">
						    <label for="debitBill" class="col-sm-3 col-form-label">Số tiền nợ cước</label>
						    <div class="col-sm-9">
						    	<input name="debit" value="{{ $bill->debit }}" type="number" min="0" class="form-control" id="debitBill" placeholder="Số tiền trả lại">
						    </div>
						</div>
					@endif
					<div class="form-group row">
					    <label for="period" class="col-sm-3 col-form-label">Kỳ thu</label>
					    <div class="col-sm-9">
					    	<input value="{{ date_format(new DateTime($bill->period), "Y-m") }}" type="month" id="period" name="period" class="form-control w-100">
					    </div>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-success">Cập nhật hóa đơn</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
@section('script')
	<script type="text/javascript">
		function billAmount() {
			let power_number = $(`input[name='power_number']`).val();
			let price;

			if (power_number <= 50) {
                price = power_number * 1678;
            }
            else if(power_number >= 51 && power_number <= 100) {
                price = 50 * 1678 + (power_number - 50) * 1734;
            }
            else if (power_number >= 101 && power_number <= 200) {
                price = 50 * 1678 + 50 * 1734 + (power_number -100) * 2014;
            }
            else if (power_number >= 201 && power_number <= 300) {
                price = 50 * 1678 + 50 * 1734 + 100 * 2014 + (power_number - 200) * 2536;
            }
            else if (power_number >= 301 && power_number <= 400) {
                price = 50 * 1678 + 50 * 1734 + 100 * 2014 + 100 * 2536 + (power_number - 300) * 2834;
            }
            else if (power_number >= 401) {
                price = 50 * 1678 + 50 * 1734 + 100 * 2014 + 100 * 2536 + 100 * 2834 + (power_number - 400) * 2927;
            }

			$(`input[name='price']`).val(price);
			let proceeds = $(`input[name='proceeds']`).val();

			if (proceeds > price) {
				$(`input[name='amount_return']`).val(proceeds - price);
				$(`input[name='debit']`).val(0);
			}
			else {
				$(`input[name='amount_return']`).val(0);
				$(`input[name='debit']`).val(price - proceeds);
			}
		}
	</script>
@endsection
