<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::all();
        $numberPosts = (int)$this->command->ask('How many posts you want to create ?? ',10);
        if($numberPosts < 1 && $users->count == 0)
        {
            if($numberPosts < 1)
            {
                $this->command->info("You cannot create {$numberPosts} posts by defalut 10 posts will be created");
                $numberPosts = 10;
            }
            elseif($users->count() == 0)
            {
                $this->command->info("To be able to create posts, you must first create accounts for users");
                return;
            }
        }
        
        factory(App\Post::class,$numberPosts)->make()->each(function($post) use($users){
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}
