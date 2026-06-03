<?php


namespace App\controller;


use App\core\View;
use App\database\adapter\BlogPostsAdapter;
use App\database\adapter\BrandAdapter;
use App\database\adapter\CarAdapter;

class HomePageController
{
    public function indexPage()
    {
        $brand_adapter = new BrandAdapter();
        $blog_adapter = new BlogPostsAdapter();
        $car_adapter = new CarAdapter();

        // دریافت داده‌های فیلتر از GET
        $filters = [
            'brand_id' => $_GET['brand_id'] ?? null,
            'city' => $_GET['city'] ?? null,
            'min_price' => $_GET['min_price'] ?? null,
            'max_price' => $_GET['max_price'] ?? null,
            'year' => $_GET['year'] ?? null,
        ];

        return View::Create('index', [
            'brands' => $brand_adapter->all(),
            'latest_posts' => $blog_adapter->latest_posts(),
            'cars' => $car_adapter->all($filters, true), // نمایش فقط آگهی‌های تایید شده
            'filters' => $filters
        ]);
    }

}