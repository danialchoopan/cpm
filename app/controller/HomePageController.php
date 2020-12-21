<?php


namespace App\controller;


use App\core\View;
use App\database\adapter\BlogPostsAdapter;
use App\database\adapter\BrandAdapter;

class HomePageController
{
    public function indexPage()
    {
        $brand_adapter = new BrandAdapter();
        $blog_adapter = new BlogPostsAdapter();
        return View::Create('index', [
            'brands' => $brand_adapter->all(),
            'latest_posts' => $blog_adapter->latest_posts()
        ]);
    }

}