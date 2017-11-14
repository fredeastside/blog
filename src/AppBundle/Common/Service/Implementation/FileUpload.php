<?php

namespace AppBundle\Common\Service\Implementation;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Common\Service\FileUpload as FileUploadInterface;

class FileUpload implements FileUploadInterface
{
    private $uploadDirectory;
    private $fileName;

    public function __construct(string $uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $this->fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->uploadDirectory, $this->fileName);
    }

    public function fileName()
    {
        return $this->fileName;
    }
}