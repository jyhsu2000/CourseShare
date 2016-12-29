<?php

namespace App\Console\Commands;

use App\Course;
use Illuminate\Console\Command;

class CourseParse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'course:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse all courses';

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
        /** @var Course[] $courses */
        $courses = Course::orderBy('updated_at')->get();

        //進度條
        $bar = $this->output->createProgressBar(count($courses));
        $bar->setFormat(" %message%\n %current%/%max% [%bar%] %percent:3s%%");
        $bar->setMessage('Task starts');
        $bar->start();
        foreach ($courses as $course) {
            //顯示用訊息
            $message = 'Parse: ' . $course->id . ' ' . $course->sub_name;
            $course->parse();
            $bar->setMessage($message);
            $bar->advance();
        }
        $bar->finish();

        $this->info('');
        $this->info('Course parse finished');
    }
}
