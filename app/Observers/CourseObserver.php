<?php

namespace App\Observers;

use App\Course;

class CourseObserver
{
    public function created(Course $course)
    {
        $course->parse();
    }

    public function saved(Course $course)
    {
        $course->parse();
    }
}
