<?php

use Illuminate\Database\Seeder;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach ($this->s as $k) {
            DB::table('banks')->insert([
                'id' => $k['id'],
                'name' => $k['name'],
                'logo_id' => $k['logo_id'],
                'status' => $k['status'],
                'type' => $k['type'],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }

    protected $s = [
        [
            'id' => 1,
            'name' => 'zarinpal',
            'logo_id' => 0,
            'status' => 'enable',
            'type' => 'online',
        ],
    ];
}
