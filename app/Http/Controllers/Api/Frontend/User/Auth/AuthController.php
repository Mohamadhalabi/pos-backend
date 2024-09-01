<?php

namespace App\Http\Controllers\Api\Frontend\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Frontend\User\ForgetPasswordRequest;
use App\Http\Requests\Api\Frontend\User\UpdatePasswordRequest;
use App\Http\Requests\Api\User\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\User\Auth\FacebookLoginRequest;
use App\Http\Requests\Api\User\Auth\LoginRequest;
use App\Http\Requests\Api\User\Auth\RegisterRequest;
use App\Mail\WelcomeMail;
use App\Models\User;
use App\Traits\SetMailConfigurations;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Socialite;

class AuthController extends Controller
{
    use SetMailConfigurations;

    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string', // Use a single field for both email and phone
            'password' => 'required|string',
        ]);
    
        // Attempt to find the user by email or phone number
        $user = \App\Models\User::where('email', $request->identifier)
                    ->orWhere('phone', $request->identifier)
                    ->first();
    
        // If the user exists, check the password
        if ($user && auth()->attempt(['email' => $user->email, 'password' => $request->password])) {
            // If login is successful, create a token
            $token = $user->createToken('auth_token')->plainTextToken;
    
            // Include user information in the response
            return response()->json([
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'details' => $user->state,
                ]
            ]);
        }
    
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
      

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => 'string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
            'address' => 'required|string|min:5',
            'phone' => 'required|unique:users',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function forgot_password(ForgetPasswordRequest $request)
    {
        $token = Str::random(64);

        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );
        $this->setMailConfigurations();
        $mail = Mail::send('email.password', ['route' =>  get_setting('app_url').'auth/reset-password?token='.$token ], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password Notification');
        });
//        dd($mail);
        return response()->api_data(['message' => trans('passwords.sent')]);
    }

    public function reset_password(UpdatePasswordRequest $request)
    {
        $email = DB::table('password_resets')->where('token', $request->token)->first();
        $updatePassword = DB::table('password_resets')
            ->where(['email' => $email->email])
            ->first();

        if (!$updatePassword)
            return response()->api_error('error', 'Invalid token!');
        $user = User::query()->where('email', $email->email)->first();
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();
        DB::table('password_resets')->where(['email' => $user->email])->delete();

        return response()->api_data(['message' => trans('frontend.auth.password_changed')], 200);

    }


    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function login_with_facebook(FacebookLoginRequest $request)
    {

        $user = User::withTrashed()->
        where(function ($q) use ($request) {
            $q->where('facebook_id', $request->userID);
        });
        if (!empty($request->email)) {
            $user->orWhere('email', $request->email);
        }
        $user = $user->first();
        if (empty($user)) {
            $user = new User ();
        }
        if ($user->deleted_at != null)
            return response()->api_error(trans('frontend.auth.cannt_login'), 403);

        $user->facebook_id = $request->userID;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->facebook_id = $request->userID;
        $user->email_verified_at = Carbon::now();
        $user->avatar = $request->profile_picture;
        $user->provider_type = 'facebook';
        $user->save();
        $seller = $user->seller()->first();

        $user->refresh();

        $data = [
            "id" => $user->id,
            "uuid" => $user->uuid,
            "country_id" => $user->country_id,
            "city" => $user->city,
            "email" => $user->email,
            "name" => $user->name,
            "provider_type" => $user->provider_type,
            "facebook_id" => $user->facebook_id,
            "google_id" => $user->google_id,
            "avatar" => $user->provider_type == 'email' ? asset($user->avatar) : $user->avatar,
            "address" => $user->address,
            "state" => $user->state,
            "street" => $user->street,
            "company_name" => $user->company_name,
            "website_url" => $user->website_url,
            "type_of_business" => $user->type_of_business,
            "postal_code" => $user->postal_code,
            "balance" => $user->balance,
            "referral_code" => $user->referral_code,
            "status" => $user->status,

        ];
        if (!empty($seller)) {

            $seller->avatar = asset($seller->avatar);
            $data->seller = $seller;
        }
        \Auth::login($user);
        $token = \auth('api')->login($user);
        $user->auth_token = $token;
        $user->save();

        return response()->data(['user' => $data, 'register' => 'success', 'token' => $token]);
    }

    public function login_with_google(Request $request)
    {
        $user = User::withTrashed();
//        where(function ($q) use ($request) {
//            $q->where('google_id', $request->userID);
//        });
        $user->where('email', $request->email);
//        if (!empty($request->email)) {
//            $user->where('email', $request->email);
//        }
        $user = $user->first();
        if (empty($user)) {
            $user = new User ();
        }
        if ($user->deleted_at != null)
            return response()->api_error(trans('frontend.auth.cannt_login'), 403);

        $user->deleted_at = null;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->google_id = $request->userID;
        $user->avatar = $request->profile_picture;
        $user->email_verified_at = Carbon::now();
        $user->provider_type = 'google';

        $user->save();
        $seller = $user->seller()->first();

        $user->refresh();
        $data = [
            "id" => $user->id,
            "uuid" => $user->uuid,
            "email" => $user->email,
            "country_id" => $user->country_id,
            "city" => $user->city,
            "name" => $user->name,
            "provider_type" => $user->provider_type,
            "facebook_id" => $user->facebook_id,
            "google_id" => $user->google_id,
            "avatar" => (!empty($user->avatar) && !filter_var($user->avatar, FILTER_VALIDATE_URL)) ? asset($user->avatar) : $user->avatar,
            "address" => $user->address,
            "state" => $user->state,
            "street" => $user->street,
            "company_name" => $user->company_name,
            "website_url" => $user->website_url,
            "type_of_business" => $user->type_of_business,
            "postal_code" => $user->postal_code,
            "balance" => $user->balance,
            "referral_code" => $user->referral_code,
            "status" => $user->status,
        ];
        if (!empty($seller)) {

            $seller->avatar = asset($seller->avatar);
            $data->seller = $seller;
        }
        \Auth::login($user);
        $token = \auth('api')->login($user);
        $user->auth_token = $token;
        $user->save();
        return response()->data(['user' => $data, 'register' => 'success', 'token' => $token]);

    }

    public function change_password(ChangePasswordRequest $request)
    {
        $user = auth('api')->user();

        if ($request->old_password != null && Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);

            $user->save();

            return response()->api_data(['user' => $user, 'message' => trans('backend.global.success_message.updated_successfully')]);

        } elseif ($user->password == null) {
            $user->password = Hash::make($request->password);

            $user->save();

            return response()->api_data(['user' => $user, 'message' => trans('backend.global.success_message.updated_successfully')]);
        } else {
            return response()->error(['password' => trans('frontend.auth.the_password_is_incorrect')]);
        }
    }

    function verfiyMail(Request $request)
    {
        $token = $request->token;
        if (empty($token))
            return response()->error(trans('api.auth.user_not_found'));

        $user = User::where('verification_code', $token)->first();
        if (empty($user))
            return response()->error(trans('api.auth.user_not_found'));
        $user->email_verified_at = \Carbon\Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format'));
        $user->verification_code = null;
        $token = \auth('api')->login($user);
        $user->auth_token = $token;
        $user->save();
        $user->refresh();
        return response()->api_data(['message' => trans('api.auth.verify_mail'), 'token' => $user->auth_token, 'user' => $user]);

    }

    function testVerfiyMail(Request $request)
    {
        $user = User::find(170);
        $user->email_verified_at = \Carbon\Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format'));
        $user->verification_code = null;
        $token = \auth('api')->login($user);
        $user->auth_token = $token;
        $user->save();
        $user->refresh();
        return response()->api_data(['message' => trans('api.auth.verify_mail'), 'token' => $user->auth_token, 'user' => $user]);
    }

    function testVerfiyMailfail(Request $request)
    {
        return response()->error(trans('api.auth.user_not_found'));
    }

    public function profile_update(Request $request, $id)
    {
        try {
            // Retrieve the user by ID
            $user = User::findOrFail($id); // This will throw a 404 if the user is not found
    
            // Update user information from the request body
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
    
            // Only update password if it's provided
            if (!empty($request->input('password'))) {
                $user->password = Hash::make($request->input('password')); // Hash the password
            }
    
            // Save the updated user information
            $user->save();

            $user_info = User::where('id',$id)->first();

            return response()->json([
                'user' => [
                    'id' => $user_info->id,
                    'name' => $user_info->name,
                    'email' => $user_info->email,
                    'phone' => $user_info->phone, // Ensure phone exists in the User model
                    'address' => $user_info->address,
                ]
            ], 200);
        
        } catch (ModelNotFoundException $e) {
            // Return a 404 response if the user is not found
            return response()->json(['error' => 'User not found'], 404);
        } catch (ValidationException $e) {
            // Return validation errors
            return response()->json(['errors' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            // Return a generic error message for any other exceptions
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }    

}
