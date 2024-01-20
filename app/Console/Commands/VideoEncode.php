<?php

namespace App\Console\Commands;

use FFMpeg\Format\Video\X264;
use Illuminate\Console\Command;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class VideoEncode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video-encode:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // create some video formats...
        $lowBitrateFormat = (new X264)->setKiloBitrate(500);
        $midBitrateFormat = (new X264)->setKiloBitrate(1500);
        $highBitrateFormat = (new X264)->setKiloBitrate(3000);

// open the uploaded video from the right disk...
        FFMpeg::fromDisk('videos-temp')
            ->open('otile.mp4')

// call the 'exportForHLS' method and specify the disk to which we want to export...
            ->exportForHLS()->addFormat($lowBitrateFormat, function ($filters) {
            $filters->resize(640, 480);

        })
            ->addFormat($highBitrateFormat, function ($filters) {
                $filters->resize(1280, 720);

            })->onProgress(function ($percentage) {

            $this->info("Progress=${percentage}%");

        })
            ->toDisk('videos')
// call the 'save' method with a filename...
            ->save('test/' . 'test.m3u8');

// update the database so we know the convertion is done!
        // $this->video->update([
        //     'converted_for_streaming_at' => Carbon::now(),
        // ]);

        //ll
        // try {
        //     $low = (new X264('aac'))->setKiloBitrate(500);
        //     $high = (new X264('aac'))->setKiloBitrate(1000);
        //     FFMpeg::fromDisk('videos-temp')
        //         ->open('otile.mp4')
        //         ->exportForHLS()->addFormat($low, function ($filters) {
        //         $filters->resize(640, 480);

        //     })
        //         ->addFormat($low, function ($filters) {
        //             $filters->resize(1280, 720);

        //         })->onProgress(function ($percentage) {

        //         $this->info("Progress=${percentage}%");

        //     })

        //         ->toDisk('videos-temp')->save('test/file.m3u8');
        // } catch (EncodingException $exception) {
        //     $command = $exception->getCommand();
        //     $errorLog = $exception->getErrorOutput();

        //     echo $errorLog;

        // }

    }
}