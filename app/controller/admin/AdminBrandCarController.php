<?php


namespace App\controller\admin;

use App\controller\interface_controller\BasicController;
use App\core\File;
use App\core\View;
use App\database\adapter\BrandAdapter;
use App\database\adapter\PhotoAdapter;
use App\database\model\Brand;

class AdminBrandCarController implements BasicController
{

    public function index()
    {
        $brand_adapter = new BrandAdapter();
        return View::Create('admin.cars.brand.index', ['brands' => $brand_adapter->all()]);
    }

    public function create()
    {
        return View::Create('admin.cars.brand.create');
    }

    public function store()
    {
        $name = $_POST['name'];
        $logo_img = new File('img_logo');
        $description = $_POST['description'];
        $brand_model = new Brand();
        $brand_model->setName($name);
        $file_name = $logo_img->get_file_name();
        $adapter_photo = new PhotoAdapter();
        $brand_model->setPhotoId($adapter_photo->insert($file_name)['id']);
        $brand_model->setDescription($description);
        $brand_adapter = new BrandAdapter();
        if ($brand_adapter->insert($brand_model)) {
            $logo_img->storeAssetsImg();
            $_SESSION['msg_from_insert_status'] = ['status' => 'success', 'msg' => ' برند با موفقیت افزوده شد'];
        } else {
            $_SESSION['msg_from_insert_status'] = ['status' => 'danger', 'msg' => 'مشکلی  پیش آمده لطفا بعدا امتحان کنید'];
        }
        redirect(route('admin/dash/brand'));

    }

    public function edit($id)
    {
        $brand_adapter = new BrandAdapter();
        $photo_adapter = new PhotoAdapter();
        $brand = $brand_adapter->find($id);
        return View::Create('admin.cars.brand.edit', [
            'brand' => $brand,
            'logo_img' => show_img_user($photo_adapter->find($brand['photo_id'])['name'])
        ]);
    }

    public function update($id)
    {
        $brand_adapter = new BrandAdapter();
        $brand_model = new Brand();
        $adapter_photo = new PhotoAdapter();
        $name = $_POST['name'];
        if (isset($_FILES['img_logo'])) {
            if ($_FILES['img_logo']['name'] != "") {
                $photo_id = $brand_adapter->find($id)['photo_id'];
                $old_name = $adapter_photo->find($photo_id)['name'];
                $dir = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'user_img' . DIRECTORY_SEPARATOR . $old_name;
                unlink($dir);
                $adapter_photo->delete($photo_id);
                $img_logo = new File('img_logo');
                $file_name = $img_logo->get_file_name();
                $brand_model->setPhotoId($adapter_photo->insert($file_name)['id']);
            }
        }
        $brand_model->setId($id);
        $brand_model->setName($name);
        $description = $_POST['description'];
        $brand_model->setDescription($description);
        if ($brand_adapter->update($brand_model)) {
            if (isset($_FILES['img_logo'])) {
                if ($_FILES['img_logo']['name'] != "") {
                    $img_logo->storeAssetsImg();
                }
            }
            $_SESSION['msg_from_insert_status'] = ['status' => 'success', 'msg' => ' برند با موفقیت بروز شد'];
        } else {
            $_SESSION['msg_from_insert_status'] = ['status' => 'danger', 'msg' => 'مشکلی  پیش آمده لطفا بعدا امتحان کنید'];
        }
        redirect(route('admin/dash/brand'));
    }

    public function destroy()
    {
        $brand_id = $_POST['id_brand'];
        $brand_adapter = new BrandAdapter();
        $adapter_photo = new PhotoAdapter();
        $photo_id = $brand_adapter->find($brand_id)['photo_id'];
        if ($brand_adapter->delete($brand_id)) {
            $old_name = $adapter_photo->find($photo_id)['name'];
            $dir = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'user_img' . DIRECTORY_SEPARATOR . $old_name;
            unlink($dir);
            $adapter_photo->delete($photo_id);
            $_SESSION['msg_from_insert_status'] = ['status' => 'success', 'msg' => 'برند مورد نظر شما با موفیت حذف شد'];
        } else {
            $_SESSION['msg_from_insert_status'] = ['status' => 'danger', 'msg' => 'مشکلی  پیش آمده لطفا بعدا امتحان کنید'];
        }
        redirect(route('admin/dash/brand'));
    }
}