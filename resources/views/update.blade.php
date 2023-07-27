@extends('master')

@section('content')

    <div class="container">
        <div class="row mt-5">
            <div class="col-6 offset-3">
                <div class="my-3">
                    <a href="{{ route('post#home') }}" class="text-decoration-none text-black">
                        <i class="fa-solid fa-arrow-left"></i>back
                    </a>
                </div>
                {{-- <h3>{{ $post[0]['title'] }}</h3> if use get() --}}
                {{-- <h3>{{ $post['title'] }}</h3>
                <p class="text-muted">
                    {{ $post['description'] }}
                </p> --}}

                <h3>{{ $post->title }}</h3>
                <div class="flex">
                    <div class="btn btn-sm bg-dark text-white me-2 my-3">
                        <i class="fa-solid fa-money-bill-1 text-primary"></i>
                        $ {{ $post->price }}
                    </div>


                <div class="btn btn-sm bg-dark text-white me-2 my-3">
                    <i class="fa-solid fa-location-dot text-danger"></i>
                    {{ $post->address }}
                </div>

                <div class="btn btn-sm bg-dark text-white me-2 my-3">
                    {{ $post->rating }}
                    <i class="fa-solid fa-star text-warning"></i>
                </div>

                <div class="btn btn-sm bg-dark text-white me-2 my-3">
                    <i class="fa-solid fa-calendar-day"></i>
                    {{ $post->created_at->format("j-f-Y") }}
                </div>

                <div class="btn btn-sm bg-dark text-white me-2 my-3">
                    <i class="fa-solid fa-clock"></i>
                    {{ $post->created_at->format("h:m:s:A") }}
                </div>

              </div>
                <div>
                    @if ($post->image == null)
                        <img src="{{ asset('storage/404_image.png') }}" alt="" class="img-thumbnail my-4 shadow-sm">
                    @else
                        <img src="{{ asset('storage/'. $post->image) }}" alt="" class="img-thumbnail my-4 shadow-sm">
                    @endif
                </div>

                <p class="text-muted">
                    {{ $post->description }}
                </p>
                {{ $post->created_at->format("j-F-Y") }}
            </div>
        </div>

        <div class="row my-3">
            <div class="col-3 offset-8">
                <a href="{{ route('post#editPage', $post['id']) }}">
                    <button class="btn btn-dark text-white">Edit</button>
                </a>
            </div>
        </div>
    </div>


@endsection
