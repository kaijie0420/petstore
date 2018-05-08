<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use AuthHelper;
use DB;
use Config;
use Crypt;
use DateTime;
use DateTimeZone;
use GuzzleHttp\Client;
use Hash;
use Response;
use App\Classes\StatusResponse;
use Validator;

use App\User;

class AuthController extends Controller
{
    public function CheckEmailExists(Request $request)
    {
        $validator = Validator::make($request->all(), array
        (
            'email' => 'required|string|email',
        ));

        if(!$validator->passes())
        {
            $message = 'Validator fail';
            return StatusResponse::ApiCode4xx(412, $message);
        }

        $email = $request->email;

        $check_email_exists = AppBusinessUser::where('email', $email)->exists();
        // return var_dump($check_email_exists);


        if($check_email_exists === false)
        {
            $message = [

                'email_exists' => false,
            ];
        }
        elseif($check_email_exists === true)
        {
            $message = [

                'email_exists' => true,
            ];
        }

        return StatusResponse::ApiCode2xx(200, $message);
    }

    private function Authenticate($params)
    {
        $grant_type = 'password';
        $client_id = $params->client_id;
        $client_secret = $params->client_secret;
        $username = $params->username;
        $password = $params->password;

        $http = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8000',
            'defaults' => [
                'exceptions' => false
            ]
        ]);

        $response = $http->post('http://localhost:8000/oauth/token', [
            'form_params' => [
                'grant_type' => $grant_type,
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'username' => $username,
                'password' => $password,
                'scope' => '',
            ],
        ]);
return (1);
        return json_decode((string) $response->getBody(), true);
    }

    public function Register(Request $request)
    {
        $validator = Validator::make($request->all(), array
        (

            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email',
            'phone' => 'required|string',
            'password' => 'required|string|max:30',
            'address' => 'required|string',
            'country' => 'required|string',

            // Other info
            // 'app_version' => 'required|string',
            // 'client_id' => 'required|string|max:1',
            // 'client_secret' => 'required|string',


        ));

        if(!$validator->passes())
        {
            $message = 'Validator fail';
            return StatusResponse::ApiCode4xx(412, $validator->errors());
        }

        $email = $request->email;
        $check_email_exists = User::where('email', $email)->exists();

        if($check_email_exists === true)
        {
            $message = 'Email already exists. Please login instead.';
            return StatusResponse::ApiCode4xx(409, $message);
        }


        // user details
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $phone = $request->phone;
        $address = $request->address;
        $country = $request->country;
        $password = $request->password;
        $password_hash = Hash::make($password);

        $user_details = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $password_hash,
            'phone' => $phone,
            'address' => $address,
            'country' => $country,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        try
        {
            DB::transaction(function() use($user_details) {
                DB::table('users')->insert($user_details);
            });
        }catch(\Illuminate\Database\QueryException $e)
        {
            return StatusResponse::ApiCode4xx(400, $e);
        }

        return StatusResponse::ApiCode2xx(201);
    }


    public function Login(Request $request)
    {
        $validator = Validator::make($request->all(), array
        (
            'email' => 'required|string|email',
            'password' => 'required|string|max:30',

            // Other info
            // 'app_version' => 'required|string',
            'client_id' => 'required|string|max:1',
            'client_secret' => 'required|string',
        ));

        if(!$validator->passes())
        {
            $message = 'Validator fail';
            return StatusResponse::ApiCode4xx(412, $validator->errors());
        }

        $email = $request->email;
        $password = $request->password;

        $get_user_details = DB::table('users')
                              ->where('email', $email)
                              ->first();

        // Check password match
        $hashedPassword = $get_user_details->password;

        $hash_check = Hash::check($password, $hashedPassword);

        if($hash_check === false)
        {
            $message = 'Your password is incorrect';
            return StatusResponse::ApiCode4xx(400, $message);
        }


        // Preparing for OAuth
        // $app_version = $request->app_version;
        $client_id = $request->client_id;
        $client_secret = $request->client_secret;

        $params = new \stdClass;
        $params->client_id = $client_id;
        $params->client_secret = $client_secret;
        $params->username = $email;
        $params->password = $password;

        try
        {
            // Get token from Laravel Passport

            $token = $this->Authenticate($params);
            $get_user_details->access_token = $token['access_token'];

        }catch(\GuzzleHttp\Exception\ClientException $e)
        {
            $message = 'Authentication error';
            return StatusResponse::ApiCode4xx(400, $message);
        }

        // unset($get_user_details->password);
        // unset($get_user_details->user_type_id);
        // unset($get_user_details->revoked);

        // $message = [
        //     'access_token' => $token['access_token'],
        // ];

        return StatusResponse::ApiCode2xx(200, $get_user_details);
    }

    public function Logout()
    {
        $logout = Auth::user()->delete();
        return StatusResponse::ApiCode2xx(200);
    }

    public function ChangePassword(Request $request)
    {
        $validator = Validator::make($request->all(), array
        (
            'old_password' => 'required|string|max:40',
            'new_password' => 'required|string|max:40',
        ));

        if(!$validator->passes())
        {
            $message = 'Validator fail';
            return StatusResponse::ApiCode4xx(412, $message);
        }

        $user_jid = Auth::user()->user_jid;

        $old_password = $request->old_password;

        // Check password match
        $get_user_details = AppBusinessUser::select(['password'])->where('user_jid', $user_jid)->first();

        $hashedPassword = $get_user_details->password;
        $hash_check = Hash::check($old_password, $hashedPassword);

        if($hash_check === false)
        {
            $message = 'Your password is incorrect';
            return StatusResponse::ApiCode4xx(400, $message);
        }

        $new_password = $request->new_password;

        if($new_password === $old_password)
        {
            $message = 'New password cannot be same as old password';
            return StatusResponse::ApiCode4xx(409, $message);
        }

        $new_password_hash = [

            'password' => Hash::make($new_password),
            'updated_at' => now(),
        ];

        try
        {
            // Change ejabberd password
            $change_ejabberd_password = $this->ChangeEjabberdPassword($user_jid, $new_password);

            if($change_ejabberd_password == 1)
            {
                $message = 'XMPP error';
                return StatusResponse::ApiCode4xx(400, $message);
            }

        }catch(\GuzzleHttp\Exception\ClientException $e)
        {
            $message = 'XMPP error';
            return StatusResponse::ApiCode4xx(400, $message);
        }

        DB::transaction(function() use($user_jid, $new_password_hash) {

            DB::table('app_business_user')->where('user_jid', $user_jid)->update($new_password_hash);
            DB::table('app_business_iam_user')->where('user_jid', $user_jid)->update($new_password_hash);

        });

        return StatusResponse::ApiCode2xx(200);

    }

    public function RequestResetPasswordCode(Request $request)
    {
        $validator = Validator::make($request->all(), array
        (
            'email' => 'required|string|email',
            'phone_number' => ['nullable', 'regex:/\d+|null/'],
            'reset_type' => 'required|string|in:email,sms',
            'resend' => 'nullable|max:1'
        ));

        if(!$validator->passes())
        {
            $message = 'Validator fail';
            return StatusResponse::ApiCode4xx(412, $message);
        }

        $email = $request->email;
        $phone_number = $request->phone_number;
        $reset_type = $request->reset_type;
        $resend = $request->resend ?? 0;

        $select = [

            'user_jid',
            'phone_number',
        ];

        $get_user_details = DB::table('app_business_iam_user')->where('email', $email)->select($select)->first();

        if(empty($get_user_details))
        {
            $get_user_details = DB::table('app_business_user')->where('email', $email)->select($select)->first();

            if(empty($get_user_details))
            {
                $message = 'Account does not exist';
                return StatusResponse::ApiCode4xx(400, $message);
            }
        }

        $user_jid = $get_user_details->user_jid;
        $phone_number_db = $get_user_details->phone_number;

        $send_helper = new SendHelper;

        if($reset_type === 'sms')
        {
            if(empty($phone_number))
            {
                $message = 'Phone number field cannot be empty';
                return StatusResponse::ApiCode4xx(400, $message);
            }

            $find = strpos($phone_number_db, $phone_number);
            if($find === false)
            {
                $message = 'Phone number does not match';
                return StatusResponse::ApiCode4xx(400, $message);
            }
        }

        $reset_code = mt_rand(100000, 999999);

        $message = 'Your Soapp Business password reset code is <b>'.$reset_code.'</b>. Code will expire in 15 minutes.';

        if($reset_type === 'sms')
        {
            $send_sms = $send_helper->SendSMS($phone_number_db, $message, $resend);

            if($send_sms === false)
            {
                $message = 'Error sending SMS';
                return StatusResponse::ApiCode4xx(400, $message);
            }
        }
        elseif($reset_type === 'email')
        {
            $to = [$email];
            $from = 'no-reply@soappchat.com';
            $reply_to = [];
            $subject = 'Soapp Business - Password Reset Code';
            $html_body = $message;
            $charset = 'UTF-8';

            $send_email = $send_helper->SendEmail($to, $from, $reply_to, $subject, $html_body, $charset);

            if($send_email === false)
            {
                $message = 'Error sending email';
                return StatusResponse::ApiCode4xx(400, $message);
            }
        }

        do
        {
            $reset_token = strtolower(bin2hex(openssl_random_pseudo_bytes(32)));
            $retry = DB::table('password_reset')->where('reset_token', $reset_token)->exists();

        } while ($retry);

        $password_reset = [

            'reset_token' => $reset_token,
            'reset_code' => $reset_code,
            'user_jid' => $user_jid,
            'email' => $email,
            'nonce' => NULL,
            'created_at' => now(),
        ];

        DB::transaction(function() use($password_reset) {

            DB::table('password_reset')->where('created_at', '<', now()->subMinutes(15))->delete();
            DB::table('password_reset')->insert($password_reset);
        });

        $message = [

            'reset_token' => $reset_token,
        ];

        return StatusResponse::ApiCode2xx(200, $message);
    }

    public function VerifyResetPasswordCode(Request $request)
    {
        $validator = Validator::make($request->all(), array
        (
            'reset_token' => 'required|string',
            'reset_code' => 'required|string',
        ));

        if(!$validator->passes())
        {
            $message = 'Validator fail';
            return StatusResponse::ApiCode4xx(412, $message);
        }

        $reset_token = $request->reset_token;
        $reset_code = $request->reset_code;

        $get_token_details = DB::table('password_reset')
                            ->where('reset_token', $reset_token)
                            ->where('reset_code', $reset_code)
                            ->where('nonce', NULL)
                            ->where('created_at', '>', now()->subMinutes(15))
                            ->first();

        if(empty($get_token_details))
        {
            $message = 'Reset code is invalid or expired';
            return StatusResponse::ApiCode4xx(400, $message);
        }

        do
        {
            $nonce = strtolower(bin2hex(openssl_random_pseudo_bytes(32)));
            $retry = DB::table('password_reset')->where('nonce', $nonce)->exists();

        } while ($retry);

        $update = [

            'nonce' => $nonce,
            'created_at' => now(),
        ];

        DB::transaction(function() use($reset_token, $update) {

            DB::table('password_reset')->where('reset_token', $reset_token)->update($update);
        });

        $message = [

            'nonce' => $nonce,
        ];

        return StatusResponse::ApiCode2xx(200, $message);
    }

    public function ResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), array
        (
            'nonce' => 'required|string',
            'new_password' => 'required|string|max:30',
        ));

        if(!$validator->passes())
        {
            $message = 'Validator fail';
            return StatusResponse::ApiCode4xx(412, $message);
        }

        $nonce = $request->nonce;
        $new_password = $request->new_password;
        $password_hash = Hash::make($new_password);

        $select = [

            'user_jid',
            'email',
        ];

        $get_user_details = DB::table('password_reset')
                            ->where('nonce', $nonce)
                            ->where('created_at', '>', now()->subMinutes(15))
                            ->select($select)
                            ->first();

        if(empty($get_user_details))
        {
            $message = 'Nonce is invalid or expired';
            return StatusResponse::ApiCode4xx(400, $message);
        }

        $user_jid = $get_user_details->user_jid;
        $email = $get_user_details->email;

        try
        {
            // Change ejabberd password
            $change_ejabberd_password = $this->ChangeEjabberdPassword($user_jid, $new_password);

            if($change_ejabberd_password == 1)
            {
                $message = 'XMPP error';
                return StatusResponse::ApiCode4xx(400, $message);
            }

        }catch(\GuzzleHttp\Exception\ClientException $e)
        {
            $message = 'XMPP error';
            return StatusResponse::ApiCode4xx(400, $message);
        }

        $update_password = [

            'password' => $password_hash,
            'updated_at' => now(),
        ];

        DB::transaction(function() use($user_jid, $email, $update_password, $nonce) {

            DB::table('app_business_user')
            ->where('user_jid', $user_jid)
            ->where('email', $email)
            ->update($update_password);

            DB::table('app_business_iam_user')
            ->where('user_jid', $user_jid)
            ->where('email', $email)
            ->update($update_password);

            DB::table('password_reset')->where('email', $email)->where('nonce', $nonce)->delete();
        });

        return StatusResponse::ApiCode2xx(200);
    }
}
