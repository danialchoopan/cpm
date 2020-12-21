<?php


namespace App\controller\admin;


use App\controller\interface_controller\BasicController;
use App\core\View;
use App\database\adapter\ApplyCarAdapter;
use App\database\adapter\CarAdapter;
use App\database\adapter\GestAdapter;

class AdminGestController
{

    public function index()
    {
        $gest_adapter = new GestAdapter();
        return View::Create('admin.gest.index', [
            'gests' => $gest_adapter->all()]);
    }

    public function add_apply($apply_id)
    {
        $gest_adapter = new GestAdapter();
        $apply_adapter = new ApplyCarAdapter();
        $car_adapter = new CarAdapter();
        $each_month =
            ($car_adapter->find(
                    $apply_adapter->find($apply_id)['car_id']
                )['price'] / 12) * 1.2;
        $gest_adapter->insert(
            $apply_adapter->find($apply_id)['user_id'], $apply_id, 12, $each_month
        );
        set_massage("درخواست شما با موفیت ایجاد شد ");
        return redirect(route('admin/dash/gests'));
    }

    public function store()
    {
        // TODO: Implement store() method.
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