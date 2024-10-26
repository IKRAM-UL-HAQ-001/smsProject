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
                        <h4 class="card-title">Basic Datatable</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Paid Amount</th>
                                        <th>Remaining Amount</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style="color:black">
                                    @foreach($venderPaymentRecords as $venderPayment)
                                        <tr>
                                            <td>{{$venderPayment->paid_amount}}</td>
                                            <td>{{$venderPayment->remaining_amount}}</td>
                                            <td>{{$venderPayment->status}}</td>
                                            <td>{{$venderPayment->remarks}}</td>
                                            <td>
                                                <form action="{{ route('vender_payment.destroy') }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this vender payment?');">
                                                    @csrf
                                                    <input type="hidden" name="venderPayment_id" value="{{ $venderPayment->id }}">
                                                    <button type="submit" class="btn btn-danger">Delete </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Paid Amount</th>
                                        <th>Remaining Amount</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
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