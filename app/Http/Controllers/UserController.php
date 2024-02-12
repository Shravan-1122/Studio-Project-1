<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usertables;
use App\Models\User;
use App\Models\Webseries;
use App\Models\Theme;

class UserController extends Controller
{
    public function index()
    {
        
        return view('register');
    }
    
    // public function store(Request $request)
    // {
       
    //     $webSeriesId = 1;

    //     // Assuming $webSeriesId contains the ID of the web series you want to retrieve
    //     $webSeries = WebSeries::find($webSeriesId);
    //     print_r($webSeries);
        
    //     if ($webSeries) {
    //         $themeId = $webSeries->theme_id;
        
    //         // Find the theme with the retrieved theme ID
    //         $theme = Theme::find($themeId);
        
    //         if ($theme) {
    //             echo "Theme: " . $theme->theme_title;
    //         } else {
    //             echo "Theme not found.";
    //         }
    //     } else {
    //         echo "Web Series not found.";
    //     }
    //     exit;


    // }
    public function store(Request $request)
    {
        $storeData = $request->validate([
            'email' => 'required|max:255|unique:users',
            'name'=>'required',
            'password' => 'required|max:255',
        ]);
        $request->session()->put('email', $request->email);

        $user = User::create($storeData);
        return view('login');
      
    }
   
   
    
    public function index2()
    {
        return view('login')->withSuccess('Register successfully you can login now');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
        ]);     
    
        $user = User::where('email', $request->email)->first();  
    
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'The provided email or password is incorrect.']);
        }
    
        if (($request->password!= $user->password)) {
            return redirect()->back()->withErrors(['password' => 'The provided email or password is incorrect.']);
        }
    
        $request->session()->put('name', $user->name);
        return redirect("weblist")->withSuccess('Login successful.');
    }
  

}
