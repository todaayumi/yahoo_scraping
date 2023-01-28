<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Weidner\Goutte\GoutteFacade as GoutteFacade;
use DB;
use App\Article;

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
        $goutte = GoutteFacade::request('GET', 'https://news.yahoo.co.jp/topics/top-picks');
        $DB_lates = Article::orderBy('created_at', 'desc')->limit(8)->get();
        
        $goutte->filter('.newsFeed_list')->each(function ($ul) {
          $ul->filter('.newsFeed_item')->each(function ($li) {
            $li->filter('.newsFeed_item_link')->each(function ($a){
                echo $a->filter('.newsFeed_item_title')->text();
                echo "\n";
                echo $a->attr('href');
                echo "\n";
                echo $a->filter('time')->text();
                echo "\n";
            
        });
                
            });
        });
    }

                



}
