<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Weidner\Goutte\GoutteFacade as GoutteFacade;
use DB;

class Scraping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:scraping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $goutte = GoutteFacade::request('GET', 'https://news.yahoo.co.jp/');
        $goutte->filter('.gEuKmd')->each(function ($ul) {
            $ul->filter('li')->each(function ($li) {

                $articles = DB::table('articles')->get();

                foreach ($articles as $article) {
                    echo $article->title;
                    echo "\n";
                }
                
            });
    });

}
}