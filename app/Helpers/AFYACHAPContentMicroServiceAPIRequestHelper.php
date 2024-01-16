<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AFYACHAPContentMicroServiceAPIRequestHelper
{
    public static function createAuthorMicroServicePostRequest($url, $requestID, $request)
    {
        if (empty($request->doctorID)) {
            $doctorID = 0;
        } else {
            $doctorID = $request->doctorID;
        }
        $fieldsValue = [
            [
                'name' => 'name',
                'contents' => $name = $request->first_name . " " . $request->middle_name . " " . $request->last_name,
            ],
            [
                'name' => 'title',
                'contents' => $request->title,
            ],
            [
                'name' => 'type',
                'contents' => $request->type,
            ],
            [
                'name' => 'is_doctor',
                'contents' => $request->isDoctor,
            ],
            [
                'name' => 'doctor_id',
                'contents' => $doctorID,
            ],
            [
                'name' => 'image',
                'contents' => file_get_contents($request->file('image')->getPathname()),
                'filename' => 'image.' . $request->file('image')->getClientOriginalExtension(),
                'headers' => [
                    'Content-Type' => 'multipart/form-data',
                ],
            ],
        ];
        $headers = [
            "afya-sign-auth" => $requestID,
        ];
        $client = new Client();
        try {
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'multipart' => $fieldsValue,
            ]);
            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            return $e->getResponse()->getBody()->getContents();
        }
    }
    public static function createAuthorAsDoctorFromAPIRequest($url, $requestID, $name, $imageUrl, $title, $type, $isDoctor, $doctorID)
    {
        $fieldsValue = [
            [
                'name' => 'name',
                'contents' => $name,
            ],
            [
                'name' => 'title',
                'contents' => $title,
            ],
            [
                'name' => 'type',
                'contents' => $type,
            ],
            [
                'name' => 'is_doctor',
                'contents' => $isDoctor,
            ],
            [
                'name' => 'doctor_id',
                'contents' => $doctorID,
            ],
            [
                'name' => 'image',
                'contents' => $imageUrl,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ],
        ];
        $headers = [
            "afya-sign-auth" => $requestID,
        ];
        $client = new Client();
        try {
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'multipart' => $fieldsValue,
            ]);
            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            return $e->getResponse()->getBody()->getContents();
        }
    }
    public static function changePublishStatusOfContent($url, $requestID, $contentID, $status)
    {
        $fields = json_encode([
            "content_id" => $contentID,
            "publish" => $status,
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
    public static function defaultGetSpecificDetailsRequest($url, $requestID, $id)
    {
        $fields = json_encode([
            "id" => $id,
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

    public static function defaultGetSpecificCatgeoryDetailsRequest($url, $requestID, $id)
    {
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
    public static function defaultGetSpecifiAuthorDetailsRequest($url, $requestID, $id)
    {

        // POST Data
        $keys = [
            'id' => 1,
        ];

        // Headers
        $headers = [
            'afya-sign-auth' => $requestID,
            'Content-Type' => 'application/json',
            //...
        ];

        $response = Http::withHeaders($headers)->post($url, $keys);
        $responseBody = $response->getBody();

        return $responseBody;
    }
    public static function defaultGetSpecificContentDetailsRequest($url, $requestID, $id)
    {

        $contentID = (int) $id;
        $fields = json_encode([
            "content_id" => $contentID,
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

    public static function changeContentSetting($url, $requestID, $settingID, $value)
    {
        $fields = json_encode([
            "id" => $settingID,
            "value" => $value,
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

    public static function defaultDeleteDetailByID($url, $requestID, $detailID)
    {
        $fields = json_encode([
            "id" => $detailID,
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
    public static function defaultDeleteDetailByCustomId($url, $requestID, $detailID)
    {
        $fields = json_encode([
            'categoryId' => $detailID,
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
    public static function defaultDeleteContentCover($url, $requestID, $detailID)
    {
        $fields = json_encode([
            'id' => $detailID,
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
    public static function deleteSubcategoryId($url, $requestID, $detailID)
    {
        $fields = json_encode([
            'SubcategoryId' => $detailID,
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
    public static function editAuthorDetails($url, $requestID, $id, $name, $title, $type, $isDoctor, $doctorID)
    {
        $fields = json_encode([
            "id" => $id,
            "name" => $name,
            "title" => $title,
            "type" => $type,
            "is_doctor" => $isDoctor,
            "doctor_id" => $doctorID,
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
    public static function updateAuthorImage($url, $requestID, $request)
    {
        $fieldsValue = [
            [
                'name' => 'id',
                'contents' => $request->id,
            ],
            [
                'name' => 'image',
                'contents' => file_get_contents($request->file('image')->getPathname()),
                'filename' => 'image.' . $request->file('image')->getClientOriginalExtension(),
                'headers' => [
                    'Content-Type' => 'multipart/form-data',
                ],
            ],
        ];
        $headers = [
            "afya-sign-auth" => $requestID,
        ];
        $client = new Client();
        try {
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'multipart' => $fieldsValue,
            ]);
            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            return $e->getResponse()->getBody()->getContents();
        }
    }
    public static function editBusinessCategoryDetails($url, $requestID, $id, $name)
    {
        $fields = json_encode([
            "id" => $id,
            "name" => $name,
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
    public static function createBusinessCategoryMicroServicePostRequest($url, $requestID, $request)
    {
        $fieldsValue = [
            [
                'name' => 'name',
                'contents' => $request->name,
            ],
            [
                'name' => 'added_by',
                'contents' => Auth::user()->id,
            ],
            [
                'name' => 'image',
                'contents' => file_get_contents($request->file('image')->getPathname()),
                'filename' => 'image.' . $request->file('image')->getClientOriginalExtension(),
                'headers' => [
                    'Content-Type' => 'multipart/form-data',
                ],
            ],
        ];
        $headers = [
            "afya-sign-auth" => $requestID,
        ];
        $client = new Client();
        try {
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'multipart' => $fieldsValue,
            ]);
            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            return $e->getResponse()->getBody()->getContents();
        }
    }
    public static function addDocumentMicroServicePostRequest($url, $requestID, $request)
    {
        $categoryID = (int) $request->categoryID;
        $title = $request->title;
        $contentID = $request->contentID;

        if ($categoryID == 3) {
            $fieldsValue = [
                [
                    'name' => 'content_id',
                    'contents' => $contentID,
                ],
                [
                    'name' => 'title',
                    'contents' => $title,
                ],
                [
                    'name' => 'document_category_id',
                    'contents' => $categoryID,
                ],
                [
                    'name' => 'added_by',
                    'contents' => Auth::user()->id,
                ],
                [
                    'name' => 'document',
                    'contents' => file_get_contents($request->file('contentDocumentValue')->getPathname()),
                    'filename' => 'document.' . $request->file('contentDocumentValue')->getClientOriginalExtension(),
                    'headers' => [
                        'Content-Type' => 'multipart/form-data',
                    ],
                ],
            ];
        } else {
            $contentDocumentValue = $request->contentDocumentValue;
            $fieldsValue = [
                [
                    'name' => 'content_id',
                    'contents' => $contentID,
                ],
                [
                    'name' => 'title',
                    'contents' => $title,
                ],
                [
                    'name' => 'document_category_id',
                    'contents' => $categoryID,
                ],
                [
                    'name' => 'added_by',
                    'contents' => Auth::user()->id,
                ],
                [
                    'name' => 'document',
                    'contents' => $contentDocumentValue,
                ],
                [
                    'name' => 'document_storage',
                    'contents' => "REMOTE",
                ],
            ];
        }

        $headers = [
            "afya-sign-auth" => $requestID,
        ];
        $client = new Client();
        try {
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'multipart' => $fieldsValue,
            ]);
            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            return $e->getResponse()->getBody()->getContents();
        }
    }
    public static function addPostCategoryMicroServicePostRequest($url, $requestID, $request)
    {

        $fieldsValue = [
            [
                'name' => 'name',
                'contents' => $request->name,
            ],
            [
                'name' => 'moderatorId',
                'contents' => 2,
            ],
            [
                'name' => 'image',
                'contents' => file_get_contents($request->file('image')->getPathname()),
                'filename' => 'image.' . $request->file('image')->getClientOriginalExtension(),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Content-Type' => 'multipart/form-data',
                ],
            ],
        ];
        $headers = [
            "afya-sign-auth" => $requestID,
        ];
        $client = new Client();
        try {
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'multipart' => $fieldsValue,
            ]);
            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            return $e->getResponse()->getBody()->getContents();
        }

    }
    public static function addPostSubCategoryMicroServicePostRequest($url, $requestID, $request)
    {
        $id = (int) $request->categoryId;
        $fieldsValue = [
            [
                'name' => 'name',
                'contents' => $request->name,
            ],
            [
                'name' => 'categoryId',
                'contents' => $id,
            ],
            [
                'name' => 'image',
                'contents' => file_get_contents($request->file('image')->getPathname()),
                'filename' => 'image.' . $request->file('image')->getClientOriginalExtension(),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Content-Type' => 'multipart/form-data',
                ],
            ],
        ];
        $headers = [
            "afya-sign-auth" => $requestID,
        ];
        $client = new Client();
        try {
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'multipart' => $fieldsValue,
            ]);
            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            return $e->getResponse()->getBody()->getContents();
        }

    }
    public static function editPostCategoryMicroServicePostRequest($url, $requestID, $request)
    {

        if (empty($request->file('image'))) {
            $fieldsValue = [
                [
                    'name' => 'name',
                    'contents' => $request->name,
                ],

                [
                    'name' => 'categoryId',
                    'contents' => $request->category_id,
                ],

            ];

        } else {
            $fieldsValue = [
                [
                    'name' => 'name',
                    'contents' => $request->name,
                ],

                [
                    'name' => 'categoryId',
                    'contents' => $request->category_id,
                ],
                [
                    'name' => 'image',
                    'contents' => file_get_contents($request->file('image')->getPathname()),
                    'filename' => 'image.' . $request->file('image')->getClientOriginalExtension(),
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Content-Type' => 'multipart/form-data',
                    ],
                ],
            ];

        }

        $headers = [
            "afya-sign-auth" => $requestID,
        ];
        $client = new Client();
        try {
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'multipart' => $fieldsValue,
            ]);
            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            return $e->getResponse()->getBody()->getContents();
        }

    }
    public static function editSubCategoryMicroServicePostRequest($url, $requestID, $request)
    {
        $id = (int) $request->categoryId;

        if (empty($request->file('category_icon'))) {
            $fieldsValue = [
                [
                    'name' => 'name',
                    'contents' => $request->category_name,
                ],

                [
                    'name' => 'SubcategoryId',
                    'contents' => $id,
                ],

            ];

        } else {
            $fieldsValue = [
                [
                    'name' => 'name',
                    'contents' => $request->category_name,
                ],

                [
                    'name' => 'SubcategoryId',
                    'contents' => $id,
                ],
                [
                    'name' => 'image',
                    'contents' => file_get_contents($request->file('category_icon')->getPathname()),
                    'filename' => 'image.' . $request->file('category_icon')->getClientOriginalExtension(),
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Content-Type' => 'multipart/form-data',
                    ],
                ],
            ];

        }

        $headers = [
            "afya-sign-auth" => $requestID,
        ];
        $client = new Client();
        try {
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'multipart' => $fieldsValue,
            ]);
            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            return $e->getResponse()->getBody()->getContents();
        }

    }
    public static function addContentMicroServicePostRequest($url, $requestID, $authorID, $title, $description, $body,$shortDescription, $hasDocument, $freePackage, $publishStatus, $businessCategoryID, $menuID, $addedBy)
    {
        $fields = json_encode([
            "category_id" => $businessCategoryID,
            "description" => $body,
            "short_description"=>$shortDescription,
            "is_in_free_package" => $freePackage,
            "is_published" => $publishStatus,
            "sub_category_id" => $menuID,
            "title" => $title,
            "author_id" => $authorID,
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
    public static function addContentCoverImageMicroServicePostRequest($url, $requestID, $request)
    {

       

    


        $fieldsValue = [
            [
                'name' => 'content_id',
                'contents' => $request->contentID,
            ],
            [
                'name' => 'added_by',
                'contents' => Auth::user()->id,
            ],
            [
                'name' => 'image',
                'contents' => file_get_contents($request->file('image')->getPathname()),
                'filename' => 'image.' . $request->file('image')->getClientOriginalExtension(),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Content-Type' => 'multipart/form-data',
                ],
            ],
        ];
        $headers = [
            "afya-sign-auth" => $requestID,
        ];
        $client = new Client();
        try {
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'multipart' => $fieldsValue,
            ]);
            return json_encode($response->getBody()->getContents());
        } catch (ClientException $e) {
            return $e->getResponse()->getBody()->getContents();
        }
    }
    public static function addContentThumbnailMicroServicePostRequest($url, $requestID, $request)
    {

       

    


        $fieldsValue = [
            [
                'name' => 'content_id',
                'contents' => $request->contentID,
            ],
            [
                'name' => 'added_by',
                'contents' => Auth::user()->id,
            ],
            [
                'name' => 'image',
                'contents' => file_get_contents($request->file('image')->getPathname()),
                'filename' => 'image.' . $request->file('image')->getClientOriginalExtension(),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Content-Type' => 'multipart/form-data',
                ],
            ],
        ];
        $headers = [
            "afya-sign-auth" => $requestID,
        ];
        $client = new Client();
        try {
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'multipart' => $fieldsValue,
            ]);
            return json_encode($response->getBody()->getContents());
        } catch (ClientException $e) {
            return $e->getResponse()->getBody()->getContents();
        }
    }


    public static function addVideoUrlMicroServicePostRequest($url, $requestID, $request, $video_url, $aspectRatio,$thumbnail_url,$filePath )
    {
   
         
        $content_id = (int) $request->contentID;
       // $video_url_id = (int) $request->id;
        $fields = json_encode([
            "original_video_url"=>$filePath,
            "content_id" => $content_id,
            "video_url" => $video_url,
            'thumbnail_url'=>$thumbnail_url,
            "added_by" => 1,
            "aspect_ratios" => $aspectRatio,

        ]);

      

        //for test server
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

        //for live server
        $curl2 = curl_init();
        curl_setopt_array($curl2, array(
            CURLOPT_URL => 'https://content.afyachap.com/api/v1/add/content/video/url',
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
        $response = curl_exec($curl2);
        curl_close($curl2);
        return json_encode($response);

    }
    public static function  addThumbnailMicroServicePostRequest($url, $requestID, $request,$thumbnail_url){
        $content_id = (int) $request->contentID;
        $video_url_id = (int) $request->id;
        $fields = json_encode([
//d
            "video_url_id "=> $video_url_id,
            "content_id" => $content_id,
            'thumbnail_url'=>$thumbnail_url,
            "added_by" => Auth::user()->id,
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
        return json_encode($response);



    }
    public static function editContentMicroServicePostRequest($url, $requestID, $contentID, $authorID, $title, $description, $body,$shortDescription, $hasDocument, $freePackage, $publishStatus, $businessCategoryID, $menuID, $addedBy)
    {
        $fields = json_encode([
            "id" => $contentID,
            "description" => $body,
            'short_description'=>$shortDescription,
            'category_id' => $businessCategoryID,
            "is_in_free_package" => $freePackage,
            "is_published" => $publishStatus,
            "sub_category_id" => $menuID,
            "title" => $title,
            "author_id" => $authorID,
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
    public static function getSpecificCoverImageDetailsRequest($url, $requestID, $id)
    {
        $fields = json_encode([
            "content_id" => (int) $id,
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
    public static function getSpecificContentLikesCountRequest($url, $requestID, $contentID)
    {
        $fields = json_encode([
            "content_id" => (int) $contentID,
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
    public static function deleteContentDetails($url, $requestID, $contentID)
    {
        $fields = json_encode([
            "content_id" => (int) $contentID,
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