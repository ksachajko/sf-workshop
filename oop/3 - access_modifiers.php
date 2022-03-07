<?php

class Company
{
    public $name;
    protected $industry;
    private $income;
}

$company = new Company();
$company->name = 'Acme';
$company->industry = 'IT'; // Error
//$company->income = '100000$'; // Error
