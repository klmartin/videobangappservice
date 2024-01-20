<?php

namespace App\Helpers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class AFYACHAPDoctorMicroserviceAPIRequestHelper
{
    public static function createSpecialization($url, $requestID, $request){
        $fieldsValue = [
            [
                'name' => 'title',
                'contents' => $request->title,
            ],
            [
                'name' => 'description',
                'contents' => $request->description,
            ],
            [
                'name' => 'icon',
                'contents' => file_get_contents($request->file('icon')->getPathname()),
                'filename' => Carbon::now()->timestamp.'.'.$request->file('icon')->getClientOriginalExtension(),
                'headers' => [
                    'Content-Type' => 'multipart/form-data'
                ]
            ]
        ];
        $headers = [
            "afya-sign-auth" => $requestID
        ];

        $client = new Client();
        try {
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'multipart' => $fieldsValue
            ]);
            return $response->getBody()->getContents();
        }catch (ClientException $e){
            return $e->getResponse()->getBody()->getContents();
        }
    }
    static function getCurlDefaultRequest($url, $requestID, $fields){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS =>$fields,
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "afya-sign-auth: $requestID"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    static function postCurlDefaultRequest($url, $requestID, $fields){
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
            CURLOPT_POSTFIELDS =>$fields,
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "afya-sign-auth: $requestID"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}