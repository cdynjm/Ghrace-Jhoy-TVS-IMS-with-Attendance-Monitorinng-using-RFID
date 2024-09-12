<?php

namespace App\Repositories\Interfaces;

interface AdminInterface {

    public function Logs();
    public function Courses();
    public function Instructors();

    public function CourseInfo($request);
    public function getCourseInfo($request);
    public function searchCourseInfo($request);
    public function Subjects($request);

    public function Schedule($request);
    public function SubjectSchedule($request);
    
    public function Students();

    public function Graduates($request);
    public function searchGraduates($request);
    public function Undergraduates($request);
    public function searchUndergraduates($request);
    public function ViewAttendance($request);
    public function searchViewAttendance($request);
    public function RFIDAttendance($request);
    public function LearnersProfile($request);

    public function yearLevel($request);
    public function studentGrading($request);



}

?>
