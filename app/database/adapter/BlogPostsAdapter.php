<?php


namespace App\database\adapter;


use App\database\DatabaseConnection;
use App\database\model\PostBlog;

class BlogPostsAdapter extends DatabaseConnection
{

    public function all()
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `blog_posts`");
        if ($db->execute()) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function show_posts_by_category_id($id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `blog_posts` WHERE `category_id`=?");
        if ($db->execute([$id])) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function latest_posts()
    {
        $sql = "SELECT * FROM `blog_posts` ORDER BY `id` DESC LIMIT 3 ";
        $db = $this->databaseConnection->prepare($sql);
        if ($db->execute()) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function find($id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `blog_posts` WHERE `id`=?");
        if ($db->execute([$id])) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }

    public function insert(PostBlog $postBlog)
    {
        $now_time = time();
        $sql = "INSERT INTO `blog_posts`(`title`, `body`, `photo_id`, `category_id`, `created_at`, `updated_at`) VALUES (?,?,?,?,?,?)";
        $db = $this->databaseConnection->prepare($sql);
        return $db->execute([$postBlog->getTitle(), $postBlog->getBody(), $postBlog->getPhoto_id(), $postBlog->getCategoryId(), $now_time, $now_time]);
    }

    public function delete($id)
    {
        $db = $this->databaseConnection->prepare("DELETE FROM `blog_posts` WHERE `id`=?");
        return $db->execute([$id]);
    }

    public function update(PostBlog $postBlog)
    {
        if ($postBlog->getPhoto_id()) {
            $sql = "UPDATE `blog_posts` SET `title`=?,`body`=?,`photo_id`=?,`category_id`=?,`updated_at`=? WHERE `id`=?";
        } else {
            $sql = "UPDATE `blog_posts` SET `title`=?,`body`=?,`category_id`=?,`updated_at`=? WHERE `id`=?";
        }
        $db = $this->databaseConnection->prepare($sql);

        if ($postBlog->getPhoto_id()) {
            return $db->execute([$postBlog->getTitle(), $postBlog->getBody(), $postBlog->getPhoto_id(), $postBlog->getCategoryId(), time(), $postBlog->getId()]);
        } else {
            return $db->execute([$postBlog->getTitle(), $postBlog->getBody(), $postBlog->getCategoryId(), time(), $postBlog->getId()]);
        }
    }
}