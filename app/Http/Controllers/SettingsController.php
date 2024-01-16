<?php
/**

 * Time: 13:07
 */
namespace App\Http\Controllers;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('app.settings.index');
    }
}