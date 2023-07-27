@extends('master')

@section('content')

    <div class="container">
        <div class="row mt-5">
            <div class="col-5">
                <div class="p-3">
                    @if (session('insertSuccess'))
                        <div class="alert-message">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('insertSuccess') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                        </div>
                    @endif

                    @if (session('updateSuccess'))
                        <div class="alert-message">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>{{ session('updateSuccess') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                        </div>
                    @endif

                    @if (session('deleteSuccess'))
                        <div class="alert-message">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ session('deleteSuccess') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                        </div>
                    @endif

                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error )
                                    <li> {{ $error }} </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    <form action="{{ route('post#create') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="text-group mb-3">
                            <label for="">Post Title</label>
                            <input type="text" name="postTitle" id="" value="{{ old('postTitle') }}" class="form-control @error('postTitle') is-invalid @enderror" placeholder="Enter the title...">
                            @error('postTitle')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="text-group mb-3">
                            <label for="">Post Description</label>
                            <textarea name="postDescription" class="form-control @error('postDescription') is-invalid @enderror" id="" cols="30" rows="10" placeholder="Enter Post Description...">{{ old('postDescription') }}</textarea>
                            @error('postDescription')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="text-group mb-3">
                            <label for="">Image</label>
                            <input type="file" name="postImage" id="" value="{{ old('postImage') }}" class="form-control">
                            @error('postImage')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="text-group mb-3">
                            <label for="">Fees</label>
                            <input type="number" name="postFee" id="" value="{{ old('postFee') }}" class="form-control @error('postFee') is-invalid @enderror" placeholder="Enter post Fees...">
                            @error('postFee')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="text-group mb-3">
                            <label for="">Address</label>
                            <input type="text" name="postAddress" id="" value="{{ old('postAddress') }}" class="form-control @error('postAddress') is-invalid @enderror" placeholder="Enter the Address...">
                            @error('postAddress')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="text-group mb-3">
                            <label for="">Rating</label>
                            <input type="number" name="postRating" id="" value="{{ old('postRating') }}" class="form-control @error('postRating') is-invalid @enderror" placeholder="Enter the Rating...">
                            @error('postRating')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="submit" value="Create" class="btn btn-danger">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-7">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-5">
                            Total - {{ $posts->total() }}
                        </div>
                        <div class="col-5 offset-2">
                            <form action="{{ route('post#createPage') }}" method="get">
                                <div class="d-flex">
                                    <input type="text" name="searchKey" value="{{request('searchKey')}}" id="" class="form-control" placeholder="Enter Search Key...">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="data-container">
                    @if (count($posts) != 0)
                        {{-- @for ($i=0; $i<4; $i++) --}}
                        @foreach ($posts as $item)

                        <div class="post p-3 shadow-sm mb-4">
                            <div class="row">
                                <div class="col-9">
                                    <h5>{{ $item->title }}</h5>
                                    <p class="text-muted">{{ Str::words($item->description, 10, '...') }}</p>
                                </div>
                                <small class="col-2 offset-1">
                                    {{-- {{ $item->created_at->format("d/m/Y | n:i:A") }} --}}
                                    {{ $item->created_at->format("j-F-Y") }}

                                </small>
                            </div>
                            <div class="d-flex gap-3">
                                <span class="">
                                    <small>
                                        <i class="fa-solid fa-money-bill-1 text-primary"></i>
                                        {{ $item->price }} <i class="fa fa-dollar" aria-hidden="true"></i>
                                    </small>|
                                </span>
                                <span>
                                    <small>
                                        <i class="fa-solid fa-location-dot text-danger">
                                            {{ $item->address }}
                                        </i>
                                    </small>|
                                </span>
                                <span>
                                    <small>
                                        {{ $item->rating }}

                                        @if ($item->rating==0)
                                            <i class="fa-solid fa-star text-black-50 "></i>
                                        @else
                                            @for ($i=0; $i<$item->rating; $i++)
                                                <i class="fa-solid fa-star text-warning"></i>
                                            @endfor
                                        @endif
                                    </small>

                                </span>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('post#delete', $item->id) }}" style="display: inline-block;">
                                    <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash" style="padding-right: 4px;"></i>Delete</button>
                                </a>
                                <a href="{{ route('post#updatePage', $item->id) }}">
                                    <button class="btn btn-sm btn-primary"><i class="fa-solid fa-file-lines" style="padding-right: 4px;"></i>View the details</button>
                                </a>
                            </div>
                        </div>

                        @endforeach
                        {{-- @endfor --}}
                    @else
                        <h3 class="text-danger text-center">There is no data.</h3>
                    @endif
                </div>

                {{ $posts->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

@endsection
