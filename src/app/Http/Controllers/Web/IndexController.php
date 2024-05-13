<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Api\Controller;


class IndexController extends Controller
{
  public function main()
  {
    return view("main");
  }
}
