@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif



                <div class="card">
                    <div class="card-header">{{ __('Menu') }}</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-action">
                                <a href="{{ route('pizza.index') }}" class="text-decoration-none">View</a>
                            </li>
                            <li class="list-group-item list-group-item-action">
                                <a href="{{ route('pizza.create') }}" class="text-decoration-none">Create</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card m-5">
                    <div class="card-body">
                        @if(count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ ('Create a Pizza') }}</div>

                    <form action="{{ route('pizza.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name of Pizza</label>
                                <input type="text" class="form-control" name="pizza_name" placeholder="name of pizza">
                            </div>
                            <div class="form-group">
                                <label for="description">Description Pizza</label>
                                <textarea class="form-control" name="pizza_desc"></textarea>
                            </div>
                            <div class="form-inline">
                                <label> Pizza price (£)</label>
                                <input type="number" name="pizza_small_price" class="form-control" placeholder="Small pizza price">
                                <input type="number" name="pizza_medium_price" class="form-control" placeholder="Medium pizza price">
                                <input type="number" name="pizza_large_price" class="form-control" placeholder="Large pizza price">
                            </div>
                            <div class="form-group">
                                <label for="category">Category Pizza</label>
                                <select class="form-control" name="pizza_category">
                                    <option value=""></option>
                                    <option value="veggie">Veggie</option>
                                    <option value="meat feast">Meat feast</option>
                                    <option value="margherita">Margherita</option>
                                    <option value="margherita">Meaty Halal</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label> Image </label>
                                <input type="file" name="pizza_image" class="form-control">
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
