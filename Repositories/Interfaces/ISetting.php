<?php

namespace App\Repositories\Interfaces;


interface ISetting extends IModelRepository
{

    public function  getAppInformation();
    public function  reports();
    public function  updateSetting($data = []);
    public function  sendEmail($data = []);

}
