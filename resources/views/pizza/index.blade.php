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
                                <th scope="col">small price</th>
                                <th scope="col">medium price</th>
                                <th scope="col">large price</th>
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
                                        <td>{{ $pizza->pizza_small_price }}</td>
                                        <td>{{ $pizza->pizza_medium_price }}</td>
                                        <td>{{ $pizza->pizza_large_price }}</td>
                                        <td>
                                            <img
                                                src="{{ asset(str_replace('storage', 'storage', $pizza->pizza_image)) }}"
                                                alt="Pizza Image" style="width: 100px; height: auto;">
                                        </td>
                                        <!--adding buttons -->
                                        <td>
                                            <form method="POST" action="{{ route('addToOrder') }}">
                                                @csrf <!-- CSRF token -->
                                                <input type="hidden" name="pizza_id" value="{{ $pizza->id }}">
                                                <label for="pizza_size">Select Size:</label>
                                                <select name="pizza_size" id="pizza_size">
                                                    <option value="small">Small</option>
                                                    <option value="medium">Medium</option>
                                                    <option value="large">Large</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary">Add to Order</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8">No Pizza to display</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">{{ __('Order') }}</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">name</th>
                                <th scope="col">description</th>
                                <th scope="col">Pizza Category</th>
                                <th scope="col">Price</th>
                                <th scope="col">Size</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($items) > 0)
                                @foreach($items as $index => $item)
                                    <!--this adds a key which can be used to identify which order is being removed-->
                                    <tr>
                                        <td>{{ $item['pizza']->pizza_name }}</td>
                                        <td>{{ $item['pizza']->pizza_desc }}</td>
                                        <td>{{ $item['pizza']->pizza_category }}</td>
                                        <td>
                                            @if($item['size'] == 'large')
                                                {{ $item['pizza']->pizza_large_price }}
                                            @elseif($item['size'] == 'medium')
                                                {{ $item['pizza']->pizza_medium_price }}
                                            @elseif($item['size'] == 'small')
                                                {{ $item['pizza']->pizza_small_price }}
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($item['size']) }}</td> <!-- Display the size -->
                                        <td>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{$index}}">Remove order
                                            </button>
                                        </td>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{$index}}" tabindex="-1"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <form action="{{ route('removeFromOrder', ['key' => $index]) }}"
                                                  method="post">
                                                @csrf
                                                @method('delete')
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete
                                                                confirmation</h1>
                                                            <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">Are you sure?</div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close
                                                            </button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">No orders to display</td>
                                </tr>
                            @endif
                            <form action="{{ route('order') }}" method="POST">
                                @csrf
                                <button type="submit">Order</button>
                            </form>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
