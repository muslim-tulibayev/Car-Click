<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImageFilePath extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:file_path';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Image update file_path';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $models = Image::get();
        if($models->isEmpty()){
            return $this->info("Image model is empty");
        }
        foreach ($models as $model){
            $response = json_decode(Http::get("https://api.telegram.org/bot". env("TELEGRAM_BOT_TOKEN_USER") ."/getFile?file_id={$model->file_id}")->body());
            if($response->ok){
                $model->file_path = $response->result->file_path;
                $model->update();
            }
            else{
                $this->info($response->error_code . " " . $response->description);
                continue;
            }
        }
        return $this->info("Successfully");
    }
}
