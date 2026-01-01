@extends('layouts.app')

@section('content')
<div class="hero-wrap" style="background-image: url('{{ asset('images/construction-truck.jpg') }}');">
    </div>

<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            @php
            $categories = [
                ["title" => "Pick Up", "image" => "truk1.png"],
                ["title" => "Fuso", "image" => "truk3.png"],
                // ... kategori lainnya
            ];
            @endphp

            @foreach($categories as $cat)
            <div class="col-md-2 col-6 mb-4">
                <div class="card category-card text-center shadow-sm" data-category="{{ $cat['title'] }}">
                    <img src="{{ asset('images/' . $cat['image']) }}" class="img-fluid mb-2">
                    <h6>{{ $cat['title'] }}</h6>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row">
            @foreach($cars as $car)
            <div class="col-md-4 mb-4 truck-card" data-type="{{ $car['type'] }}">
                <div class="car-wrap rounded shadow-sm p-3" style="background:#fff;">
                    <div class="img mb-3 d-flex justify-content-center">
                        <img src="{{ asset($car['photo']) }}" style="width: 90%;">
                    </div>
                    <div class="text text-center">
                        <h3 class="mb-2">{{ $car['title'] }} <br> {{ $car['year'] }}</h3>
                        <a href="#" class="btn btn-primary mb-3">Book Now</a>
                        <p>{{ $car['desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Script filter Anda tetap sama, cukup pastikan selector-nya benar
</script>
@endpush