<?php


namespace App\Repositories\TodoInterfaceWork;


interface AccountReponsitory
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
    //get role
    public function getRole();
    //get list account with id_role
    public function getListAccountWithIDRole($id);
    //get list account with contract
    public function getListAccWithContractIDrole($id);
    //Get list attendance with id_contract with two
    public function listAttendanceWithIdContractTwo($id,$data);
    //Get list attendance when haven't attendance
    public function listAttendanceWithHaveNot($id);

}
