<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frankies Exchange</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            @if($shopRecords->isEmpty())
                <p class="text-center" style="color:#343957">No shops available.</p>
            @else
                @foreach($shopRecords as $record)
                    <div class="col-md-4 mb-4" >
                        <div class="card" style="background:#343957">
                            <img src="{{ asset('storage/' . $record->image_path) }}" style="color:#ffffff; text-align:center" alt="{{ $record->shop_name }}" class="card-img-top">
                            <div class="card-body" style="color:#ffffff">
                                <h5 class="card-title text-center"><a href="{{ url('auth/login') }}" style="color:#ffffff">{{ $record->shop_name }}</a></h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <footer class="bg-light text-center py-4">
        <p>&copy; 2024 My Website</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>