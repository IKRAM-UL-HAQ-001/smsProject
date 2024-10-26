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
                                <form class="form-valide" action="{{ route('admin.opening_closing_balance.post') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="opening_balance">Opening Balance<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="opening_balance" name="opening_balance" placeholder="Enter a Opening Balance" required>
                                        </div>
                                        @error('opening_balance')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="closing_balance">Closing Balance<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="closing_balance" name="closing_balance" placeholder="Enter a Closing Balance" required>
                                        </div>
                                        @error('closing_balance')
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
