<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Services\AuthService;
use App\Http\Services\ForgotPasswordService;
use App\Http\Services\LoginService;
use App\Http\Services\RegisterService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Exception;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    protected  $authService;
    protected  $registerService;
    protected $errorResponse;
    protected $errorMessage;
    protected $loginService;
    protected $forgotPasswordService;

    /**
     * AuthController constructor.
     * @param AuthService $authService
     * @param RegisterService $registerService
     * @param LoginService $loginService
     * @param ForgotPasswordService $forgotPasswordService
     */
    public function __construct(AuthService $authService,
                                RegisterService $registerService,
                                LoginService $loginService,
                                ForgotPasswordService $forgotPasswordService) {
        $this->authService = $authService;
        $this->registerService = $registerService;
        $this->loginService = $loginService;
        $this->forgotPasswordService = $forgotPasswordService;
        $this->errorMessage = __('Something went wrong');
        $this->errorResponse = [
            'success' => false,
            'data' => [],
            'message' => $this->errorMessage,
            'webResponse' => [
                'dismiss' => $this->errorMessage
            ]
        ];
    }

    public function index()
    {
        $user = Auth::user();
        if (!empty($user) && $user->role == ADMIN_ROLE) {

            return redirect()->route('admin.dashboard');
        } elseif (!empty($user) && $user->role == USER_ROLE) {

            return redirect()->route('user.dashboard');
        } else {
            return redirect()->route('signIn');
        }
    }

    public function adminIndex() {
        dd('admin');
        return view('admin.admin.dashboard');
    }
    public function userIndex() {
        dd('user');
        return view('home');
    }

    /**
     * @return Application|Factory|View
     */
    public function signIn() {

        return view('auth.login');
    }

    /**
     * @return Application|Factory|View
     */
    public function signUp() {

        return view('auth.register');
    }

    /**
     * @param SignUpRequest $request
     * @return RedirectResponse
     */
    public function signUpProcess(SignUpRequest $request) {
        $response = $this->registerService->signUp($request);

        return !$response['success'] ?  redirect()->back()->with(['error' => $response['message']]) :
            redirect()->route('home')->with(['success' => $response['message']]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function signInProcess(Request $request) {
        $response = $this->loginService->signInProcess($request);

        return !$response ? redirect()->route('')->with($this->errorResponse()) :
            redirect()->route($response["data"])->with($this->successResponse
            ($response["message"]));


    }

    /**
     * @return Application|Factory|View
     */
    public function forgetPasswordView() {

        return view('auth.forget_password_email');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function forgetPasswordEmailSendProcess(Request $request) {
        $response = $this->forgotPasswordService->sendForgetPasswordEmail($request);
        dd($response);

        return !$response['success'] ?  redirect()->back()->with(['error' => $response['message']]) :
            redirect()->route('resetPasswordView')->with(['success' => $response['message']]);

    }

    /**
     * @return Application|Factory|View
     */
    public function resetPasswordView() {

        return view('auth.reset_password');
    }

    /**
     * @param ForgetPasswordRequest $request
     * @return RedirectResponse
     */
    public function resetPassword(ForgetPasswordRequest $request) {
        $response = $this->authService->resetPasswordProcess($request);

        return !$response['success'] ?  redirect()->back()->with(['error' => $response['message']]) :
            redirect()->route('login')->with(['success' => $response['message']]);


    }

    /**
     * @param PasswordChangeRequest $request
     * @return RedirectResponse
     */
    public function passwordChangeProcess(PasswordChangeRequest $request) {
        $response = $this->authService->changePassword($request);

        return !$response['success'] ? redirect()->back()->with(['error' => $response['message']]) :
            redirect()->back()->with(['success' => $response['message']]);

    }
}
