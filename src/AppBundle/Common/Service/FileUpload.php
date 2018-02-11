<?php

namespace AppBundle\Common\Service;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUpload
{
    public function upload(UploadedFile $file): string;

    public function getFileByName(string $fileName): File;

    public function remove(UploadedFile $file);

    public function removeByPath(string $path);
}