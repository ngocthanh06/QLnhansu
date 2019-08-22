<?php

namespace App\Http\Controllers\Admin;

use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ExcelController extends Controller implements FromCollection, WithHeadings
{

    protected $id;

    public function __construct($i){
        $this->id = $i;
    }

    //
    public function collection(){
        $num = 1;
        if($this->id == 'all')
        $customer_data = DB::table('account')->join('contract','contract.id_account','account.id')->join('salary','salary.id_attent','contract.id')->join('role','role.id','account.id_role')->get()->toArray();
        else
        $customer_data = DB::table('account')->join('contract','contract.id_account','account.id')->join('salary','salary.id_attent','contract.id')->join('role','role.id','account.id_role')->whereMonth('reviced_date',$this->id)->get()->toArray();
        if($customer_data != null) {
            foreach ($customer_data as $customer) {
                $customer_array[] = array(
                    'STT' => $num++,
                    'Tên nhân viên' => $customer->name,
                    'CMND' => $customer->passport,
                    'STK' => $customer->num_account,
                    'Chức vụ' => $customer->name_role,
                    'BHXH' => $customer->BHXH,
                    'Ngày công thực tế' => $customer->num_attendance,
                    'Thưởng' => number_format($customer->reward),
                    'Phụ cấp' => number_format($customer->allowance),
                    'TN trước thuế' => number_format($customer->sum_position),
                    'Thuế TNCN 5%' => number_format($customer->sum_position * 5 / 100),
                    'Thực lĩnh' => number_format($customer->sum_position - $customer->sum_position * 5 / 100),
                    'Ngày lĩnh' => $customer->reviced_date,
                );
            }
            return (collect($customer_array));
        }
        else
            return (collect(null));
    }
    public function headings():array{
        return [
            'STT',
            'Tên nhân viên',
            'CMND',
            'STK',
            'Chức vụ',
            'BHXH',
            'Ngày công thực tế',
            'Thưởng',
            'Phụ cấp',
            'TN trước thuế',
            'Thuế TNCN 5%',
            'Thực lĩnh',
            'Ngày lĩnh',
        ];
    }
}
