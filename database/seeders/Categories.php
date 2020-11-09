<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
class categories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Category::truncate();

        Category::create(['category'=>"Javascript",'image'=>'https://www.educative.io/api/page/5330288608542720/image/download/6288755792019456']);
        Category::create(['category'=>"Php",'image'=>"https://media.proglib.io/wp-uploads/2019/01/Screenshot_3.jpg"]);
        Category::create(['category'=>"Python",'image'=>"https://i2.wp.com/itc.ua/wp-content/uploads/2018/09/3-1.jpg"]);
        Category::create(['category'=>"HTML",'image'=>"https://cdn.lynda.com/course/170427/170427-637363828865101045-16x9.jpg"]);
        Category::create(['category'=>"CSS",'image'=>"https://it-black.ru/wp-content/uploads/2019/04/nasledovanie_css.png"]);
        Category::create(['category'=>"Vue",'image'=>"https://media.proglib.io/wp-uploads/2018/07/1_qnI8K0Udjw4lciWDED4HGw.png"]);
        Category::create(['category'=>"React",'image'=>"https://reactjs.org/logo-og.png"]);
        Category::create(['category'=>"Angular",'image'=>"https://repository-images.githubusercontent.com/24195339/87018c00-694b-11e9-8b5f-c34826306d36"]);
        echo 'categories created';
    }
}
