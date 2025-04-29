<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    # Class and Object
    class Car
    { // class
        public $brand, $model, $year; // properties

        function __construct($brand, $model, $year)
        {
            $this->brand = $brand;
            $this->model = $model;
            $this->year = $year;
        }

        function displayInfo()
        { // method
            echo "$this->brand $this->model, $this->year";
        }

        function __destruct() //destructor - PHP will automatically call this function at the end of the script
        {
            echo "<br>";
            echo "&copy; anonymous 2025";
        }
    }

    $car = new Car("Toyota", "Alphard", 2024); // object
    $car->displayInfo();
    $car->model = "Vellfire";
    echo "<br>";
    $car->displayInfo();


    # Access Modifiers
    class Fruit
    {
        public $name;
        protected $color;
        private $weight;

        function set_name($n)
        {  // a public function (default)
            $this->name = $n;
        }
        protected function set_color($n)
        { // a protected function
            $this->color = $n;
        }
        private function set_weight($n)
        { // a private function
            $this->weight = $n;
        }

        function display()
        {
            echo $this->name . " " . $this->color . " " . $this->weight;
        }
    }

    echo "<br>";
    $mango = new Fruit();
    $mango->set_name('Mango'); // OK
    // $mango->set_color('Yellow'); // ERROR
    // $mango->set_weight('250'); // ERROR
    $mango->display();

    # Inheritance
    class Vehicle
    {
        public function move()
        {
            echo "The vehicle is moving.\n";
        }
    }

    // Child class inherits from Vehicle
    class Motorcycle extends Vehicle
    {
        public function honk()
        {
            echo "The motorcycle is honking: Beep beep!\n";
        }
    }

    // Create an object from the child class
    $motor = new Motorcycle();

    // Call methods
    echo "<br>";
    $motor->move();  // Inherited method from Vehicle
    $motor->honk();  // Method from Motorcycle

    # Overriding
    // Parent class
    class Employee
    {
        public function work()
        {
            echo "Employee is working on assigned tasks.\n";
        }
    }

    // Child class overriding work()
    class Manager extends Employee
    {
        public function work()
        {
            echo "Manager is planning, organizing, and supervising the team.\n";
        }
    }

    // Membuat objek
    echo "<br>";
    $employee = new Employee();
    $employee->work();
    // Output: Employee is working on assigned tasks.

    echo "<br>";
    $manager = new Manager();
    $manager->work();
    // Output: Manager is planning, organizing, and supervising the team.

    # Overloading
    class Calculator
    {
        // __call dipanggil ketika memanggil method yang tidak ada
        public function __call($name, $arguments)
        {
            if ($name == 'sum') {
                return array_sum($arguments);
            }
        }
    }

    // Membuat objek
    $calc = new Calculator();

    echo "<br>";
    // Memanggil method 'sum' dengan berbagai jumlah parameter
    echo $calc->sum(1, 2);        // Output: 3
    echo "\n";
    echo $calc->sum(1, 2, 3, 4);  // Output: 10

    # Abstract Class
    abstract class Animal
    {
        // Abstract method (must be implemented in child class)
        abstract public function makeSound();

        // Regular method
        public function move()
        {
            echo "The animal moves.\n";
        }
    }

    // Child class that extends Animal
    class Dog extends Animal
    {
        public function makeSound()
        {
            echo "Bark!\n";
        }
    }

    // Using the class
    echo "<br>";
    $dog = new Dog();
    $dog->makeSound();  // Output: Bark!
    $dog->move();       // Output: The animal moves.

    # Interface
    // Define an interface
    interface Kendaraan
    {
        public function start();
        public function stop();
    }

    // Implementing the interface
    class Mobil implements Kendaraan
    {
        public function start()
        {
            echo "Car is starting...\n";
        }

        public function stop()
        {
            echo "Car is stopping...\n";
        }
    }

    // Using the class
    echo "<br>";
    $mobil = new Mobil();
    $mobil->start();   // Output: Car is starting...
    $mobil->stop();    // Output: Car is stopping...

    # Traits
    // First Trait
    trait SayHello
    {
        public function sayHello()
        {
            echo "Hello! ";
        }
    }

    // Second Trait
    trait SayGoodbye
    {
        public function sayGoodbye()
        {
            echo "Goodbye!";
        }
    }

    // Class that use 2 traits
    class Greeting
    {
        use SayHello, SayGoodbye;
    }

    // Create Object
    echo "<br>";
    $greet = new Greeting();
    $greet->sayHello();   // Output: Hello! 
    $greet->sayGoodbye(); // Output: Goodbye!

    ?>
</body>

</html>