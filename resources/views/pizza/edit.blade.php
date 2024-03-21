@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
    //================= add the error message
                @if(count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif
  //=============================
                <div class="card">
                    <div class="card-header">{{ __('Edit Pizza') }}</div>
                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form action="{{ route('pizza.update', $pizza->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="pizza_name">Name of Pizza</label>
                                <input type="text" class="form-control" name="pizza_name" value="{{ $pizza->pizza_name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="pizza_desc">Description</label>
                                <textarea class="form-control" name="pizza_desc" required>{{ $pizza->pizza_desc }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="pizza_category">Category</label>
                                <select class="form-control" name="pizza_category" required>
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ $pizza->pizza_category == $category ? 'selected' : '' }}>{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="pizza_large_price">Large Pizza Price</label>
                                <input type="number" class="form-control" name="pizza_large_price" value="{{ $pizza->pizza_large_price }}" required>
                            </div>

                            <div class="form-group">
                                <label for="pizza_medium_price">Medium Pizza Price</label>
                                <input type="number" class="form-control" name="pizza_medium_price" value="{{ $pizza->pizza_medium_price }}" required>
                            </div>

                            <div class="form-group">
                                <label for="pizza_small_price">Small Pizza Price</label>
                                <input type="number" class="form-control" name="pizza_small_price" value="{{ $pizza->pizza_small_price }}" required>
                            </div>

                            <div class="form-group">
                                <label for="pizza_image">Image</label>
                                <input type="file" class="form-control-file" name="pizza_image">
                                <td>
                                    <img src="{{ asset(str_replace('storage', 'storage', $pizza->pizza_image)) }}" alt="Pizza Image" style="width: 100px; height: auto;">
                                </td>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Update Pizza</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
