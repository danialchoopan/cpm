<?php


namespace App\controller;


use App\core\View;
use App\database\adapter\BrandAdapter;
use App\database\adapter\CarAdapter;

class CarBrandController
{
    public function index($id)
    {
        $brand_adapter = new BrandAdapter();
        $brand = $brand_adapter->find($id);
        $car_adapter = new CarAdapter();
        $cars = $car_adapter->show_cars_by_brand_id($brand['id']);
        return View::Create('car.brand.index', [
            'cars' => $cars,
            'brand' => $brand
        ]);

    }
}