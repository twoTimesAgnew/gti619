<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Setting;
use App\User;

class SecurityController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        $salts = User::pluck('salt');
        $hashVersions = User::pluck('hash_version');

        return view('security')->with(['settings' => $settings[0], 'salts' => $salts, 'hashes' => $hashVersions]);
    }

    public function update(Request $request)
    {
        $settings = Setting::find(1);
        $settings->{'pass_attempts'} = !empty($request->{'pass_attempts'}) ? $request->{'pass_attempts'} : 5;
        $settings->{'pass_attempts_delay'} = !empty($request->{'pass_attempts_delay'}) ? $request->{'pass_attempts_delay'} : 5;
        $settings->{'pass_max_length'} = !empty($request->{'pass_max_length'}) ? $request->{'pass_max_length'} : null;
        $settings->{'pass_numbers'} = isset($request->{'pass_numbers'}) ? true : false;
        $settings->{'pass_special'} = isset($request->{'pass_special'}) ? true : false;
        $settings->{'2fa'} = isset($request->{'2fa'}) ? true : false;
        $settings->save();

        Log::channel('security')->info("[" . $request->ip() . "] modified security settings");

        if($settings->{'2fa'} && User::where('username', session()->get('username'))->value('secret') == null)
        {
            return redirect('security/2fa')->with('message', 'It seems you have enabled 2FA but have not linked a Google Authenticator device yet.');
        }

        return back()->with('message', 'Successfully updated security settings');
    }

    public function password(Request $request)
    {
        $settings = Setting::find(1);
        $maxLen = $settings->{'pass_max_length'};
        $allowedNumbers = $settings->{'pass_numbers'};
        $allowedSpecial = $settings->{'pass_special'};

        if(!empty($maxLen) && strlen($request->password) > $maxLen)
        {
            return back()->with('passError', 'Password is too long');
        }

        if(!$allowedNumbers && 1 === preg_match('~[0-9]~', $request->password))
        {
            return back()->with('passError', 'Password contains numbers');
        }

        if(!$allowedSpecial && preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $request->password))
        {
            return back()->with('passError', 'Password contains special characters');
        }

        if($request->password !== $request->confirmPassword)
        {
            return back()->with('passError', 'Passwords do not match');
        }

        $user = User::find($request->id);
        $user->password = hash('sha256', $request->password.$user->salt);
        $user->save();

        Log::channel('security')->info("[" . $request->ip() . "] changed {$user->username} password");

        return back()->with('passMessage', 'Successfully changed password');
    }

    public function googleauth()
    {
        $secretFactory = new \Dolondro\GoogleAuthenticator\SecretFactory();
        $secret = $secretFactory->create("SoberSec", "Administrateur");
        $secretKey = $secret->getSecretKey();

        $user = User::find(1);
        $user->secret = $secretKey;
        $user->save();

        return view('googleauth')->with('key', $secretKey);
    }

    public function confirmOtp(Request $request)
    {
        $googleAuthenticator = new \Dolondro\GoogleAuthenticator\GoogleAuthenticator();

        if ($googleAuthenticator->authenticate(User::find(1)->value('secret'), $request->otp))
        {
            return redirect('security')->with('message', 'OTP code was valid');
        }
        else
        {
            return redirect('security')->with('error', 'OTP code was invalid');
        }
    }
}
