<?php


namespace App\Repositories\Work;


use App\Models\contract;
use App\Repositories\TodoInterfaceWork\ContractReponsitory;

class ContractEloquent implements ContractReponsitory
{

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function getByid($id)
    {
       return contract::find($id);
    }

    public function create(array $attributes)
    {
        // TODO: Implement create() method.
    }

    public function update($id, array $atributes)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
    //
    public function checkAtten($id){
        $data = $this->getByid($id);
        return $data->checkAttend()->paginate(10);
    }
    //get id contract with id account
    public function getContractIdAccount($id){
        return contract::select('id')->where('id_account',$id)->whereNull('date_end')->first() ;
    }
}
