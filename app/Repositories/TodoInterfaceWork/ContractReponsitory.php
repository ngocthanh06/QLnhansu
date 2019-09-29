<?php


namespace App\Repositories\TodoInterfaceWork;


interface ContractReponsitory
{
    //get all
    public function getAll();
    //get info with id
    public function getByid($id);
    //create
    public function create(array $attributes);
    //update
    public function update($id,array $atributes);
    //delete
    public function delete($id);
//check number attendance infomation of contract
    public function checkAtten($id);
    //get contract with id_contract
    public function getContractIdAccount($id);
}
