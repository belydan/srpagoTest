<?php

namespace App\Jobs;

use App\CargaLayout;
use App\Contracts\IUploadLayoutCp;
use App\Sepomex\ReadLayoutSepomex;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadInformationDbJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $path;
    protected $carga_layout;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path, CargaLayout $carga_layout)
    {
        $this->path = $path;
        $this->carga_layout = $carga_layout;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->processLayout(new ReadLayoutSepomex($this->carga_layout));
    }

    /**
     * @param IUploadLayoutCp $process
     */
    private function processLayout(IUploadLayoutCp $process){
        $process->readLayout($this->path);
    }
}
