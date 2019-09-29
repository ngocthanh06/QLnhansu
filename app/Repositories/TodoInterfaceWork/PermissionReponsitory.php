<?php


namespace App\Repositories\TodoInterfaceWork;


interface PermissionReponsitory
{
    //get All info
    public function getAll();
    //get info with id
    public function getById($id);
    //create info
    public function create(array $attributes);
    //update
    public function update($id, array $attributes);
    //delete
    public function delete($id);
    //get value with id_contract
    public function getPerWithIdContract($id_contract);
}
