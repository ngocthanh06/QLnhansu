<?php

use Illuminate\Database\Seeder;

class TypeContract extends Seeder
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
            ['name_type' => 'Fulltime'],
            ['name_type' => 'Parttime']
        ];
        DB::table('type_contract')->insert($data);
    }
}
