@extends("layout.layout")
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>Hi, welcome back to </h4><h3>{{$shop_name}} </h3>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Layout</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Dashboard</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        <i class="ti-money text-success border-success"></i>
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">Total Balance</div>
                        <div class="stat-digit">{{$totalBalance}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        <i class="ti-money text-dark border-dark"></i>
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">Total Deposit</div>
                        <div class="stat-digit">{{$totalDeposit}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        <i class="ti-money text-danger border-danger"></i>
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">Total Withdrawal</div>
                        <div class="stat-digit">{{$totalWithdrawal}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        <i class="ti-money text-danger border-danger"></i>
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">Total Expense</div>
                        <div class="stat-digit">{{$totalExpense}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        <i class="ti-money text-info border-info"></i>
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">Total Bonus</div>
                        <div class="stat-digit">{{$totalBonus}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        <i class="ti-user text-primary border-primary"></i>
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">Shop User</div>
                        <div class="stat-digit">{{$userCount}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        <i class="ti-user text-primary border-primary"></i>
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">Total Exchange Customer</div>
                        <div class="stat-digit">{{$customerCount}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection