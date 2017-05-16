<?php

use Illuminate\Database\Seeder;
use App\User; 


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = [
        					[
        						'name' => 'admin',
        						'email' => 'info@gmail.com',
        						'password' => '$2y$10$jfAxmaNNOY8Kd.MUjhlSHex8k8FkunPzd4iGa.CHj96gQ/t/W5IWS',
        						'is_admin' => '1'
        					],
        					  					
        			   ];
					   
		foreach($users as $key=>$value)
		{
			User::create($value);
		}	
        
    }
}
