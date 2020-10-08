<?php


namespace App\Contracts;


interface IUploadLayoutCp
{
    /**
     * @param $file
     * @return mixed
     */
    public function readLayout($file);

    /**
     * @param array $information
     * @return mixed
     */
    public function saveInformation(array $information);
}
