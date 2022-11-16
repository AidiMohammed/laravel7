<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = App\Post::all();
        $users = App\User::all();

        $numberComments = (int)$this->command->ask('How many Comments you want to create ?? ',200);
        if($numberComments < 1 && $posts->count == 0 && $users->count == 0)
        {
            if($numberComments < 1)
            {
                $this->command->info("You cannot create {$numberComments} comment \n By defalut 10 comments will be created");
                $numberComments = 10;
            }
            elseif($posts->count ==0)
            {
                $this->command->info('To be able to create commnets, you must first create posts');
                return;
            }
            elseif($users->count == 0)
            {
                $this->command->info('To be able eo create comments, you must first create accounts for users');
                return;
            }
        }

        factory(App\Comment::class,$numberComments)->make()->each(function($comment)use ($posts,$users){
            $comment->post_id = $posts->random()->id;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
