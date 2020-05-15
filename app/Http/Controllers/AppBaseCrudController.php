<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

abstract class AppBaseCrudController extends AppBaseController
{
    abstract public function index(Request $request);

    abstract public function store(Request $request);

    abstract public function show(Request $request);

    abstract public function update(Request $request);

    abstract public function destroy(Request $request);

}