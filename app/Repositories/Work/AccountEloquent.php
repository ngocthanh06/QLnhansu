<?php


namespace App\Repositories\Work;
use App\Models\account;
use App\Repositories\TodoInterfaceWork\AccountReponsitory;
use Carbon\Carbon;
use Hamcrest\Core\IsNull;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function foo\func;

class AccountEloquent implements AccountReponsitory
{
    //get list account
    public function getAll()
    {
        return account::all();
    }

    //get id
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

    public function getRole()
    {
         return account::find(Auth::user()->id_role)->getRole;
    }

    //get list account with id_role
    public function getListAccountWithIDRole($id)
    {
        return account::where('id_role',$id)->paginate(10);
    }

    //get list account with id_role and contract
    public function getListAccWithContractIDrole($id)
    {
        $time = Carbon::now();
        return DB::table('account')
//            ->select('account.id as id_account','account.name','attendance.id_contract', 'attendance.id as id_attendance','attendance.permission',
//                'attendance.day','attendance.checkin','attendance.checkout','attendance.status as status_attendance',
//                'contract.id as contract_id', 'contract.name_contract','contract.date_end','contract.date_start')
            ->leftJoin('contract','contract.id_account','account.id')

            ->where('account.id_role',$id)
            ->leftJoin('attendance','attendance.id_contract','contract.id')
            ->where('attendance.day',$time->toDateString())
            ->whereNull('contract.date_end')->paginate(10);
    }

    //get list account with contract
    public function listAttendanceWithIdContractTwo($id,$data )
    {
            //Get list account with contract
            $value = DB::table('account')
                ->Join('contract', 'contract.id_account', 'account.id')
                ->where('account.id_role', $id)
                ->whereNull('contract.date_end')
                ->groupBy('account.id')
                ->get();
            //Check value data id account isset day attendance now
            foreach($data as $da){
                foreach($value as $val=>$key){
                    if($da->id_account == $key->id_account ){
                        //Delete value in array
                        unset($value[$val]);
                    }
                }
            }
        return $value;

        }
    public function listAttendanceWithHaveNot($id){
        return DB::table('account')
            ->Join('contract', 'contract.id_account', 'account.id')
            ->where('account.id_role', $id)
            ->whereNull('contract.date_end')
            ->get();
    }
}
