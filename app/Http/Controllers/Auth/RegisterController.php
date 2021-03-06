<?php

namespace App\Http\Controllers\Auth;

use App\Role;
use App\User;
use Throttle;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\ConfirmMail;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers {
        register as originalRegister;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', [
            'except' => [
                'emailConfirm',
                'resendConfirmMailPage',
                'resendConfirmMail',
            ],
        ]);

        $this->middleware('auth', [
            'only' => [
                'resendConfirmMailPage',
                'resendConfirmMail',
            ],
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * 重新包裝註冊方法，以寄送驗證信件
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // 呼叫原始註冊方法
        $result = $this->originalRegister($request);
        /* @var User $user */
        $user = auth()->user();
        // 紀錄註冊時間與IP
        $user->update([
            'register_at' => Carbon::now(),
            'register_ip' => $request->ip(),
        ]);
        // 賦予第一位註冊的人管理員權限
        if (User::count() == 1) {
            $admin = Role::where('name', '=', 'Admin')->first();
            $user->attachRole($admin);
        }
        // 發送驗證信件
        $this->generateConfirmCodeAndSendConfirmMail($user);

        // 回傳結果
        return $result->with('global', '註冊完成，請至信箱收取驗證信件。');
    }

    /**
     * 驗證信箱
     *
     * @param  \Illuminate\Http\Request $request
     * @param string $confirmCode
     * @return \Illuminate\Http\Response
     */
    public function emailConfirm(Request $request, $confirmCode)
    {
        //檢查驗證碼
        $user = User::where('confirm_code', $confirmCode)->whereNull('confirm_at')->first();
        if (!$user) {
            return redirect()->route('index')->with('warning', '驗證連結無效。');
        }
        //更新資料
        $user->update([
            'confirm_code' => null,
            'confirm_at'   => Carbon::now(),
        ]);

        return redirect()->route('index')->with('global', '信箱驗證完成。');
    }

    /**
     * 重送驗證信頁面
     *
     * @return \Illuminate\View\View
     */
    public function resendConfirmMailPage()
    {
        $user = auth()->user();
        if ($user->isConfirmed) {
            return redirect()->route('index');
        }

        return view('auth.resend-confirm-mail', compact('user'));
    }

    /**
     * 重送驗證信
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendConfirmMail(Request $request)
    {
        //檢查冷卻時間（每次須等待5分鐘）
        $throttler = Throttle::get($request, 1, 5);
        if (!$throttler->attempt()) {
            return redirect()->route('confirm-mail.resend')->with('warning', '信件請求過於頻繁，請等待5分鐘。');
        }
        $user = auth()->user();
        // 發送驗證信件
        $this->generateConfirmCodeAndSendConfirmMail($user);

        return redirect()->route('index')->with('global', '驗證信件已重新發送。');
    }

    /**
     * 產生驗證代碼並發送驗證信件
     *
     * @param User $user
     */
    public function generateConfirmCodeAndSendConfirmMail(User $user)
    {
        //產生驗證碼
        $confirmCode = str_random(60);
        //記錄驗證碼
        $user->update([
            'confirm_code' => $confirmCode,
        ]);
        //發送驗證郵件
        $user->notify(new ConfirmMail($user));
    }
}
