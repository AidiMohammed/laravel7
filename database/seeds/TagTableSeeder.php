<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags =collect(['Games','Travels','Devs','Trading','News','Cars','Books','PHP','Laravel','Smfony']);

        $tags->each(function($tag){
            $myTag = new Tag();
            $myTag->name = $tag;
            $myTag->save();
        });
    }
}
