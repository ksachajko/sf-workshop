<?php

class Company
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): string
    {
        return $this->name = $name;
    }
}

$company = new Company('Acme');
echo $company->getName(); // Acme
$company->setName('Intel');
echo $company->getName(); // Intel

