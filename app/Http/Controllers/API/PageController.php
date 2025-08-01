<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

class PageController extends Controller
{
    public function show($page)
    {
        $viewName = 'welcome' . $page;
        if (View::exists($viewName)) {
            return view($viewName);
        }
        abort(404);
    }
}