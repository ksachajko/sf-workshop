<?php

class Company
{
    public string $name;
    protected string $address;
    private int $revenue;

    public function getName() {
        return 'Acme';
    }

    public function getAddress(): string {
        return 'Apple Str 12, Kensington, UK';
    }
}

$company = new Company();
echo $company->getName(); // Acme
echo $company->getAddress(); // Apple Str 12, Kensington, UK
