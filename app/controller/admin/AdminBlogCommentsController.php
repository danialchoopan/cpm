<?php


namespace App\controller\admin;


use App\controller\interface_controller\BasicController;
use App\core\View;
use App\database\adapter\BlogCommentAdapter;

class AdminBlogCommentsController
{

    public function all()
    {
        $blogCommentAdapter = new BlogCommentAdapter();
        return View::Create('admin.blog.comments.index', [
            'comments' => $blogCommentAdapter->all()
        ]);
    }

    public function index($status_id)
    {
        $blogCommentAdapter = new BlogCommentAdapter();
        return View::Create('admin.blog.comments.status', [
            'status_comment' => $status_id,
            'comments' => $blogCommentAdapter->confirmed($status_id)
        ]);
    }

    public function status_changer($status_id, $comment_id)
    {
        $blogCommentAdapter = new BlogCommentAdapter();
        if ($blogCommentAdapter->update_confirmed($comment_id, $status_id)) {
            set_massage('نظر مورد نظر شما با موفیت بروزشد', 'success');
        } else {
            error_session();
        }
        return redirect(route('admin/dash/blog/comments'));
    }

    public function show($comment_id)
    {
        $blogCommentAdapter = new BlogCommentAdapter();
        return View::Create('admin.blog.comments.show', [
            'comment' => $blogCommentAdapter->find($comment_id)
        ]);
    }

    public function edit($id)
    {
        // TODO: Implement edit() method.
    }

    public function update($id)
    {
        // TODO: Implement update() method.
    }

    public function destroy()
    {
        // TODO: Implement destroy() method.
    }
}