<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // \App\Models\User::factory()->create([
        //     'name' => 'Sankar Bala',
        //     'email' => 'sankarbala232@gmail.com',
        // ]);
        // \App\Models\User::factory(10)->create();

        $this->call([
            // CategorySeeder::class,
            VisitorSeeder::class,
            // TagSeeder::class,
            // CommentSeeder::class,

            // Related model linker
            // $this->cat_post_linker(),
        ]);
    }

    public function cat_post_linker()
    {
        $posts = Post::all();
        $cats  = Category::all()->toArray();
        $tags  = Tag::all()->toArray();

        foreach ($posts as $index => $post) {
            $post->categories()->attach(array_slice($cats, rand(1, 5), rand(5, 10)));
            $post->tags()->attach(array_slice($tags, rand(1, 5), rand(5, 10)));
        }
    }
}
