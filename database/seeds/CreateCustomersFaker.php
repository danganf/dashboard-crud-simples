<?php

use Illuminate\Database\Seeder;

class CreateCustomersFaker extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run( \Danganf\MyClass\JsonBasic $json )
    {
        $faker     = Faker\Factory::create();
        $fakerBR   = Faker\Factory::create('pt_BR');
        $faker->addProvider(new \JansenFelipe\FakerBR\FakerBR($faker));

        for ( $i=1; $i<=50; $i++ ){
            $data['name']     = $faker->name;
            $data['email']    = $faker->email;
            $data['document'] = $faker->cpf;
            $data['phone']    = substr( $faker->e164PhoneNumber, 3 );
            $data['status']   = 1;
            $json->set( json_encode( $data ) );
            ( new \App\Repositories\CustomerRepository() )->createOrUpdate( $json );
        }
    }
}
