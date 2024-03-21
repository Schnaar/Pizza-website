<?php

namespace App\Http\Controllers;
use App\Http\Requests\PizzaStoreRequest;
use App\Http\Requests\PizzaUpdateRequest;
use App\Models\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $orders = [];
    public function index()
    {
        $pizzas = Pizza::all(); // Retrieve all pizzas from the database
        return view('pizza.index', ['pizzas' => $pizzas, 'orders' => $this->orders]);

    }
    public function admin()
    {
        $pizza=Pizza::all();
        return view('pizza.admin',['pizzas'=>$pizza]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Retrieve distinct categories from the pizzas
        $categories = Pizza::select('pizza_category')->distinct()->pluck('pizza_category');
        return view('pizza.create', compact('categories'));
    }
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PizzaStoreRequest $request)
    {
        // Store the image in the 'storage/app/public/pizza/images' directory
        $path = $request->file('pizza_image')->store('public/pizza/images');

        // Convert the path to a URL-friendly path
        $relativePath = str_replace('public/', 'storage/', $path);

        // Create a new pizza record with the correct image path
        Pizza::create([
            'pizza_name' => $request->pizza_name,
            'pizza_desc' => $request->pizza_desc,
            'pizza_large_price' => $request->pizza_large_price,
            'pizza_medium_price' => $request->pizza_medium_price,
            'pizza_small_price' => $request->pizza_small_price,
            'pizza_category' => $request->pizza_category,
            'pizza_image' => $relativePath, // Store the modified path here
        ]);

        // Redirect back to the create view with a success message
        return redirect()->route('admin')->with('message', 'Pizza added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Placeholder method
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pizza = Pizza::findOrFail($id);
        // Retrieve distinct categories from the pizzas
        $categories = Pizza::select('pizza_category')->distinct()->pluck('pizza_category');
        return view('pizza.edit', compact('pizza', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PizzaUpdateRequest $request, string $id)
    {
        // First, find the pizza record to ensure it exists
        $pizza = Pizza::find($id);

        // If the pizza doesn't exist, redirect or return an error
        if (!$pizza) {
            return back()->withErrors(['message' => 'Pizza not found']);
            // For an API response, you might return a JSON response
            return response()->json(['message' => 'Pizza not found'], 404);
        }

        // Check if a new image was uploaded
        if ($request->hasFile('pizza_image')) {
            // Store the new image and get its path
            $path = $request->file('pizza_image')->store('public/pizza/images');

            // Convert the path to a URL-friendly path
            $relativePath = str_replace('public/', 'storage/', $path);

            // Update the pizza image path
            $pizza->pizza_image = $relativePath;
        }

        // Update other pizza properties from the request
        $pizza->pizza_name = $request->pizza_name;
        $pizza->pizza_desc = $request->pizza_desc;
        $pizza->pizza_large_price = $request->pizza_large_price;
        $pizza->pizza_medium_price = $request->pizza_medium_price;
        $pizza->pizza_small_price = $request->pizza_small_price;
        $pizza->pizza_category = $request->pizza_category;

        // Save the updated pizza record
        $pizza->save();

        // Redirect to a given route with a success message
        return redirect()->route('admin')->with('message', 'Pizza updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pizza::find($id)->delete();
        return redirect()->route('admin')->with('message', 'Pizza deleted successfully');
    }

    public function addToOrder(Request $request){
        $pizzaId = $request->input('pizza_id');
        $size = $request->input('pizza_size'); // Corrected input name to 'pizza_size'

        // Perform any necessary validation or checks here

        // Add the pizza to the order
        $this->addToOrderLogic($pizzaId, $size);

        // Retrieve orders from session storage
        $orders = session('orders', []);

        // Retrieve pizzas from the database
        $pizzas = Pizza::all();

        // Redirect back or to a specific route
        return view('pizza.index', ['pizzas' => $pizzas, 'orders' => $orders]);
    }

    private function addToOrderLogic($pizzaId, $size) {
        $pizza = Pizza::find($pizzaId);

        // Retrieve orders from session storage
        $orders = session('orders', []);

        // Append the new order to the existing array
        $orders[] = ['pizza' => $pizza, 'size' => $size];

        // Store updated orders back into session storage so that they remain
        session(['orders' => $orders]);
    }
    public function removeFromOrder(Request $request,$key){
        $this->removeFromOrderLogic($key);
        $orders = session('orders', []);
        $pizzas = Pizza::all();
        return view('pizza.index', ['pizzas' => $pizzas, 'orders' => $orders]);
    }

    private function removeFromOrderLogic($key){
        $orders = session('orders', []);
        if (isset($orders[$key])) { // Check if key exists before unsetting
            unset($orders[$key]);
            session(['orders'=>$orders]);
        }
    }
}
