<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use App\Models\Order_details;
use App\Models\Pizza;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PizzaController;
use App\Models\User;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }
    public function test_can_pull_specfic_pizza(): void{
        $id=3;
        $pizza = Pizza::findOrFail($id);
        $what_should_be = new Pizza([
            'id' => '3',
            'pizza_name' => 'beef',
            'pizza_desc' => 'some nice tasty beef',
            'pizza_large_price' => '11',
            'pizza_medium_price' => '10',
            'pizza_small_price' => '9',
            'pizza_category' => 'meat feast',
            'pizza_image' => 'public/storage/pizza/images/meatPizza1.jpeg'
        ]);
        // Retrieve distinct categories from the pizzas

        $this->assertEquals($pizza->id, $what_should_be->id);
        $this->assertEquals($pizza->pizza_name, $what_should_be->pizza_name);
        $this->assertEquals($pizza->pizza_desc, $what_should_be->pizza_desc);
        $this->assertEquals($pizza->pizza_large_price, $what_should_be->pizza_large_price);
        $this->assertEquals($pizza->pizza_medium_price, $what_should_be->pizza_medium_price);
        $this->assertEquals($pizza->pizza_small_price, $what_should_be->pizza_small_price);
        $this->assertEquals($pizza->pizza_category, $what_should_be->pizza_category);
        $this->assertEquals($pizza->pizza_image, $what_should_be->pizza_image);
    }
    public function  test_total_price_calculation():void{
        $totalPrice = 0.00;
        $items = [
            ['pizza' => 'beef', 'size' => 'medium', 'price' => 10],
            ['pizza' => 'kale', 'size' => 'small', 'price' => 6],
            ['pizza' => 'ham', 'size' => 'medium', 'price' => 8]
        ];

        foreach ($items as $order) {
            $totalPrice += $order['price'];
        }

        $this->assertEquals($totalPrice, 24);



    }
    public  function  test_to_see_if_order_works():void{
        $pizzaController = new PizzaController();
        $pizza = Pizza::find(1);
        // Append the new order to the existing array
        $items[] = ['pizza' => $pizza, 'size' => 'medium','price'=>7];
        $pizza = Pizza::find(2);
        $items[] = ['pizza' => $pizza, 'size' => 'small','price'=>7];
        session(['items' => $items]);
        $user = User::find(1);
        // Log the user in
        Auth::login($user);
        $pizzaController->makeOrder();
        $this->assertDatabaseHas('orders',['user_id'=>1,'date'=>date("y/m/d"),'price'=>14]);
    }
    //public function  test_create_pizza(): void{
       // $data = [
          //  'pizza_name' => 'beef',
           // 'pizza_desc' => 'some nice tasty beef',
           // 'pizza_large_price'=>'11',
           // 'pizza_medium_price'=>'10',
          //  'pizza_small_price'=>'9',
           // 'pizza_category'=>'meat feast',
           // 'pizza_image'=>'public/storage/pizza/images/meatPizza1.jpeg'
       // ];
       // Pizza::create($data);

        // Assert: Check if data is stored correctly in the database
       // $this->assertDatabaseHas('pizzas', $data);
  //  }




}
