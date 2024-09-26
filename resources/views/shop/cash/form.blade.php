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
                                <form class="form-valide" action="{{ route('shop.cash.post') }}" method="post">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="cash_type">Cash Type<span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="js-select2 form-control" id="cash_type" name="cash_type" data-placeholder="Choose one.." required>
                                                <option disabled selected>Choose Cash Type</option>
                                                <option value="deposit" >Deposit</option>
                                                <option value="withdrawal" >Withdrawal</option>
                                                <option value="expense" >Expense</option>
                                            </select>
                                        </div>
                                        @error('cash_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
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
                                    <div class="form-group row" id="bonus-amount-field">
                                        <label class="col-lg-4 col-form-label" for="bonus_amount">Bonus Amount <span class="text-pink">(optional)</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="bonus_amount" name="bonus_amount" placeholder="Enter Bonus Amount if any">
                                        </div>
                                        @error('bonus_amount')
                                            <div class="invalid-feedback" style="color: white">{{ $message }}</div>
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
                                        <label class="col-lg-4 col-form-label" for="remarks">Remarks <span class="text-pink">(optional)</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter Remarks if any" value="{{ old('remarks') }}">
                                        </div>
                                        @error('remarks')
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cashTypeSelect = document.getElementById('cash_type');
            const bonusAmountField = document.getElementById('bonus-amount-field');
            const paymentTypeField = document.getElementById('payment-type-field');
            const referenceNumberField = document.getElementById('reference_number'); // Correct ID for reference number
            const customerNameField = document.getElementById('customer_name'); // Correct ID for customer name

            function toggleFields() {
                if (cashTypeSelect.value === 'deposit') {
                    bonusAmountField.style.display = 'flex';
                    referenceNumberField.style.display = 'flex';
                    customerNameField.style.display = 'flex';
                    paymentTypeField.style.display = 'block'; // Show payment type
                } else if (cashTypeSelect.value === 'expense') {
                    bonusAmountField.style.display = 'none';
                    referenceNumberField.style.display = 'none';
                    customerNameField.style.display = 'none';
                    paymentTypeField.style.display = 'none'; // Hide payment type
                } else if (cashTypeSelect.value === 'withdrawal') {
                    bonusAmountField.style.display = 'none';
                    referenceNumberField.style.display = 'none';
                    customerNameField.style.display = 'flex';
                    paymentTypeField.style.display = 'none'; // Hide payment type
                } else {
                    bonusAmountField.style.display = 'none';
                    referenceNumberField.style.display = 'none'; // Keep reference number visible for withdrawal
                    customerNameField.style.display = 'none'; // Keep customer name visible for withdrawal
                    paymentTypeField.style.display = 'none'; // Hide payment type
                }
            }

            // Initial check in case the form is pre-filled
            toggleFields();

            // Attach event listener to the select element
            cashTypeSelect.addEventListener('change', toggleFields);
        });
    </script>


@endsection
