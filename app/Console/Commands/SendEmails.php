<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

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
     * @return mixed
     */
    public function handle()
    {
        //
        echo"hello-->s";
       // /var/www/html
       $myfile = fopen("/var/www/html/newfile.txt", "a") or die("Unable to open file!");
        $time = date('h:i:s');
        fwrite($myfile, $time);
        fclose($myfile);
    }
}
