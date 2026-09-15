<?php

interface CalculateSquare {
    public function calculateArea(): float;
}

class Square implements CalculateSquare {
    private float $side;
    
    public function __construct(float $side) {
        $this->side = $side;
    }
    
    public function calculateArea(): float {
        return $this->side * $this->side;
    }
}

class Circle implements CalculateSquare {
    private float $radius;
    
    public function __construct(float $radius) {
        $this->radius = $radius;
    }
    
    public function calculateArea(): float {
        return pi() * $this->radius * $this->radius;
    }
}

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

function printArea(object $obj): void {
    $className = get_class($obj);
    
    if ($obj instanceof CalculateSquare) {
        echo "Объект класса {$className} имеет площадь: " . $obj->calculateArea() . "\n";
    } else {
        echo "Объект класса {$className} не реализует интерфейс CalculateSquare.\n";
    }
}

$square = new Square(5);
$circle = new Circle(3);
$cat = new Cat('Мурка', 'чёрного');

printArea($square);
printArea($circle);
printArea($cat);