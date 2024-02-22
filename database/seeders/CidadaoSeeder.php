<?php

namespace Database\Seeders;

use App\Models\Cidadao;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Faker\Provider as FakerProvider;

class CidadaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $faker = FakerFactory::create();
        $faker->addProvider(new FakerProvider\pt_BR\Address($faker));
        $faker->addProvider(new FakerProvider\pt_PT\Person($faker));
        foreach(range(0, 1000) as $index){
            $faker->addProvider(new FakerProvider\pt_BR\Address($faker));
            Cidadao::create([
                'n_bi' => $faker->regexify('[0-9]{9}[A-Z]{2}[0-9]{3}'),
                'nome' => $faker->name('Y-m-d'),
                'data_nascimento' => $faker->dateTimeBetween(),
                'nacionalidade' => $faker->country(),
                'nome_pai' => $faker->name(),
                'nome_mae' => $faker->name(),
                'data_bi_validade' => $faker->date(),
                'data_bi_emissao' => $faker->date() ,
                'estado_civil' => random_int(0,1) == 0 ? 'solteiro' : 'casado',
                'residencia' => $faker->city(),
                'sexo'=> random_int(0,1) == 0 ? 'M' : 'F' ,
                'provincia' => $faker->state(),
                'altura' => $faker->randomFloat(2, 1.50, 2.00)
            ]);
        }
    }
}
