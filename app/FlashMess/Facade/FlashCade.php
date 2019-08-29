<?php
namespace App\FlashMess\Facade;

use Illuminate\Support\Facades\Facade;

class FlashCade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'flashmess';
    }
}
