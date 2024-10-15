@extends("layout.layout")

@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <p class="mb-0">Update user</p> 
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Update Revenue</a></li>
                </ol>
            </div>
        </div>
        <section id="main-content">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-validation">
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form class="form-valide" action="{{route('revenue.update')}}" method="post">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <input type="hidden" class="form-control" id="revenue_id" name="revenue_id" value="{{$revenueRecords->id}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{$revenueRecords->user_id}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <input type="hidden" class="form-control" id="shop_id" name="shop_id" value="{{$revenueRecords->shop_id}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="reference_number">Reference Number <span class="text-danger">*</span></label>
                                        <div class="col-lg-8">

                                            <input type="text" class="form-control" id="reference_number" name="reference_number" value="{{$revenueRecords->reference_number}}" >
                                        </div>
                                        @error('reference_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="customer_name">Customer Name<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{$revenueRecords->customer_name}}" required>
                                        </div>
                                        @error('customer_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="cash_amount">Cash Amount<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="cash_amount" name="cash_amount" value="{{$revenueRecords->cash_amount}}" required>
                                        </div>
                                        @error('cash_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="cash_type">Cash Type<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="js-select2 form-control" id="cash_type" name="cash_type">
                                                <option disabled selected>Choose Cash Type</option>
                                                <option value="deposit" >Deposit</option>
                                                <option value="withdrawal" >Withdrawal</option>
                                            </select>
                                        </div>
                                        @error('cash_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="bonus_amount">Bonus Amount<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="bonus_amount" name="bonus_amount" value="{{$revenueRecords->bonus_amount}}" >
                                        </div>
                                        @error('bonus_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group" id="payment-type-field">
                                        <div class="row">
                                            <label class="col-form-label col-lg-4 ">Payment Type<span class="text-danger">*</span></label>
                                            <div class="col-lg-8">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="payment_type" name="payment_type" value="google_pay">
                                                    <label class="form-check-label" for="payment_type">
                                                        Google Pay 
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="payment_type" name="payment_type" value="phone_pay">
                                                    <label class="form-check-label" for="payment_type">
                                                        Phone Pay
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="payment_type" name="payment_type" value="imps">
                                                    <label class="form-check-label" for="payment_type">
                                                        IMPS 
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="payment_type" name="payment_type" value="neft">
                                                    <label class="form-check-label" for="payment_type">
                                                        NEFT
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="payment_type" name="payment_type" value="i20_pay">
                                                    <label class="form-check-label" for="payment_type">
                                                        I20 Pay
                                                    </label>
                                                </div>
                                            </div>
                                            @error('payment_type')
                                            <div class="invalid-feedback" style="color: white">{{ $message }}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="remarks">Remarks<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="remarks" name="remarks" value="{{$revenueRecords->remarks}}" required>
                                        </div>
                                        @error('remarks')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-8 ml-auto">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
