<?php
namespace App\Controllers;

use App\Contracts\IndexContracts;

class IndexController implements IndexContracts{
    public function index(){
        echo 'test';
    }

    public function hello()
    {
        echo 'hello';
    }
}