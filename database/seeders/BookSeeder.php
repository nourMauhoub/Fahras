<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Book::factory()->create(['title'=>'12 Rules for Life','author'=>'Jordan B. Peterson', 'image'=> 'https://source.unsplash.com/random', 'description'=>"Jordan Peterson weaves together personal anecdotes, intellectual history, and religious imagery into a truly unique book that explores how to live a life full of meaning and purpose.", "isbn"=>'9780735277458']);
        Book::factory()->create(['title'=>'Who Moved my Cheese','author'=>'Spencer Johnson', 'image'=> 'https://source.unsplash.com/random', 'description'=>"A simple parable that reveals profound truths about change.", "isbn"=>'0-399-14446-3']);
        Book::factory()->create(['title'=>'Highlighted in Yellow','author'=>'H. Jackson Brown', 'image'=> 'https://source.unsplash.com/random', 'description'=>" A Short Course In Living Wisely And Choosing Well. ", "isbn"=>'9781558538344']);
    }

}
