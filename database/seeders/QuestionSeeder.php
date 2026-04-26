<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'question_text' => 'Apa kepanjangan dari PHP?',
                'options' => ['Personal Home Page', 'Hypertext Preprocessor', 'Programming Home Page', 'Public Home Page'],
                'correct_answer' => 'Hypertext Preprocessor',
            ],
            [
                'question_text' => 'Framework PHP populer yang kami gunakan adalah?',
                'options' => ['Django', 'Spring', 'Laravel', 'Express'],
                'correct_answer' => 'Laravel',
            ],
            [
                'question_text' => 'Database apa yang disarankan untuk Laravel?',
                'options' => ['PostgreSQL', 'MySQL', 'MongoDB', 'Semua benar'],
                'correct_answer' => 'Semua benar',
            ],
            [
                'question_text' => 'ORM Laravel disebut?',
                'options' => ['Eloquent', 'Query Builder', 'Doctrine', 'Sequelize'],
                'correct_answer' => 'Eloquent',
            ],
            [
                'question_text' => 'Perintah mana untuk membuat controller di Laravel?',
                'options' => ['php artisan controller:make TestController', 'php artisan make:controller TestController', 'php artisan generate:controller TestController', 'php artisan create:controller TestController'],
                'correct_answer' => 'php artisan make:controller TestController',
            ],
            [
                'question_text' => 'Apa itu middleware di Laravel?',
                'options' => ['Database layer', 'HTTP request/response filter', 'Template engine', 'CSS preprocessor'],
                'correct_answer' => 'HTTP request/response filter',
            ],
            [
                'question_text' => 'Cara menjalankan migration di Laravel?',
                'options' => ['php artisan migrate', 'php artisan db:migrate', 'php artisan run:migrate', 'php artisan migration:run'],
                'correct_answer' => 'php artisan migrate',
            ],
            [
                'question_text' => 'Apa fungsi view di Laravel?',
                'options' => ['Mengontrol logika aplikasi', 'Menyimpan data', 'Menampilkan UI ke user', 'Mengatur route'],
                'correct_answer' => 'Menampilkan UI ke user',
            ],
            [
                'question_text' => 'Syntax Blade untuk echo variable adalah?',
                'options' => ['<%= variable %>', '{{ variable }}', '<? variable ?>', '<?php echo variable; ?>'],
                'correct_answer' => '{{ variable }}',
            ],
            [
                'question_text' => 'Cara membuat migration file di Laravel?',
                'options' => ['php artisan make:migration create_table_name', 'php artisan migration:create table_name', 'php artisan create:migration table_name', 'php artisan migration:make table_name'],
                'correct_answer' => 'php artisan make:migration create_table_name',
            ],
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
