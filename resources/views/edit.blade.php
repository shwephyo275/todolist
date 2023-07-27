@extends('master')

@section('content')

    <div class="container">
        <div class="row mt-5">
            <div class="col-6 offset-3">
                <div class="my-3">
                    <a href="{{ route('post#updatePage', $post['id']) }}" class="text-decoration-none text-black">
                        <i class="fa-solid fa-arrow-left"></i>back
                    </a>
                </div>

                <form action="{{ route('post#update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label>Post Title</label>
                    <input type="hidden" name="postId" value="{{ $post['id'] }}">
                    <input type="text" name="postTitle" class="form-control my-3 @error('postTitle')is-invalid @enderror" value="{{ old('postTitle', $post['title']) }}" placeholder="Enter post title...">
                    @error('postTitle')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="">Image</label>
                    <div>
                        @if ($post['image'] == null)
                            <img src="{{ asset('storage/404_image.png') }}" alt="" class="img-thumbnail my-4 shadow-sm">
                        @else
                            <img src="{{ asset('storage/'. $post['image']) }}" alt="" class="img-thumbnail my-4 shadow-sm">
                        @endif
                    </div>
                    <input type="file" name="postImage" id="" value="{{ old('postImage') }}" class="form-control">
                    @error('postImage')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    <label>Post Description</label>
                    <textarea name="postDescription" id="" cols="30" rows="10" class="form-control my-3" placeholder="Enter post description...">{{ old('postDescription', $post['description']) }}</textarea>
                    @error('postDescription')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="">Fees</label>
                    <input type="number" name="postFee" id="" value="{{ old('postFee', $post['price']) }}" class="form-control my-3" placeholder="Enter post Fees...">

                    <label for="">Address</label>
                    <input type="text" name="postAddress" id="" value="{{ old('postAddress', $post['address']) }}" class="form-control my-3" placeholder="Enter post Address...">

                    <label for="">Rating</label>
                    <input type="number" name="postRating" id="" value="{{ old('postRating', $post['rating']) }}" class="form-control my-3" placeholder="Enter post Rating...">

                    <input type="submit" value="Update" class="btn bg-dark text-white my-3 float-end">
                </form>
            </div>
        </div>
    </div>


@endsection
