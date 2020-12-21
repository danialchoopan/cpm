<?php


namespace App\controller\admin;


use App\controller\interface_controller\BasicController;
use App\core\File;
use App\core\View;
use App\database\adapter\BrandAdapter;
use App\database\adapter\CarAdapter;
use App\database\adapter\ConditionCarSellAdapter;
use App\database\adapter\PhotoAdapter;
use App\database\model\Car;

class AdminCarController implements BasicController
{

    public function index()
    {
        $car_adapter = new CarAdapter();
        return View::Create('admin.cars.car.index', [
            'cars' => $car_adapter->all()]);
    }

    public function create()
    {
        $condition_adapter = new ConditionCarSellAdapter();
        $brand_adapter = new BrandAdapter();
        if (count($condition_adapter->all()) != 0 && count($brand_adapter->all()) != 0)
            $can_create_car = true;
        else
            $can_create_car = false;
        return View::Create('admin.cars.car.create', [
            'can_create_car' => $can_create_car,
            'brands' => $brand_adapter->all(),
            'conditions' => $condition_adapter->all()
        ]);
    }

    public function store()
    {
        $car_model = new Car();
        $adapter_photo = new PhotoAdapter();
        $adapter_car = new CarAdapter();

        $name = $_POST['name'];
        $img_car = new File('img_car');
        $price = $_POST['price'];
        $brand = $_POST['brand'];
        $conditions = serialize($_POST['conditions']);
        $description = $_POST['description'];

        if (isset($_POST['is_for_sell_open'])) {
            $is_for_sell_open = $_POST['is_for_sell_open'];
            $car_model->setIsCarOpenForSell($is_for_sell_open);
        } else {
            $car_model->setIsCarOpenForSell(0);
        }

        $file_name = $img_car->get_file_name();
        $car_model->setPhotoId($adapter_photo->insert($file_name)['id']);

        $car_model->setName($name);
        $car_model->setPrice($price);
        $car_model->setBrandId($brand);
        $car_model->setConditionId($conditions);
        $car_model->setDescription($description);

        if ($adapter_car->insert($car_model)) {
            $img_car->storeAssetsImg();
            $_SESSION['msg_from_insert_status'] = ['status' => 'success', 'msg' => ' خودرو شما با موفقیت افزوده شد'];
        } else {
            $_SESSION['msg_from_insert_status'] = ['status' => 'danger', 'msg' => 'مشکلی  پیش آمده لطفا بعدا امتحان کنید'];
        }
        redirect(route('admin/dash/cars'));
    }

    public function edit($id)
    {
        $condition_adapter = new ConditionCarSellAdapter();
        $brand_adapter = new BrandAdapter();
        $photo_adapter = new PhotoAdapter();
        $car_adapter = new CarAdapter();
        $car = $car_adapter->find($id);
        if (count($condition_adapter->all()) != 0 && count($brand_adapter->all()) != 0)
            $can_create_car = true;
        else
            $can_create_car = false;
        return View::Create('admin.cars.car.edit', [
            'car' => $car,
            'can_create_car' => $can_create_car,
            'brands' => $brand_adapter->all(),
            'conditions' => $condition_adapter->all(),
            'car_photo_path' => show_img_user($photo_adapter->find($car['photo_id'])['name'])
        ]);
    }

    public function update($id)
    {
        $car_model = new Car();
        $adapter_photo = new PhotoAdapter();
        $adapter_car = new CarAdapter();

        $name = $_POST['name'];
        $price = $_POST['price'];
        $brand = $_POST['brand'];
        $conditions = serialize($_POST['conditions']);
        $description = $_POST['description'];

        if (isset($_FILES['img_car'])) {
            if ($_FILES['img_car']['name'] != "") {
                $photo_id = $adapter_car->find($id)['photo_id'];
                $old_name = $adapter_photo->find($photo_id)['name'];
                $dir = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'user_img' . DIRECTORY_SEPARATOR . $old_name;
                unlink($dir);
                $adapter_photo->delete($photo_id);

                $img_car = new File('img_car');
                $file_name = $img_car->get_file_name();
                $car_model->setPhotoId($adapter_photo->insert($file_name)['id']);
                $img_car->storeAssetsImg();
            }
        }

        if (isset($_POST['is_for_sell_open'])) {
            $is_for_sell_open = $_POST['is_for_sell_open'];
            $car_model->setIsCarOpenForSell($is_for_sell_open);
        } else {
            $car_model->setIsCarOpenForSell(0);
        }

        $car_model->setId($id);
        $car_model->setName($name);
        $car_model->setPrice($price);
        $car_model->setBrandId($brand);
        $car_model->setConditionId($conditions);
        $car_model->setDescription($description);

        if ($adapter_car->update($car_model)) {
            $_SESSION['msg_from_insert_status'] = ['status' => 'success', 'msg' => ' خودرو شما با موفقیت بروز شد'];
        } else {
            $_SESSION['msg_from_insert_status'] = ['status' => 'danger', 'msg' => 'مشکلی  پیش آمده لطفا بعدا امتحان کنید'];
        }
        redirect(route('admin/dash/cars'));
    }

    public function destroy()
    {
        $car_id = $_POST['car_id'];
        $adapter_photo = new PhotoAdapter();
        $adapter_car = new CarAdapter();
        $photo_id = $adapter_car->find($car_id)['photo_id'];
        $old_name = $adapter_photo->find($photo_id)['name'];
        $dir = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'user_img' . DIRECTORY_SEPARATOR . $old_name;
        unlink($dir);
        $adapter_photo->delete($photo_id);
        if ($adapter_car->delete($car_id)) {
            $_SESSION['msg_from_insert_status'] = ['status' => 'success', 'msg' => ' خودرو شما با موفقیت حذف شد'];
        } else {
            $_SESSION['msg_from_insert_status'] = ['status' => 'danger', 'msg' => 'مشکلی  پیش آمده لطفا بعدا امتحان کنید'];
        }
        redirect(route('admin/dash/cars'));
    }
}