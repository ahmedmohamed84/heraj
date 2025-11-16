<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application language.
     *
     * @param  string  $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch($code)
    {
        // Find the language by its code and ensure it is active
        $language = Language::where('code', $code)->where('is_active', true)->first();

        // If the language is valid, put it in the session
        if ($language) {
            Session::put('locale', $code);
        }
        // dd(session()->get('locale'), $code); // يجب أن يطبع الرمز الجديد (مثلاً ar)
        // Redirect back to the previous page
        return redirect()->back();
    }
}