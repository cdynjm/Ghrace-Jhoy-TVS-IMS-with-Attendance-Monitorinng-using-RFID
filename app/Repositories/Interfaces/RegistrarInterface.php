<?php

namespace App\Repositories\Interfaces;

interface RegistrarInterface {

    public function Courses();
    public function CourseInfo($request);

    public function Enrollees($request);
    public function StudentGrades($request);

    public function UnscheduledLearnersProfile();
    public function UnscheduledLearnersCourse();

    public function LearnersProfile($request);
    public function LearnersCourse($request);
    public function LearnersClass($request);
    public function LearnersWork($request);

    public function PSA();
    public function Form137();

    public function ExamLearnersProfile();
    public function ExamLearnersCourse();

    public function InterviewLearnersProfile();
    public function SecondInterviewLearnersProfile();
    public function InterviewLearnersCourse();

    public function FinalResultLearnersProfile();
    public function FinalResultLearnersCourse();

    public function Status();

    public function Schedule();

    public function yearLevel($request);
    public function studentGrading($request);

    public function Students();

    public function Graduates($request);
    public function Undergraduates($request);

}


?>
