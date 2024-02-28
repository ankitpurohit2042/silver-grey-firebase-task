<?php
use Illuminate\Support\Str;

if (!function_exists('formatDate')) {
    /**
     * @param $date
     * @param $format
     * @return false|string
     */
    function formatDate($date, $format = null)
    {
        return \Carbon\Carbon::parse($date)->format($format ?? config('general.date_format'));
    }
}

if (!function_exists('formatDatetime')) {
    /**
     * @param $date
     * @param $format
     * @return false|string
     */
    function formatDatetime($date, $format = null)
    {
        return \Carbon\Carbon::parse($date)->format($format ?? config('general.datetime_format'));
    }
}

if (!function_exists('setResponse')) {
    /**
     * Set the response
     * @param  string $data    [data]
     * @param  object $extra_meta       [extra_meta]
     * @return void
     */
    function setResponse($meta = null)
    {
        $response = [];
        $response['data'] = (object) null;
        $response['extra_meta'] = (object) $meta;
        return $response;
    }

}
if (!function_exists('setErrorResponse')) {
    /**
     * Set the error message and alert type of message
     * @param  string $message    [description]
     * @param  object $meta       [meta]
     * @return void
     */
    function setErrorResponse($message = '', $meta = null)
    {
        $response = [];
        $response['error']['message'] = $message;
        $response['error']['meta'] = (object) $meta;
        return $response;
    }

}

if (!function_exists('getCurrentUserDetails')) {
    /**
     * Set the error message and alert type of message
     * @param  string $message    [description]
     * @param  object $meta       [meta]
     * @return void
     */
    function getCurrentUserDetails($checkToken = false)
    {
        $bearerToken = request()->bearerToken();
        $auth = app('firebase.auth');
        $verifiedIdToken = $auth->verifyIdToken($bearerToken);

        if ($verifiedIdToken) {
            $uid = $verifiedIdToken->claims()->get('sub');
            $details = $auth->getUser($uid);
            $response = \App\Models\User::where('email', $details->email)->first();
            return $checkToken ? true : $response;
        }
    }

}
