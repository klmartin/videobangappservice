<?php

namespace App\Http\Controllers;

use App\Models\Video;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\CreateVideoForStreaming;
use App\Jobs\CreateThumbnailFromVideo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    //

    public function showVideosUploadStats(){

        $videoEncodingStats = $this->showVideosUploadStatsRequest();;

    }
    public function showVideosUploadStatsRequest(){



}


    public function upload(Request $request)
    {
        try {
            $request->validate([
                'video' => 'required|max:1048576',
            ]);

            $video = $request->file('video');
            
            $fileName = uniqid() . '.' . $video->getClientOriginalExtension();
            $filePath = 'videos-temp/' . $fileName;

            $body = $request->input('body');
            $userId = $request->input('userId');
            $pinned = $request->input('pinned');
            $type = $request->input('type');
    
            $this->storeVideo($video, $filePath);
    
            // Process video if needed
            // Example: Convert to different format, resize, etc.
            // Use Laravel FFmpeg library for processing
    
            $videoModel = $this->saveVideoDetails($filePath,$body,$userId,$pinned,$type);
    
            // Dispatch jobs
             CreateVideoForStreaming::dispatch($videoModel);
             CreateThumbnailFromVideo::dispatch($videoModel);
    
            return response()->json(['error'=>false,'data'=>$videoModel,'message'=>'The video has been successfully uploaded. Kindly await its processing to ensure it is prepared for streaming']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    private function storeVideo($video, $filePath)
    {
        try {
            $isFileUploaded = Storage::disk('videos-temp')->put($filePath, file_get_contents($video));
    
            if (!$isFileUploaded) {
                throw new \Exception('Failed to upload video');
            }
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Video upload failed: ' . $e->getMessage());
            // Rethrow the exception with a more specific message
            throw new \Exception('The video failed to upload.', 500);
        }
    }
    
    
    private function saveVideoDetails($filePath,$body,$userId,$pinned,$type)
    {
        $video = new Video();
        $video->uid = uniqid(true);
        $video->path = $filePath;
        $video->post_id = 12;
        $video->processed_file = false;
        $video->visibility = 'private';
        $video->allow_like = false;
        $video->allow_comment = false;
        $video->processing_percentage = 0;
        $video->body =  $body;
        $video->user_id =  $userId;
        $video->pinned =  $pinned;
        $video->type =  $type;
        $video->save();
        return $video;
    }


    public function getContentVideo(Request $request){
        $contentId = $request->input('contentId');
    
        // Assuming you have a model named 'Video' and a corresponding database table
        // Replace 'videos' with the actual table name if it's different
        $video = Video::find($contentId);
    
        if ($video) {
            $videoUrl ='https://video.bangapp.pro/video/'. $video->uid.'/'.$video->processed_file;
            return response()->json(['error'=>false,'data'=>array('video_url'=>$videoUrl)]);
        } else {
            // Handle the case where the video for the specified content ID is not found
            return response()->json(['error' => 'Video not found for the given content ID'], 404);
        }
    }

    public function getVideosProcessingStatus(){

        // Assuming you have a model named 'Video' and a corresponding database table
        // Replace 'videos' with the actual table name if it's different
        $videos = Video::where('processing_percentage', '<', 100)->get();

    
        if ($videos->count() > 0) {
            return response()->json(['error' => false, 'data' => $videos]);
        } else {
            // Handle the case where no videos with processing status 0 are found
            return response()->json(['error' => 'No videos with processing status 0 found'], 404);
        }
    }
    

    public function getVideoProcessingStatus(Request $request){

        $contentId = $request->input('contentId');
    
        // Assuming you have a model named 'Video' and a corresponding database table
        // Replace 'videos' with the actual table name if it's different
        $video = Video::find($contentId);
    
        if ($video) {
           
            return response()->json(['error'=>false,'data'=>$video]);
        } else {
            // Handle the case where the video for the specified content ID is not found
            return response()->json(['error' => 'Video not found for the given content ID'], 404);
        }

    }
    

    public function postVideo(Request $request){

        $client = new Client();
    }

    public function GetVideoEncodingStats(){
        $videos = Video::all()->toArray();
        return $videos;
    }
}
