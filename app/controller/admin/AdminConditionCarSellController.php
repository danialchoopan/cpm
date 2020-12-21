<?php


namespace App\controller\admin;


use App\controller\interface_controller\BasicController;
use App\core\View;
use App\database\adapter\ConditionCarSellAdapter;
use App\database\model\ConditionSellCar;

class AdminConditionCarSellController implements BasicController
{

    public function index()
    {
        $conditions_sell_adapter = new ConditionCarSellAdapter();
        return View::Create('admin.cars.condition.index',
            [
                'conditions' => $conditions_sell_adapter->all()
            ]
        );
    }

    public function create()
    {
        return View::Create('admin.cars.condition.create');
    }

    public function store()
    {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $condition_model = new ConditionSellCar();
        $condition_model->setName($name);
        $condition_model->setDescription($description);
        $condition_adapter = new ConditionCarSellAdapter();
        if ($condition_adapter->insert($condition_model)) {
            $_SESSION['msg_from_insert_status'] = ['status' => 'success', 'msg' => ' شرایط با موفقیت افزوده شد'];
        } else {
            $_SESSION['msg_from_insert_status'] = ['status' => 'danger', 'msg' => 'مشکلی  پیش آمده لطفا بعدا امتحان کنید'];
        }
        redirect(route('admin/dash/conditions'));
    }

    public function edit($id)
    {
        $conditions_sell_adapter = new ConditionCarSellAdapter();
        return View::Create('admin.cars.condition.edit',
            [
                'condition' => $conditions_sell_adapter->find($id)
            ]
        );
    }

    public function update($id)
    {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $condition_model = new ConditionSellCar();
        $condition_model->setName($name);
        $condition_model->setDescription($description);
        $condition_model->setId($id);
        $condition_adapter = new ConditionCarSellAdapter();
        if ($condition_adapter->update($condition_model)) {
            $_SESSION['msg_from_insert_status'] = ['status' => 'success', 'msg' => ' شرایط با موفقیت بروز شد'];
        } else {
            $_SESSION['msg_from_insert_status'] = ['status' => 'danger', 'msg' => 'مشکلی  پیش آمده لطفا بعدا امتحان کنید'];
        }
        redirect(route('admin/dash/conditions'));
    }

    public function destroy()
    {
        $condition_id = $_POST['condition_id'];
        $condition_adapter = new ConditionCarSellAdapter();
        if ($condition_adapter->delete($condition_id)) {
            $_SESSION['msg_from_insert_status'] = ['status' => 'success', 'msg' => ' شرایط با موفقیت حذف شد'];
        } else {
            $_SESSION['msg_from_insert_status'] = ['status' => 'danger', 'msg' => 'مشکلی  پیش آمده لطفا بعدا امتحان کنید'];
        }
        redirect(route('admin/dash/conditions'));
    }
}