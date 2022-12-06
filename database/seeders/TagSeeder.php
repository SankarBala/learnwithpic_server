<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::factory(10)->create();

        // $tags = Tag::all();
        // $posts = Post::all();

        // foreach ($posts as $index => $post) {
        //     $post->tags()->attach($tags[$index]);
        // }
    }
}
