<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function getCurrentUserData() {
        $user = Auth::user();
        return response()->json($user);
    }

    public function storeProfilePicture(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        $user = Auth::user();
        $user->avatar = $imageName;

        if (($request->name != '') && ($request->name != $user->fullName) && (Str::length($request->name)>2)) {
            $user->fullName = $request->name;
        }
        $user->save();
        // Return a response or redirect to a view
        $data = [
            'status' => 200,
            'data'   => $imageName
        ];

        return response($data);
    }

    public function storeProfileName(Request $request)
    {
        error_log($request->name);
        $user = Auth::user();

        if (($request->name != '') && ($request->name != $user->fullName) && (Str::length($request->name)>2)) {
            $user->fullName = $request->name;
            $user->save();
        } else {
            return response()->json([], 400);
        }

        return response()->json([], 200);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'oldPassword' => 'required|string',
            'newPassword' => 'required|string',
            'confirmedPassword' => 'required|string',
        ]);

        if (Auth::user()->getAuthPassword() == $request->input('oldPassword')) {

        }
    }

    public function getCurrentUserReferralData() {
        $user = Auth::user();

        $invitedUsers = User::where('invited_by', $user->id)->get();
        $parsedInvitedUsers = [];
        foreach ($invitedUsers as $invitedUser) {
            $currentUserInfo = (object)[];
            $currentUserInfo->nume = $invitedUser->fullName;
            $currentUserInfo->confirmat = (bool)$invitedUser->email_verified_at ? 'DA' : 'NU';
            array_push($parsedInvitedUsers, $currentUserInfo);
        }

        return response()->json([
            'refCode' => $user->referral,
            'invitedPeople' => $parsedInvitedUsers
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        error_log("TEST");
        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        $user->ability = [json_decode($user->ability, false)];
        $user->extras = ['eCommerceCartItemsCount' => 0];

        error_log("TEST");

        return response()->json([
            'status' => 'success',
            'userData' => $user,
            'accessToken' => $token,
            'refreshToken' => $token,
            ]);
    }

    function generateUniqueNumber() {
        $num1 = str_pad(rand(0, 9999), 4, "0", STR_PAD_LEFT);
        $num2 = str_pad(rand(0, 9999), 4, "0", STR_PAD_LEFT);
        $num3 = str_pad(rand(0, 9999), 4, "0", STR_PAD_LEFT);
        $num4 = str_pad(rand(0, 9999), 4, "0", STR_PAD_LEFT);

        return "$num1-$num2-$num3-$num4";
    }

    public function register(Request $request){
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $invited_by = null;

        try {
            $invited_by = User::where('referral', $request->input('referral'))->get()[0];
        } catch(Exception) {
            return response()->json([], 403);
        }

        $randomReferral = $this->generateUniqueNumber();
        $userReferral = User::where('referral', $randomReferral)->get();

        while (!$userReferral->isEmpty()) {
            $randomReferral = $this->generateUniqueNumber();
            $userReferral = User::where('referral', $randomReferral)->get();
        }

        $user = User::create([
            'fullName' => $request->input('fullName'),
            'username' => $request->input('username'),
            'avatar' => 'user.jpg',
            'role' => 'admin',
            'ability' => '{"action": "manage","subject": "all"}',
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'invited_by' => $invited_by->id,
            'referral' => $randomReferral
        ]);

        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        $user->ability = [json_decode($user->ability, false)];
        $user->extras = ['eCommerceCartItemsCount' => 0];
        try {
            $user->sendEmailVerificationNotification();
        } catch(Exception) {}

        return response()->json([
            'status' => 'success',
            'userData' => $user,
            'accessToken' => $token,
            'refreshToken' => $token,
        ]);

    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}
