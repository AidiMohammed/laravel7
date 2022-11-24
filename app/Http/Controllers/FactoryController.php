<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Seeder;

class FactoryController extends Controller
{
    public function createPosts(Request $request)
    {
        /*$request->validate([
            'nmbrPosts' => 'required'
        ]);

        $numberPosts = $request->input('nmbrPosts');

        if($request->input('nmbrPosts') < 1)
        {
            session()->flash('status','number of posts to create and less than zero');
            return redirect()->route('home.homePagae');
        }

        for ($i=0; $i < $request->input('nmbrPosts'); $i++) { 
            factory('App\Post')->create();
        }

        session()->flash('status',"factories $numberPosts posts ");*/
        return redirect()->back();
    }
}
