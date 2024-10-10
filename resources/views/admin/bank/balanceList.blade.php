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
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Bank Name</th>
                                    <th>Cash Type</th>
                                    <th>Account Number</th>
                                    <th>Cash Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody style="color:black">
                                @foreach($balanceRecords as $bank)
                                    <tr>
                                        <td>{{$bank->bank_name}}</td>
                                        <td>{{$bank->cash_type}}</td>
                                        <td>{{$bank->account_number}}</td>
                                        <td>{{$bank->cash_amount}}</td>
                                        <td>
                                            <form action="{{ route('balance.destroy') }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this Bank ?');">
                                                @csrf
                                                <input type="hidden" name="bank_id" value="{{$bank->id}}">
                                                <button type="submit" class="btn btn-danger">Delete </button>
                                            </form>
                                        </td>                                        
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Bank Name</th>
                                    <th>Cash Type</th>
                                    <th>Account Number</th>
                                    <th>Cash Amount</th>
                                    <th>Action</th>
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