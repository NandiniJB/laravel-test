<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function store() {
        Author::create(request([
            'name', 'dob'
        ]));
    }

    public function validateRequest() {
        return request()->validate([
            'name' => 'required',
            'dob' => 'required'
        ]);
    }
}
