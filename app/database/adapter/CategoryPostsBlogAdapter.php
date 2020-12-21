<?php


namespace App\database\adapter;


use App\database\DatabaseConnection;
use App\database\model\CategoryBlog;

class CategoryPostsBlogAdapter extends DatabaseConnection
{
    public function get_all()
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `category_posts_blog`");
        if ($db->execute()) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function insert($category_name)
    {
        $db = $this->databaseConnection->prepare("INSERT INTO `category_posts_blog`(`name`, `created_at`) VALUES (?,?)");
        if ($db->execute([$category_name, time()])) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id_category)
    {
        $db = $this->databaseConnection->prepare("DELETE FROM `category_posts_blog` WHERE `id`=?");
        if ($db->execute([$id_category])) {
            return true;
        } else {
            return false;
        }
    }

    public function update(CategoryBlog $categoryBlog)
    {
        $db = $this->databaseConnection->prepare("UPDATE `category_posts_blog` SET `name`=? WHERE `id`=?");
        if ($db->execute([$categoryBlog->getName(), $categoryBlog->getId()])) {
            return true;
        } else {
            return false;
        }
    }

    public function find($id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `category_posts_blog` WHERE `id`=?");
        if ($db->execute([$id])) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }
}