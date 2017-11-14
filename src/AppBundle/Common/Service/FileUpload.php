<?php

namespace AppBundle\Common\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUpload
{
    public function upload(UploadedFile $file);

    public function fileName();
}