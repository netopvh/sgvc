<?php

use Illuminate\Database\Seeder;
use App\Models\Access\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Seeder de Perfis

        DB::table('roles')->insert([
            ['name' => 'Super Administrador', 'all' => true, 'sort' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'Administrador', 'all' => false, 'sort' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'Usuário', 'all' => false, 'sort' => 3, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]
        ]);

        //Seeder de Permissões

        DB::table('permissions')->insert([
            ['name' => 'view-admin', 'display_name' => 'Ver Administração', 'sort' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'manage-users', 'display_name' => 'Gerenciar Usuários', 'sort' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'manage-roles', 'display_name' => 'Gerenciar Perfis', 'sort' => 3, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'manage-config', 'display_name' => 'Gerenciar Parâmetros', 'sort' => 4, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'manage-logs', 'display_name' => 'Gerenciar Logs', 'sort' => 5, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'manage-contratantes', 'display_name' => 'Gerenciar Contratantes', 'sort' => 6, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'manage-contratados', 'display_name' => 'Gerenciar Contratados', 'sort' => 7, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'manage-unidades', 'display_name' => 'Gerenciar Unidades', 'sort' => 8, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'manage-contratos', 'display_name' => 'Gerenciar Contratos', 'sort' => 9, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'manage-aditivos', 'display_name' => 'Gerenciar Aditivos', 'sort' => 10, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]
        ]);

        $roleAdmin = Role::find(2);
        $roleAdmin->attachPermissions([1,2,3,4]);

        $roleUser = Role::find(3);
        $roleUser->attachPermissions([1,2,3,4]);

        DB::table('casas')->insert([
            ['name' => 'SESI', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'SENAI', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'FIERO', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'IEL', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]
        ]);

        DB::table('unidades')->insert([
            ['name' => 'Casa da Indústria', 'casa_id' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'SESI Escola Porto Velho', 'casa_id' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'SESI Clinica Porto Velho', 'casa_id' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'Casa da Indústria', 'casa_id' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'SENAI Marechal Rondon', 'casa_id' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'SENAI CETEM', 'casa_id' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'SENAI CEET', 'casa_id' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'Casa da Indústria', 'casa_id' => 3, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'Casa da Indústria', 'casa_id' => 4, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]
        ]);

        $faker = Faker\Factory::create('pt_BR');

        DB::table('empresas')->insert([
            ['razao' => $faker->company, 'fantasia' => $faker->companySuffix, 'cpf_cnpj'=>$faker->cnpj(false), 'tipo_pessoa'=>'PJ','responsavel'=> $faker->name, 'email'=> $faker->companyEmail, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['razao' => $faker->company, 'fantasia' => $faker->companySuffix, 'cpf_cnpj'=>$faker->cnpj(false), 'tipo_pessoa'=>'PJ','responsavel'=> $faker->name, 'email'=> $faker->companyEmail, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['razao' => $faker->company, 'fantasia' => $faker->companySuffix, 'cpf_cnpj'=>$faker->cnpj(false), 'tipo_pessoa'=>'PJ','responsavel'=> $faker->name, 'email'=> $faker->companyEmail, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['razao' => $faker->company, 'fantasia' => $faker->companySuffix, 'cpf_cnpj'=>$faker->cnpj(false), 'tipo_pessoa'=>'PJ','responsavel'=> $faker->name, 'email'=> $faker->companyEmail, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['razao' => $faker->company, 'fantasia' => $faker->companySuffix, 'cpf_cnpj'=>$faker->cnpj(false), 'tipo_pessoa'=>'PJ','responsavel'=> $faker->name, 'email'=> $faker->companyEmail, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]
        ]);

    }
}
