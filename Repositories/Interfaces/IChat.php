<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface IChat extends IModelRepository
{
    public function whereIn($array , $type = 'id');
    public function createMessage($attributes = []);
    public function getUserMessages();
    public function getMessages($attributes = []);
    public function countConversations();
}
