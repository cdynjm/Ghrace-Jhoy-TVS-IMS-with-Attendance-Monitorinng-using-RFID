<?php

namespace App\Repositories\Interfaces;

interface RegistrarInterface {

    public function Courses();
    public function CourseInfo($request);

    public function Enrollees($request);
    public function searchEnrollees($request);
    public function StudentGrades($request);
    public function searchStudentGrades($request);

    public function UnscheduledLearnersProfile();
    public function searchUnscheduledLearnersProfile($request);
    public function UnscheduledLearnersCourse();

    public function LearnersProfile($request);
    public function LearnersCourse($request);
    public function LearnersClass($request);
    public function LearnersWork($request);

    public function PSA();
    public function Form137();

    public function ExamLearnersProfile();
    public function searchExamLearnersProfile($request);
    public function ExamLearnersCourse();

    public function InterviewLearnersProfile();
    public function SecondInterviewLearnersProfile();
    public function searchInterviewLearnersProfile($request);
    public function searchSecondInterviewLearnersProfile($request);
    public function InterviewLearnersCourse();

    public function FinalResultLearnersProfile();
    public function searchFinalResultLearnersProfile($request);
    public function FinalResultLearnersCourse();

    public function Status();

    public function Schedule();
    public function getSpecificSchedule($request);

    public function yearLevel($request);
    public function studentGrading($request);

    public function Students();

    public function Graduates($request);
    public function searchGraduates($request);
    public function Undergraduates($request);
    public function searchUndergraduates($request);
    public function ViewAttendance($request);
    public function searchViewAttendance($request);

    public function RFIDAttendance($request);

}


?>
