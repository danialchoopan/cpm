<?php


namespace App\controller\admin;


use App\core\View;
use App\database\adapter\CategoryPostsBlogAdapter;
use App\database\model\CategoryBlog;

class AdminCategoryPostsController
{
    public function index()
    {
        $categoryPostsBlogAdapter = new CategoryPostsBlogAdapter();
        return View::Create('admin.blog.category.index', ['categorys' => $categoryPostsBlogAdapter->get_all()]);
    }

    public function store()
    {
        $name_category = $_POST['name'];
        $categoryPostsBlogAdapter = new CategoryPostsBlogAdapter();
        if ($categoryPostsBlogAdapter->insert($name_category)) {
            $_SESSION['msg_from_insert_status'] = ['status' => 'success', 'msg' => 'دسته بندی مورد با موفقیت افزوده شد'];
        } else {
            $_SESSION['msg_from_insert_status'] = ['status' => 'danger', 'msg' => 'مشکلی  پیش آمده لطفا بعدا امتحان کنید'];
        }
        redirect(route('admin/dash/posts/categorys'));
    }

    public function edit($category_id)
    {
        $categoryPostsBlogAdapter = new CategoryPostsBlogAdapter();
        return View::Create('admin.blog.category.edit', ['category' => $categoryPostsBlogAdapter->find($category_id)]);
    }

    public function update($category_id)
    {
        $name_category = $_POST['name'];
        $category_blog_model = new CategoryBlog();
        $category_blog_model->setId($category_id);
        $category_blog_model->setName($name_category);
        $categoryPostsBlogAdapter = new CategoryPostsBlogAdapter();
        if ($categoryPostsBlogAdapter->update($category_blog_model)) {
            $_SESSION['msg_from_insert_status'] = ['status' => 'success', 'msg' => 'دسته بندی مورد با موفقیت برورسانی شد'];
        } else {
            $_SESSION['msg_from_insert_status'] = ['status' => 'danger', 'msg' => 'مشکلی  پیش آمده لطفا بعدا امتحان کنید'];
        }
        redirect(route('admin/dash/posts/categorys'));
    }

    public function destroy($category_id)
    {
        $categoryPostsBlogAdapter = new CategoryPostsBlogAdapter();
        if ($categoryPostsBlogAdapter->delete($category_id)) {
            $_SESSION['msg_from_insert_status'] = ['status' => 'success', 'msg' => 'دسته بندی مورد با موفقیت افزوده شد حدف گردید'];
        } else {
            $_SESSION['msg_from_insert_status'] = ['status' => 'danger', 'msg' => 'مشکلی  پیش آمده لطفا بعدا امتحان کنید'];
        }
        redirect(route('admin/dash/posts/categorys'));
    }
}