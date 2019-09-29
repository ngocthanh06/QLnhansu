<?php


namespace App\Repositories\TodoInterfaceWork;


interface AcceptSalaryReponsitory
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
}
