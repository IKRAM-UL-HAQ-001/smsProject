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

        <div class="row">
            @foreach ([
                ['Total Balance', $totalBalance, 'ti-money text-success border-success'],
                ['Total Deposit', $totalDeposit, 'ti-money text-secondary border-secondary'],
                ['Total Withdrawal', $totalWithdrawal, 'ti-money text-danger border-danger'],
                ['Total Expense', $totalExpense, 'ti-link text-danger border-danger'],
                ['Total Bonus', $totalBonus, 'ti-money text-info border-info'],
                ['Total Shops', $totalShops, 'ti-layout-grid2 text-pink border-pink'],
                ['Total Users', $totalUsers, 'ti-user text-primary border-primary'],
                ['Customers', $totalCustomers, 'ti-user text-primary border-primary']
            ] as $card)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="stat-widget-one card-body d-flex align-items-center">
                            <div class="stat-icon d-inline-block">
                                <i class="{{ $card[2] }}"></i>
                            </div>
                            <div class="stat-content d-inline-block ml-3">
                                <div class="stat-text">{{ $card[0] }}</div>
                                <div class="stat-digit">{{ $card[1] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
