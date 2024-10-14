@extends("layout.layout")
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>Hi, welcome back!</h4>
                <span class="ml-1">Datatable</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Datatable</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Exchange Revenue List Detail</h4>
                    <a href="{{ route('export.deposits') }}" class="btn btn-primary">Download Deposit Transactions</a>
                    <a href="{{ route('export.withdrawals') }}" class="btn btn-primary">Download Withdrawal Transactions</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Exchange Name</th>
                                    <th>User Name</th>
                                    <th>Customer Name</th>
                                    <th>Cash Type</th>
                                    <th>Payment Method</th>
                                    <th>Cash Amount</th>
                                    <th>Bouns Amount</th>
                                    <th>Total Balance</th>
                                    <th>Remarks</th>
                                    <th>Date & Time</th>
                                    
                                </tr>
                            </thead>
                            <tbody style="color:black">
                                @foreach($revenueRecords as $revenue)
                                    <tr>
                                        <td>{{$revenue->shop->shop_name}}</td>
                                        <td>{{ $userNames[$revenue->user_id] ?? 'Unknown' }}</td>
                                        <td>{{$revenue->customer_name}}</td>
                                        <td>{{$revenue->cash_type}}</td>
                                        <td>{{$revenue->payment_type}}</td>
                                        <td>{{$revenue->cash_amount}}</td>
                                        <td>{{$revenue->bonus_amount}}</td>
                                        <td>{{$revenue->total_balance}}</td>
                                        <td>{{$revenue->remarks}}</td>
                                        <td>{{$revenue->created_at}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Exchange Name</th>
                                    <th>User Name</th>
                                    <th>Customer Name</th>
                                    <th>Cash Type</th>
                                    <th>Payment Method</th>
                                    <th>Cash Amount</th>
                                    <th>Bonus Amount</th>
                                    <th>Total Balance</th>
                                    <th>Remarks</th>
                                    <th>Date & Time</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    </div>
</div>
@endsection
