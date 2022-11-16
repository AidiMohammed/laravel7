<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $numberUsers = (int)$this->command->ask('How many users you want to create ?? ',10);
        if($numberUsers < 1)
        {
            $this->command->info("You cannot create {$numberUsers} user by defalut 10 users will be created");
            $numberUsers = 10;
        }
        factory(App\User::class,$numberUsers)->create();
    }
}
