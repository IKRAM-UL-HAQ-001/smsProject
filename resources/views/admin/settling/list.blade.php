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
                    <h4 class="card-title">Exchange HK List </h4>
                    <a href="{{ route('export.masterSettlingList') }}" class="btn btn-primary">Download Monthly Master Settling List</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Exchange Name</th>
                                    <th>User Name</th>
                                    <th>White Label</th>
                                    <th>Credit Reff</th>
                                    <th>Settling Point</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody style="color:black">
                                @foreach($settlingRecords as $settlingRecord)
                                    <tr>
                                        <td>{{$settlingRecord->shop->shop_name}}</td>
                                        <td>{{$settlingRecord->user->user_name}}</td>
                                        <td>{{$settlingRecord->white_label}}</td>
                                        <td>{{$settlingRecord->credit_reff}}</td>
                                        <td>{{$settlingRecord->settle_point}}</td>
                                        <td>{{$settlingRecord->price}}</td>
                                        <td>
                                            <form action="{{ route('masterSettling.destroy') }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this Master Settling Entry?');">
                                                @csrf
                                                <input type="hidden" name="masterSettling_id" value="{{$settlingRecord->id}}">
                                                <button type="submit" class="btn btn-danger">Delete </button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Exchage Name</th>
                                    <th>User Name</th>
                                    <th>White Label</th>
                                    <th>Credit Reff</th>
                                    <th>Settling Point</th>
                                    <th>Price</th>
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