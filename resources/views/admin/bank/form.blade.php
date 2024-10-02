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
                                <form class="form-valide" action="{{ route('admin.bank.post') }}" method="post">
                                    @csrf                                    
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="bank_name">Bank Name<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter Bank Name"  required>
                                        </div>
                                        @error('bank_name')
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
