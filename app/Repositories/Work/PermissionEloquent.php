<?php


namespace App\Repositories\Work;


use App\Models\permission;
use App\Repositories\TodoInterfaceWork\PermissionReponsitory;

class PermissionEloquent implements PermissionReponsitory
{
    //Get list permission
    public function getAll()
    {
        return permission::all();
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    public function create(array $attributes)
    {
        // TODO: Implement create() method.
    }

    public function update($id, array $attributes)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    //Get value with id_contract
    public function getPerWithIdContract($id_contract){
        return permission::where('id_contract', $id_contract)->get();
    }
}
