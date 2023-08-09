<?php

namespace App\Http\Controllers;

use App\Models\Sex;
use Illuminate\Database\Eloquent\Collection;

class SexController extends Controller
{
    public function list(  ):Collection
    {
        return Sex::all();
    }
}
