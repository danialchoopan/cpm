<?php


namespace App\controller;


use App\core\View;
use App\database\adapter\BlogCommentAdapter;
use App\database\adapter\BlogPostsAdapter;
use App\database\adapter\CategoryPostsBlogAdapter;
use App\database\model\BlogComment;
use App\database\model\CategoryBlog;

class BlogController
{
    public function index()
    {
        $blog_adapter = new BlogPostsAdapter();
        $category_adapter = new CategoryPostsBlogAdapter();
        return View::Create('blog.index', [
            'blogs' => $blog_adapter->all(),
            'categorys' => $category_adapter->get_all()
        ]);
    }

    public function show_category_posts($id_category)
    {
        $blog_adapter = new BlogPostsAdapter();
        $category_adapter = new CategoryPostsBlogAdapter();
        $blogs = $blog_adapter->show_posts_by_category_id($id_category);
        $category_blog = $category_adapter->find($id_category);
        return View::Create('blog.category.index', [
            'blogs' => $blogs,
            'categorys' => $category_adapter->get_all(),
            'category_blog' => $category_blog
        ]);
    }

    public function show($id)
    {
        $blog_adapter = new BlogPostsAdapter();
        $blog = $blog_adapter->find($id);
        $category_adapter = new CategoryPostsBlogAdapter();
        $comment_adapter = new BlogCommentAdapter();
        return View::Create('blog.show', [
            'blog' => $blog,
            'category' => $category_adapter->find($blog['category_id']),
            'comments' => $comment_adapter->confirmed(1)
        ]);
    }

    public function store_comment($post_id)
    {
        if (isset($_POST['content']) && authUser()):
            $content = $_POST['content'];
            $blog_comment = new BlogComment();
            $blog_comment->setUserId(authUser()['id']);
            $blog_comment->setContent($content);
            $blog_comment->setPostId($post_id);
            $blog_comment_adapter = new BlogCommentAdapter();
            if ($blog_comment_adapter->insert($blog_comment)) {
                set_massage('نظر شما باموفیت ثبت شد پس از تایید نمایش داده خواهد شد', 'success');
            } else {
                error_session();
            }
            return redirect(route("blog/show/$post_id"));
        endif;
    }
}