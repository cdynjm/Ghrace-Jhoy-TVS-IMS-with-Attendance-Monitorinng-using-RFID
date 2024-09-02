<?php

namespace App\Repositories\Interfaces;

interface AdminInterface {

    public function Logs();
    public function Courses();
    public function Instructors();

    public function CourseInfo($request);
    public function getCourseInfo($request);
    public function Subjects($request);

    public function Schedule($request);
    public function SubjectSchedule($request);
    
    public function Students();
}

?>
