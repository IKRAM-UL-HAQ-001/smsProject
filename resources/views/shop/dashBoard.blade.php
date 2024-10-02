@extends("layout.layout")

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>Daily Bases Transaction Record</h4><h3>{{$shop_name}}</h3>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Layout</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Dashboard</a></li>
            </ol>
        </div>
    </div>

    <div class="row text-light">
        @foreach ([
            ['Total Balance', $totalBalanceDaily, 'ti-money text-light border-light'],
            ['Total Deposit', $totalDepositDaily, 'ti-money text-light border-light'],
            ['Total Withdrawal', $totalWithdrawalDaily, 'ti-money text-light border-light'],
            ['Total Expense', $totalExpenseDaily, 'ti-money text-light border-light'],
            ['Total Bonus', $totalBonusDaily, 'ti-money text-light border-light'],
            ['Exchange User', $userCount, 'ti-user text-light border-light'],
            ['Total Exchange Customer', $customerCountDaily, 'ti-user text-light border-light'],
            ['Total HK Amount', $totalHkDaily, 'ti-money text-light border-light'],
            ['Total New IDs', $totalNewIdsCreatedDaily, 'ti-money text-light border-light'],
        ] as $card)
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card h-100" style="background:#343957">
                    <div class="stat-widget-one card-body d-flex align-items-center">
                        <div class="stat-icon d-inline-block">
                            <i class="{{ $card[2] }}"></i>
                        </div>
                        <div class="stat-content d-inline-block ml-3">
                            <div class="stat-text text-light">
                                <h4 class="text-light">{{ $card[0] }}</h4>
                            </div>
                            <div class="stat-digit text-light">{{ $card[1] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>Monthly Bases Transaction Record</h4>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Layout</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Dashboard</a></li>
            </ol>
        </div>
    </div>

    <div class="row text-light">
        @foreach ([
            ['Total Balance', $totalBalanceMonthly, 'ti-money text-light border-light'],
            ['Total Deposit', $totalDepositMonthly, 'ti-money text-light border-light'],
            ['Total Withdrawal', $totalWithdrawalMonthly, 'ti-money text-light border-light'],
            ['Total Expense', $totalExpenseMonthly, 'ti-money text-light border-light'],
            ['Total Bonus', $totalBonusMonthly, 'ti-money text-light border-light'],
            ['Exchange User', $userCount, 'ti-user text-light border-light'],
            ['Total Exchange Customer', $customerCountMonthly, 'ti-user text-light border-light'],
            ['Total HK Amount', $totalHkMonthly, 'ti-money text-light border-light'],
            ['Total New IDs', $totalNewIdsCreatedMonthly, 'ti-money text-light border-light'],
        ] as $card)
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card h-100" style="background:#343957">
                    <div class="stat-widget-one card-body d-flex align-items-center">
                        <div class="stat-icon d-inline-block">
                            <i class="{{ $card[2] }}"></i>
                        </div>
                        <div class="stat-content d-inline-block ml-3">
                            <div class="stat-text text-light">
                                <h4 class="text-light">{{ $card[0] }}</h4>
                            </div>
                            <div class="stat-digit text-light">{{ $card[1] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
