@extends("layout.layout")
@section('content')
    <div class="container mt-4">
        <div class="row">
            @if($shopRecords->isEmpty())
                <p class="text-center" style="color:#343957">No Exchange available.</p>
            @else
                @foreach($shopRecords as $record)
                    <div class="col-md-4 mb-4" >
                        <div class="card" style="background:#343957">
                            <img src="{{ asset('storage/' . $record->image_path) }}" style="color:#ffffff; text-align:center" alt="{{ $record->shop_name }}" class="card-img-top">
                            <div class="card-body text-center" style="color:#ffffff" >
                                <form action="{{route('admin.report.dailyReport')}}" method="Post">
                                    @csrf
                                    <input type="hidden" name="shop_id" id="shop_id" value="{{$record->id}}">
                                    <input type="submit" style="background:none; border:none; color:white;" value="{{ $record->shop_name }}">
                                </form> 
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection