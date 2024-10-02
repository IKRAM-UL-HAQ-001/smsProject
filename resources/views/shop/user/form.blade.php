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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Form</a></li>
                </ol>
            </div>
        </div>
        <section id="main-content">
            <div class="row">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-body">
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

                            <div class="form-validation">
                                <form class="form-valide" action="{{ route('shop.user.post') }}" method="post">
                                    @csrf
                                    <div class="form-group row" id="reference_number">
                                        <label class="col-lg-4 col-form-label" for="reference_number">Reference Number<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="reference_number" name="reference_number" placeholder="Enter a Customer Reference Number" value="{{ old('reference_number') }}" >
                                        </div>
                                        @error('reference_number')
                                            <div class="invalid-feedback" style="color: white">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group row " id="customer_name">
                                        <label class="col-lg-4 col-form-label" for="customer_name">Customer Name <span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter a Customer Name" value="{{ old('customer_name') }}">
                                        </div>
                                        @error('customer_name')
                                            <div class="invalid-feedback" style="color: white">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="cash_amount">Amount<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="cash_amount" name="cash_amount" placeholder="Enter Cash Amount" value="{{ old('cash_amount') }}" required>
                                        </div>
                                        @error('cash_amount')
                                            <div class="invalid-feedback" style="color: white">{{ $message }}</div>
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
