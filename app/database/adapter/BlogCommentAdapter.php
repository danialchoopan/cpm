<?php


namespace App\database\adapter;


use App\database\DatabaseConnection;
use App\database\interfaces\AdapterBasic;
use App\database\model\BlogComment;
use App\database\model\DataModel;
use Illuminate\Contracts\View\View;

class BlogCommentAdapter extends DatabaseConnection
{

    public function all()
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `blog_comment`");
        if ($db->execute()) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function post_comments($post_id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `blog_comment` WHERE `blogpost_id`=?");
        if ($db->execute([$post_id])) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function confirmed($confirmed)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `blog_comment` WHERE `confirmed`=?");
        if ($db->execute([$confirmed])) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function find($id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `blog_comment` WHERE `id`=?");
        if ($db->execute([$id])) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }

    public function insert(BlogComment $blogComment)
    {
        $sql = "INSERT INTO `blog_comment`(`user_id`, `blogpost_id`, `content`, `created_at`)
 VALUES (?,?,?,?)";
        $db = $this->databaseConnection->prepare($sql);
        if (!$db->execute([$blogComment->getUserId(), $blogComment->getPostId(), $blogComment->getContent(), time()])) {
            return false;
        }

        $result = $this->databaseConnection->prepare("SELECT * FROM `blog_comment` ORDER BY `id` DESC");
        $result->execute();
        return $result->fetch(2);
    }

    public function update_confirmed($status_id, $comment_id)
    {
        $sql = "UPDATE `blog_comment` SET `confirmed`=? WHERE `id`=?";
        $db = $this->databaseConnection->prepare($sql);
        return $db->execute([$status_id, $comment_id]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM `blog_comment` WHERE `id`=?";
        $db = $this->databaseConnection->prepare($sql);
        return $db->execute([$id]);
    }
}