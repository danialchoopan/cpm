<?php


namespace App\controller\admin;


use App\core\File;
use App\core\View;
use App\database\adapter\BlogCommentAdapter;
use App\database\adapter\BlogPostsAdapter;
use App\database\adapter\CategoryPostsBlogAdapter;
use App\database\adapter\PhotoAdapter;
use App\database\model\PostBlog;

class AdminBlogPostsController
{
    public function index()
    {
        $blogPostsAdapter = new BlogPostsAdapter();
        return View::Create('admin.blog.posts.index', ['posts' => $blogPostsAdapter->all()]);
    }

    public function create()
    {
        $categoryPostsBlogAdapter = new CategoryPostsBlogAdapter();
        $categorys = $categoryPostsBlogAdapter->get_all();
        return View::Create('admin.blog.posts.create', ['categorys' => $categorys]);

    }

    public function store()
    {
        $title = $_POST['title'];
        $thumbnail = new File('img_thumbnail');
        $body = $_POST['body'];
        $category = $_POST['category'];
        $post_model = new PostBlog();
        $post_model->setTitle($title);
        $file_name = $thumbnail->get_file_name();
        $adapter_photo = new PhotoAdapter();
        $post_model->setPhoto_id($adapter_photo->insert($file_name)['id']);
        $post_model->setBody($body);
        $post_model->setCategoryId($category);
        $post_blog_adapter = new BlogPostsAdapter();
        if ($post_blog_adapter->insert($post_model)) {
            $thumbnail->storeAssetsImg();
            $_SESSION['msg_from_insert_status'] = ['status' => 'success', 'msg' => ' پست با موفقیت افزوده شد'];
        } else {
            $_SESSION['msg_from_insert_status'] = ['status' => 'danger', 'msg' => 'مشکلی  پیش آمده لطفا بعدا امتحان کنید'];
        }
        redirect(route('admin/dash/posts'));

    }

    public function edit($id)
    {
        $categoryPostsBlogAdapter = new CategoryPostsBlogAdapter();
        $PostsBlogAdapter = new BlogPostsAdapter();
        $post = $PostsBlogAdapter->find($id);
        $categorys = $categoryPostsBlogAdapter->get_all();
        $adaptor_photo = new PhotoAdapter();
        $photo = $adaptor_photo->find($post['photo_id'])['name'];
        return View::Create('admin.blog.posts.edit', ['categorys' => $categorys, 'post' => $post, 'photo' => $photo]);
    }

    public function update($id)
    {
        $post_blog_adapter = new BlogPostsAdapter();
        $post_model = new PostBlog();
        $title = $_POST['title'];
        if (isset($_FILES['img_thumbnail'])) {
            if ($_FILES['img_thumbnail']['name'] != "") {
                $adapter_photo = new PhotoAdapter();
                $photo_id = $post_blog_adapter->find($id)['photo_id'];
                $old_name = $adapter_photo->find($photo_id)['name'];
                $dir = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'user_img' . DIRECTORY_SEPARATOR . $old_name;
                unlink($dir);
                $adapter_photo->delete($photo_id);
                $thumbnail = new File('img_thumbnail');
                $file_name = $thumbnail->get_file_name();
                $post_model->setPhoto_id($adapter_photo->insert($file_name)['id']);
            }
        }
        $post_model->setId($id);
        $body = $_POST['body'];
        $category = $_POST['category'];
        $post_model->setTitle($title);
        $post_model->setBody($body);
        $post_model->setCategoryId($category);
        if ($post_blog_adapter->update($post_model)) {
            if (isset($_FILES['img_thumbnail'])) {
                if ($_FILES['img_thumbnail']['name'] != "") {
                    $thumbnail->storeAssetsImg();
                }
            }
            $_SESSION['msg_from_insert_status'] = ['status' => 'success', 'msg' => ' پست با موفقیت بروز شد'];
        } else {
            $_SESSION['msg_from_insert_status'] = ['status' => 'danger', 'msg' => 'مشکلی  پیش آمده لطفا بعدا امتحان کنید'];
        }
        redirect(route('admin/dash/posts'));

    }

    public function destroy()
    {
        $post_id = $_POST['id_post'];
        $post_blog_adapter = new BlogPostsAdapter();
        $photo_id = $post_blog_adapter->find($post_id)['photo_id'];
        if ($post_blog_adapter->delete($post_id)) {
            $adapter_photo = new PhotoAdapter();
            $old_name = $adapter_photo->find($photo_id)['name'];
            $dir = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'user_img' . DIRECTORY_SEPARATOR . $old_name;
            unlink($dir);
            $adapter_photo->delete($photo_id);
            $_SESSION['msg_from_insert_status'] = ['status' => 'success', 'msg' => ' پست با حدف شد'];
        } else {
            $_SESSION['msg_from_insert_status'] = ['status' => 'danger', 'msg' => 'مشکلی  پیش آمده لطفا بعدا امتحان کنید'];
        }
        redirect(route('admin/dash/posts'));
    }

    public function post_comments($post_id)
    {
        $blog_comments_adapter = new BlogCommentAdapter();
        return View::Create('admin.blog.posts.comments', ['comments' => $blog_comments_adapter->post_comments($post_id)]);
    }
}