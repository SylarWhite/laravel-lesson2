<?php

use Illuminate\Database\Seeder;
use App\Models\User;



class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//        $users = factory(User::class)->times(2)
//            ->make()->each(function ($user,$index) use ($faker, $avatars){
//                $user->avatar = $faker->randomElement($avatars);
//            });

//        $user_array = $users->makeVisible(['password','remember_token'])->toArray();

//        User::insert($user_array);
        // 初始化用户角色，将 1 号用户指派为『站长』
        $user = new User();
        $user->name = 'Sylar';
        $user->email = 'sylar@qq.com';
        $user->avatar = 'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png';
        $user->save();
        $user->assignRole('Founder');


        // 将 2 号用户指派为『管理员』
        $user1 = new User();
        $user1->assignRole('Maintainer');
        $user1->name = 'admin';
        $user1->email = 'admin@qq.com';
        $user1->avatar = 'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png';
        $user1->save();

    }
}
