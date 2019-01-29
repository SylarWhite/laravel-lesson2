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
        // 获取实例
        $faker = app(Faker\Generator::class);

        $avatars = [
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/s5ehp11z6s.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/Lhd1SHqu86.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/xAuDMxteQy.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/NDnzMutoxX.png',
        ];

        $users = factory(User::class)->times(1)
            ->make()->each(function ($user,$index) use ($faker, $avatars){
                $user->avatar = $faker->randomElement($avatars);
            });

        $user_array = $users->makeVisible(['password','remember_token'])->toArray();

        User::insert($user_array);
        // 初始化用户角色，将 1 号用户指派为『站长』
        $user = User::find(1);
        $user->assignRole('Founder');
        $user->name = 'Sylar';
        $user->email = 'sylar@qq.com';
        $user->avatar = 'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png';
        $user->save();

        // 将 2 号用户指派为『管理员』
//        $user = User::find(2);
//        $user->assignRole('Maintainer');

    }
}
