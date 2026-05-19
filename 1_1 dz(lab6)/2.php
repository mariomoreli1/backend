<?php

class Cat {
    private string $color;
    public string $name;
    
    public function __construct(string $name, string $color) {
        $this->name = $name;
        $this->color = $color;
    }
    
    public function getColor(): string {
        return $this->color;
    }
    
    public function sayHello(): void {
        echo "Меня зовут {$this->name}, я {$this->color} цвета.\n";
    }
}

$murka = new Cat('Мурка', 'чёрного');
$murka->sayHello();                          

echo $murka->getColor() . "\n";              
echo $murka->color;                          