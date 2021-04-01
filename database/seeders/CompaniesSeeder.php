<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    private $companies = ['Восточная генерация',
                        'Ресурсное снабжение',
                        'Восток',
                        'МосГлавСнаб',
                        'КрасЭнергоВидео',
                        'СибПрайд',
                        'АлтайРазноторг',
                        'Пищевые концерны',
                        'Сибирские дикоросы',
                        'Васюган',
                        'НарымЭнерго',
                        'Славянский базар',
                        'Местные напитки',
                        'Три медведя',
                        'Академия',
                        'Альфа',
                        'Инновация',
                        'Птицефабрика',
                        'СибСнаб'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < count($this->companies); $i++){
            \DB::table('companies')->insert(['name' => $this->companies[$i]]);
        }
    }
}
