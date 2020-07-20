<?php


namespace App\Http\Services\web\Auth;


use App\Http\Repository\UserRepository;
use App\Http\Services\BaseService;
use Illuminate\Support\Facades\Auth;

class VerificationService extends BaseService {
    /**
     * @var
     */
    protected $userRepository;

    /**
     * VerificationService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * @param object $request
     * @return array
     */
    public function verifyEmailProcess (object $request) {
        $updateStatusResponse = $this->userRepository->updateWhere([
            'id' => Auth::user()->id,
            'email_verification_code' => $request->email_verification_code,
            'status' => PENDING_STATUS
        ],[
            'email_verification_code' => null,'status' => ACTIVE_STATUS
        ]);

        return !$updateStatusResponse ?  $this->jsonResponse()->error('Invalid verification code.'):
            $this->jsonResponse()->success('Your Email is Verified');
    }

}