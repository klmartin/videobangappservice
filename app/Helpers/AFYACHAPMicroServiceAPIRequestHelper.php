<?php
/**

 */
namespace App\Helpers;

class AFYACHAPMicroServiceAPIRequestHelper
{
    public static function getMicroServiceRequestID($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    public static function defaultMicroServiceGetRequest($url, $requestID)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "afya-sign-auth: $requestID",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    public static function defaultGetRequestByCustomFieldSubCategory($url, $requestID, $request)
    {
        $id = (int) $request->id;
        $fields = json_encode([
            "category_id" => $id,
        ]);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "afya-sign-auth: $requestID",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;

    }
    public static function defaultMicroServicePostRequest($url, $requestID, $request)
    {
        $fields = json_encode($request);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '',
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "afya-sign-auth: $requestID",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    public static function defaultMicroServicePostRequestCategory($url, $requestID)
    {
        $fields = '';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => '',
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "afya-sign-auth:$requestID",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    public static function defaultGetSpecificMobileApplicationUserDetailsRequest($url, $requestID, $id)
    {
        $fields = json_encode([
            "user_id" => $id,
        ]);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "afya-sign-auth: $requestID",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    public static function getSpecificMobileApplicationUserSessions($url, $requestID, $id)
    {
        $fields = json_encode([
            "session_id" => "5670f24f-536e-11ed-990b-228e034c9015-rb91oAEggB",
        ]);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "afya-sign-auth: $requestID",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    public static function createDoctorMicroServicePostRequest($url, $requestID, $request)
    {
        $specializations = [];
        foreach ($request->specializations as $specialization) {
            array_push($specializations, ["specialization_id" => (int) $specialization]);
        }
        $fields = json_encode([
            "first_name" => $request->first_name,
            "middle_name" => $request->middle_name,
            "last_name" => $request->last_name,
            "phone_number" => $request->phone_number,
            "username" => $request->username,
            "email" => $request->email,
            "gender" => $request->gender,
            "password" => $request->phone_number,
            "date_of_birth" => $request->date_of_birth,
            "current_hospital" => $request->current_hospital,
            "specializations" => $specializations,
        ]);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "afya-sign-auth: $requestID",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public static function createServiceMicroServicePostRequest($url, $requestID, $request)
    {

        $fields = json_encode($request);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "afya-sign-auth: $requestID",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public static function saveSelectedUserStatusOption($url, $requestID, $userID, $status)
    {
        $fields = json_encode([
            "user_id" => $userID,
            "status" => $status,
        ]);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "afya-sign-auth: $requestID",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}