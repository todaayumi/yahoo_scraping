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

                //$article = new Article;
                //$article->title = $a->filter('.newsFeed_item_title')->text();
                //$article->url = $a->attr('href');
                $datetime = $a->filter('time')->text();
                //$article->save();

                $year = date('Y');
                $month = mb_strlen(date('n'));
                $day = mb_strlen(date('j'));
                
                if($month = 1){
                    if($day = 1){
                        $date = $year .'-0' . str_replace('/', '-', substr($datetime, 0, 4))
                                . ' '. substr($datetime, 9, 13) . ':00';
                                ;
                    }else{
                        $date = $year . '-0' . str_replace('/', '-', substr($datetime, 0, 5))
                                .' '. substr($datetime, 10, 14) . ':00';
                    }
                }else{
                    if($day = 1){
                        $date = $year . '-0' . str_replace('/', '-', substr($datetime, 0, 5))
                        .' '. substr($datetime, 10, 14) . ':00';
                    }else{
                        $date = $year . '-0' . str_replace('/', '-', substr($datetime, 0, 6))
                        .' '. substr($datetime, 11, 15) . ':00';
                    }
                }

                echo $date;
            
            
                
                
                
                
            
        });
                
            });
        });
    }

                



}
