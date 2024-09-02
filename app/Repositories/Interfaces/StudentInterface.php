<?php

namespace App\Repositories\Interfaces;

interface StudentInterface {

    public function PSA();
    public function Form137();
    public function Tracker();
    public function LearnersProfile();
    public function LearnersCourse();
    public function LearnersClass();
    public function LearnersWork();

    public function yearLevel();
    public function subjectSchedule();
    public function studentGrading();
    
}

?>
