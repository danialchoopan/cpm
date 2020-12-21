<?php


namespace App\controller\admin;


use App\controller\interface_controller\BasicController;
use App\core\View;
use App\database\adapter\ApplyCarAdapter;
use App\database\adapter\Level3ApplyAdapter;

class AdminApplyCarController
{

    public function index()
    {
        $car_apply_adapter = new ApplyCarAdapter();
        return View::Create('admin.request_car.index', [
            'apply_cars' => $car_apply_adapter->all()
        ]);
    }

    public function set_status($status_id, $request_id)
    {
        $car_apply_adapter = new ApplyCarAdapter();
        if ($car_apply_adapter->update_status($status_id, $request_id)) {
            set_massage("با موفیت بروز شد وضعیت مورد نظر شما", 'success');
        } else {
            error_session();
        }
        redirect(route('admin/dash/apply/car'));
    }

    public function show($request_id)
    {
        $car_apply_adapter = new ApplyCarAdapter();
        return View::Create('admin.request_car.show', [
            'apply_car' => $car_apply_adapter->find($request_id)
        ]);
    }

    public function show_status($status_id)
    {
        $car_apply_adapter = new ApplyCarAdapter();
        return View::Create('admin.request_car.status', [
            'apply_cars' => $car_apply_adapter->status($status_id),
            'status_id' => $status_id
        ]);
    }

    public function show_level3($apply_id)
    {
        $level3_adapter = new Level3ApplyAdapter();
        $apply_adapter = new ApplyCarAdapter();
        return View::Create('admin.request_car.level3', [
            'level3' => $level3_adapter->find($apply_id),
            'apply_car' => $apply_adapter->find($apply_id)
        ]);
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