<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
protected $apiKey;


    public function __construct()
    {
        $this->apiKey = env('FIREBASE_API_KEY');
    }

    
    public function showAuthForm()
    {
        return view('auth');
    }

    
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $response = Http::post("https://identitytoolkit.googleapis.com/v1/accounts:signUp?key={$this->apiKey}", [
            'email' => $request->email,
            'password' => $request->password,
            'returnSecureToken' => true,
        ]);

        if ($response->successful()) {
            $data = $response->json();
        
            session(['firebase_user_id' => $data['localId'], 'firebase_token' => $data['idToken']]);
            return redirect('/')->with('success', 'تم إنشاء الحساب بنجاح!');
        }

        return redirect()->back()->withErrors(['error' => 'فشل إنشاء الحساب: ' . ($response->json()['error']['message'] ?? 'خطأ غير معروف')]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = Http::post("https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key={$this->apiKey}", [
            'email' => $request->email,
            'password' => $request->password,
            'returnSecureToken' => true,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            session(['firebase_user_id' => $data['localId'], 'firebase_token' => $data['idToken']]);
            return redirect('/')->with('success', 'مرحباً بك مجدداً!');
        }

        return redirect()->back()->withErrors(['error' => 'البريد الإلكتروني أو كلمة المرور خاطئة.']);
    }

    public function logout()
    {
        session()->forget(['firebase_user_id', 'firebase_token']);
        return redirect('/auth')->with('success', 'تم تسجيل الخروج.');
    }
}