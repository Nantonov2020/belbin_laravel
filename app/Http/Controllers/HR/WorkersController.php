<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkersController extends Controller
{
   public function showAllWorkers($idCompany)
   {
       return view('hr.workers');
   }

   public function showOneWorker($idWorker)
   {
       return view('hr.worker');
   }
}
