<?php

use Illuminate\Database\Seeder;

class account extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data = [
            [ 'username'=>'ngocthanh06',
             'password'=>bcrypt('123123'),
             'name'=>'Đào Ngọc Thạnh',
             'id_role'=>'1',
             'address'=>'123123',
             'sex'=>true,
             'info'=>'3',
             'passport'=>'123123123',

             ],
            //  [ 'username'=>'ngocthanh06',
            //  'password'=>bcrypt('123123'),
            //  'name'=>'Đào Ngọc Thạnh',
            //  'id_role'=>'1',
            //  'address'=>'123123',
            //  'sex'=>true,
            //  'info'=>'3',
            //  'image'=>' ',
            //  'passport'=>'123123123',
            //  ],

         ];

     DB::table('account')->insert($data);
    }
}
