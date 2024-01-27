<?php

namespace App\Jobs;

use App\Models\Video;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Exporters\EncodingException;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class CreateVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $video;
    public $tries = 300;
    public $timeout = 5000000;

    public function __construct(Video $video)
    {
        //
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        try {
            $destination = '/' . $this->video->uid . '/' . $this->video->uid . 'm3u8';
            // create some video formats...
            $lowBitrateFormat = (new X264)->setKiloBitrate(500);
            $midBitrateFormat = (new X264)->setKiloBitrate(1500);
            $highBitrateFormat = (new X264)->setKiloBitrate(3000);
            // open the uploaded video from the right disk...
            FFMpeg::fromDisk('videos-temp')
                ->open($this->video->path)

            // call the 'exportForHLS' method and specify the disk to which we want to export...
                ->exportForHLS()->addFormat($lowBitrateFormat, function ($filters) {
                $filters->resize(640, 480);
            })
                ->addFormat($highBitrateFormat, function ($filters) {
                    $filters->resize(1280, 720);
                })->onProgress(function ($percentage) {
                $this->video->update([
                    'processing_percentage' => $percentage
                ]);
            
                info($percentage);
            }) ->toDisk('videos')
            // call the 'save' method with a filename...
                ->save($this->video->uid . '/' . $this->video->uid . '.m3u8');

            $videoUrl ='https://video.bangapp.pro/video'. $this->video->uid . '/' . $this->video->uid . '.m3u8';

            $this->sendVideotoMainServer($videoUrl, $this->video->body,$this->video->uid,$this->pinned,$this->video->type);
               
            $this->video->update([
                'processed_file' => $this->video->uid . '.m3u8',
            ]);



        } catch (EncodingException $exception) {
            $command = $exception->getCommand();
            $errorLog = $exception->getErrorOutput();
            info($command);
            info($errorLog);
        }

    }

    public function sendVideotoMainServer($imageUrl, $body, $userId, $pinned, $type)
    {
        $destinationServerURL = 'https://bangapp.pro/api/videoAddServer/';
         // cURL setup
        $ch = curl_init($destinationServerURL);

        // Set cURL options
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'path' => $imageUrl,
            'body' => $body,
            'user_id' => $userId,
            'pinned' => $pinned,
            'type' => $type,
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request
        $response = curl_exec($ch);

        // Get the HTTP response code
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Check for cURL errors and HTTP status
        if (curl_errno($ch)) {
            return ['status' => 'error', 'message' => 'cURL error: ' . curl_error($ch)];
        } elseif ($httpStatus >= 200 && $httpStatus < 300) {
            // Successful cURL request
            return ['status' => 'success', 'message' => 'Data sent successfully', 'http_status' => $httpStatus, 'api_response' => $response];
        } else {
            // Unsuccessful cURL request
            return ['status' => 'error', 'message' => 'Failed to send data', 'http_status' => $httpStatus, 'api_response' => $response];
        }

        // Close cURL session
        curl_close($ch);

    }
}