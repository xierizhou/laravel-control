<?php


namespace Rizhou\Control\Controllers;


use App\Http\Controllers\Controller;
use Rizhou\Control\Supply\StoreSynchronizing;

class StoreController extends Controller
{
    public function synchronizing(){
        StoreSynchronizing::make()->synchro();
    }
}
