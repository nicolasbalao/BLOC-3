<?php

namespace App\Controllers;

use App\Controllers\Controller;

class HomePageController extends Controller
{


    public function index()
    {
        $title = "Home page";
        $this->render("homePage", compact("title"));
    }
}
