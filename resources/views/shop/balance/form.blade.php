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
                                <form class="form-valide" id="bankForm" action="{{ route('shop.balance.post') }}" method="post">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="cash_type">Cash Type<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="js-select2 form-control" id="cash_type" name="cash_type" data-placeholder="Choose one.." required>
                                                <option disabled selected>Choose Cash Type</option>
                                                <option value="add">Add</option>
                                                <option value="minus">Minus</option>
                                            </select>
                                        </div>
                                        @error('cash_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="bank_name">Bank Name<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="js-select2 form-control" id="bank_name" name="bank_name" data-placeholder="Choose one.." required>
                                                <option disabled selected>Choose Bank Name</option>
                                                @foreach($bankBalanceRecords as $bankBalance)
                                                    <option value="{{ $bankBalance->bank_name }}">{{ $bankBalance->bank_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('bank_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="bank_balance">Bank Balance</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="bank_balance" name="bank_balance" readonly>
                                        </div>
                                        @error('bank_balance')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="account_number">Account Number<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="account_number" name="account_number" placeholder="Enter Account Number" required>
                                        </div>
                                        @error('account_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="cash_amount">Cash Amount<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="cash_amount" name="cash_amount" placeholder="Enter Cash Amount" value="{{ old('cash_amount') }}" required>
                                        </div>
                                        @error('cash_amount')
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#bank_name').change(function() {
            var bankName = $(this).val();
            console.log(bankName);  // Corrected variable name
            
            // Disable all form inputs
            $('#bankForm input, #bankForm select').prop('disabled', true);
            
            $.ajax({
                url: '{{ route("shop.balance.getBankBalance") }}', // Define your route here
                type: 'POST', // Use POST method
                data: {
                    bank_name: bankName,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function(response) {
                    // Check if response has a balance property
                    if (response.balance !== undefined) {
                        $('#bank_balance').val(response.balance); // Make sure this input exists
                    } else {
                        console.warn('Balance not found in response:', response);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                },
                complete: function() {
                    // Re-enable all form inputs after the AJAX call is complete
                    $('#bankForm input, #bankForm select').prop('disabled', false);
                }
            });
        });
    });
</script>

@endsection
