@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('All Pizza') }}</div>
                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        {{-- adding the bootstrap style for the table --}}
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">number</th>
                                <th scope="col">name</th>
                                <th scope="col">description</th>
                                <th scope="col">Pizza Category</th>
                                <th scope="col">Large price</th>
                                <th scope="col">medium price</th>
                                <th scope="col">small price</th>
                                <th scope="col">image</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- pulling the table data --}}
                            @if(count($pizzas)>0)
                                @foreach($pizzas as $pizza)
                                    <tr>
                                        <th scope="row">{{ $pizza->id }}</th>
                                        <td>{{ $pizza->pizza_name }}</td>
                                        <td>{{ $pizza->pizza_desc }}</td>
                                        <td>{{ $pizza->pizza_category}}</td>
                                        <td>{{ $pizza->pizza_large_price }}</td>
                                        <td>{{ $pizza->pizza_medium_price }}</td>
                                        <td>{{ $pizza->pizza_small_price }}</td>
                                        <td>
                                            <img src="{{ asset(str_replace('storage', 'storage', $pizza->pizza_image)) }}" alt="Pizza Image" style="width: 100px; height: auto;">
                                        </td>
                                        <!--adding buttons -->
                                        <td><a href="{{route('pizza.edit',$pizza->id)}}"><button class="btn btn-primary">Edit</button></a></td>
                                        <td><button class="btn btn-danger"data-bs-toggle="modal" data-bs-target="#exampleModal{{$pizza->id}}">Delete</button></td>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{$pizza->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <form action="{{route('pizza.destroy', $pizza->id)}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete confirmation</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body"> Are you sure? </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end of modal bootstrap code -->

                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="8">No Pizza to display</td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
