<?php

use App\Post;
use App\Tag;
use Illuminate\Database\Seeder;

class PostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagCount = Tag::count();

        Post::all()->each(function($post) use($tagCount){
            $tag = random_int(1,$tagCount);
            $TagsIds = Tag::inRandomOrder()->take($tag)->get()->pluck('id');

            $post->tags()->sync($TagsIds);
        });
    }
}
