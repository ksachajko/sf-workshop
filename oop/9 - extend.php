<?php

class Vehicle {
    public int $speed;
    protected string $gear;
    private string $engine = 'V12';

    public function getEngine(): string
    {
        return $this->getEngine();
    }
}

class Bike extends Vehicle
{
    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function getGear(): string
    {
        return $this->gear;
    }

    public function getEngine(): string
    {
        return $this->engine; // private access
    }
}

$bike = new Bike();
echo $bike->getSpeed();
echo $bike->getGear();
echo $bike->getEngine();
