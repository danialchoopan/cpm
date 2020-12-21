<?php

namespace App\controller\interface_controller;
interface BasicController
{
    public function index();

    public function create();

    public function store();

    public function edit($id);

    public function update($id);

    public function destroy();
}