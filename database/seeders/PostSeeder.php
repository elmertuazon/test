<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory()
                ->count(50)
                ->create();
        $list = [];
        for($i = 0; $i <= 50; $i++)
        {
            array_push($list, ['post_id'=>rand(1,10), 'tags_id'=>rand(1,10)]);
        }
        
        DB::table('pivot_post_and_tag')->insert($list);
    }
}
