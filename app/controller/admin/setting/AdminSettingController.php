<?php


namespace App\controller\admin\setting;


use App\controller\interface_controller\BasicController;
use App\core\View;

class AdminSettingController implements BasicController
{

    public function index()
    {
        return View::Create('admin.setting.index');
    }

    public function create()
    {
        // TODO: Implement create() method.
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