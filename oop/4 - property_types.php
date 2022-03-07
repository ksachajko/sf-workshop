<?php

class Company
{
    public string $name;
    public Address $address;
}

class Address
{
}

$address = new Address();
$company = new Company();

$company->name = 'Acme';
$company->address = 'Kołobrzeska 12/123'; // Error

$company->address = new Address();


