<?php
namespace App\Controller;

class ContactController
{
    public function index()
    {
        return view('contact');
    }

    public function store()
    {
        var_dump($_POST);
    }
}
