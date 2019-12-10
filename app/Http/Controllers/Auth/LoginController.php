<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    private const REDIRECT_TO = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request): ?Response
    {
        $this->validateLogin($request);

        $credentials = [
            'username' => $request->post('username'),
            'password' => $request->post('password'),
        ];

        $user = Sentinel::authenticate($credentials);
        if ($user) {

            $request->session()->put('captcha', 0);
            return redirect()->intended(self::REDIRECT_TO);
        }

        $this->sendFailedLoginResponse();

        return null;
    }

    public function logout(Request $request): ?Response
    {
        Sentinel::logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    /**
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(): void
    {
        throw ValidationException::withMessages([
            'username' => [trans('auth.failed')],
        ]);
    }

    protected function validateLogin(Request $request): void
    {
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string',
        ];

        if ($request->session()->get('captcha')===1) {
            $rules = array_merge($rules, [
                recaptchaFieldName() => recaptchaRuleName(),
            ]);
        }

        $request->validate($rules);
    }
}
