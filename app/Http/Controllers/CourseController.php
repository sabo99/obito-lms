<?php

namespace App\Http\Controllers;

class CourseController extends Controller
{
    public function index()
    {
        return view('dashboard.courses.index');
    }

    public function details()
    {
        return view('dashboard.courses.show');
    }

    public function searchCourses()
    {
        return view('dashboard.courses.search');
    }

    public function join()
    {
        return view('dashboard.courses.join');
    }

    public function learning()
    {
        return view('dashboard.courses.learning');
    }

    public function learningFinished()
    {
        return view('dashboard.courses.finished');
    }
}
