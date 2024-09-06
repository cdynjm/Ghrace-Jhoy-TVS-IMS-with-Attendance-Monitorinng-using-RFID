<?php

namespace App\Repositories\Interfaces;

interface TrainerInterface {

    public function Schedule();
    public function getSchedule($request);
    public function Students($request);

}

?>
