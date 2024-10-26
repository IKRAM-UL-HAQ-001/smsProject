@extends("layout.layout")

@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <p class="mb-0">Your business dashboard template</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Layout</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Blank</a></li>
                </ol>
            </div>
        </div>
        <section id="main-content">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="form-validation">
                                <form class="form-valide" action="{{ route('admin.vender_payment.post') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="paid_amount">Paid Amount<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="paid_amount" name="paid_amount" placeholder="Enter a Paid Amount" required>
                                        </div>
                                        @error('paid_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="remaining_amount">Remaining Amount<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="remaining_amount" name="remaining_amount" placeholder="Enter a Remaining Amount" required>
                                        </div>
                                        @error('remaining_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>                                    
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="payment_status">Select Payment Type<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="js-select2 form-control" id="payment_status" name="payment_status" data-placeholder="Choose one.." required>
                                                <option disabled selected>Choose Payment Option</option>
                                                    <option value="rent" >Rent</option>
                                                    <option value="salary" >salary</option>
                                                    <option value="pati_cash" >Pati Cash</option>
                                                    <option value="bank_payment" >Bank Payment</option>
                                                    <option value="master_payment" >Master Payment</option>
                                                    <option value="general_expense" >General Expense</option>
                                            </select>
                                        </div>
                                        @error('payment_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="remarks">Remarks<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter Remarks" required>
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
