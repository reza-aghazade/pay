<?php
namespace Limito\Pay\Seed;
use Illuminate\Database\Seeder;

class TransactionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach ($this->s as $k) {
            DB::table('transaction_types')->insert([
                'id' => $k['id'],
                'disposable' => $k['disposable'],
                'description' => $k['description'],
                'type' => $k['type'],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }

    protected $s = [
        [
            'id' => 1,
            'type' => 1,
            'disposable' => 1,
            'description' => 'افزایش اعتبار از طریق درگاه بانکی',
        ],
        [
            'id' => 2,
            'type' => 2,
            'disposable' => 0,
            'description' => 'کسر از اعتبار بابت درخواست واریز',
        ],
    ];
}
