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
                    'processing_percentage' => $percentage,
                ]);

            }) ->toDisk('videos')
            // call the 'save' method with a filename...
                ->save($this->video->uid . '/' . $this->video->uid . '.m3u8');
            $this->video->update([
                'processed_file' => $this->video->uid . '.m3u8',
            ]);

//             $low = (new X264('aac'))->setKiloBitrate(500);
//             $high = (new X264('aac'))->setKiloBitrate(1000);
//             FFMpeg::fromDisk('videos-temp')
//                 ->open($this->video->path)
//                 ->exportForHLS()->addFormat($low, function ($filters) {
//                 $filters->resize(640, 480);
//             })
//                 ->addFormat($low, function ($filters) {
//                     $filters->resize(1280, 720);

//                 })->onProgress(function ($percentage) {

//                 $this->video->update([
//                     'processing_percentage' => $percentage,
//                 ]);

//             })
// //temporary_segment_playlist_1.m3u8
// //temporary_segment_playlist_0.m3u8

//                 ->toDisk('videos')
//                 ->save($destination);
//             $this->video->update([
//                 'processed_file' => $this->video->uid . '.m3u8',
//             ]);

        } catch (EncodingException $exception) {
            $command = $exception->getCommand();
            $errorLog = $exception->getErrorOutput();
        }

    }
}