<?php

class User
{

    public $name;
    public $age;
//runs when object is created
    public function __construct($name, $age)
    {
        echo __CLASS__ . ' created <br>';
        //echo 'constructor ran....';
        $this->name = $name;
        $this->age = $age;
    }

    function sayHello()
    {
        return $this->name .' Says hello';
    }
    //called when no othe referencies to certain object
    // used for cleanup, closing connections, etc...
    public function __destruct()
    {
        echo 'destructor ran...';
    }
}

$user1 = new User('Brad', 36);

echo $user1->name . ' is ' . $user1->age . ' years old';
echo '<br>';
echo $user1->sayHello();

echo '<br>'. '<br>';

$user2 = new User('jessie', 16);

echo $user2->name . ' is ' . $user2->age . ' years old';
echo '<br>';
echo $user2->sayHello();


?>