<?php


namespace Masoud\Twofactorauth\http\twoFactorAuth;


use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Masoud\Twofactorauth\models\VerifyCode;
use Masoud\Twofactorauth\Notifications\VerifyCodeNotification;

class TwoFactorAuthController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('vendor.TwoFactorAuth.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function enable()
    {
        return view('vendor.TwoFactorAuth.enable');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function checkType(Request $request)
    {
        $data = $request->validate([
            'two_factor_type' => ['required', Rule::in(['off', 'sms', 'email'])],
            'phone_number' => 'nullable|string'
        ]);

        if (isset($data['phone_number']) && !empty($data['phone_number'])) {
            $request->session()->flash('phone', $data['phone_number']);
            return redirect(route('verify.code'));
        }

        auth()->user()->update([
            'two_factor_type' => $data['two_factor_type']
        ]);

        return redirect(route('security'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function indexVerifyCode(Request $request)
    {
        if (!$request->session()->has('phone'))
            return redirect(route(config('twoFactor.redirectRouteName')));

        $request->session()->reflash();

        $code = VerifyCode::getVerifyCode(auth()->user());

        //send code
        auth()->user()->notify(new VerifyCodeNotification($code , $request->session()->get('phone')));

        return view('vendor.TwoFactorAuth.verify-phone');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function checkVerifyCode(Request $request)
    {
        if (!$request->session()->has('phone'))
            return redirect(route(config('twoFactor.redirectRouteName')));

        $data = $request->validate([
            'code' => 'required'
        ]);

        $user = auth()->user();

        if (VerifyCode::checkVerifyCode($user, $data['code'])) {
            $user->update([
                'two_factor_type' => 'sms',
                'phone_number' => $request->session()->get('phone')
            ]);

            $user->verifyCodes()->delete();

            return redirect(route('security'));
        }

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(): \Illuminate\Http\RedirectResponse
    {
        auth()->user()->update([
            'two_factor_type' => 'off'
        ]);

        return back();
    }
}
