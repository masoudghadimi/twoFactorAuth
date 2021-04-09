<?php


namespace Masoud\Twofactorauth\http\twoFactorAuth;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Masoud\Twofactorauth\models\VerifyCode;

class VerifyCodesController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show(Request $request)
    {
        if (! $request->session()->has('auth'))
            return redirect(route('login'));

        $request->session()->reflash();

        return view('vendor.TwoFactorAuth.auth.show');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function check(Request $request)
    {
        if (! $request->session()->has('auth'))
            return redirect(route(config('twoFactor.redirectRouteName')));

        $data = $request->validate([
            'code' => 'required'
        ]);

        $user = User::find($request->session()->get('auth.user_id'));

        if (VerifyCode::checkVerifyCode($user , $data['code'])) {

            if (auth()->loginUsingId($user->id , $request->session()->get('auth.remember'))) {
                $user->verifyCodes()->delete();

                return redirect(RouteServiceProvider::HOME);
            }

        }

        return redirect(route(config('twoFactor.redirectRouteName')));
    }
}
