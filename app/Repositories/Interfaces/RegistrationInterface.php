<?php

namespace App\Repositories\Interfaces;

interface RegistrationInterface {

    public function Region();
    public function Province($request);
    public function Municipal($request);
    public function Barangay($request);

    public function BirthplaceProvince($request);
    public function BirthplaceMunicipal($request);

    public function Courses();
}

?>
