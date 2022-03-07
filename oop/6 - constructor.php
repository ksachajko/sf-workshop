<?php

class Company
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}

$company = new Company('Acme');
echo $company->getName(); // Acme
echo $company->getAddress(); // Apple Str 12, Kensington, UK
