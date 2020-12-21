<?php


namespace App\database\interfaces;


use App\database\model\DataModel;

interface AdapterBasic
{
    public function all();

    public function find($id);

    public function insert(DataModel $class);

    public function delete($id);

    public function update(DataModel $class);
}