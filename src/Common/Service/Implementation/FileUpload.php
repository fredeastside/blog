<?php

namespace App\Common\Service\Implementation;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Common\Service\FileUpload as FileUploadInterface;

class FileUpload implements FileUploadInterface
{
    private $uploadDirectory;

    public function __construct(string $uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }

    public function upload(UploadedFile $file): string
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->uploadDirectory, $fileName);

        return $fileName;
    }

    public function getFileByName(string $fileName): File
    {
        return new File($this->getFilePathByName($fileName));
    }

    public function remove(UploadedFile $file): bool
    {
        return unlink($file->getPathname());
    }

    public function removeByPath(string $path): bool
    {
        $path = $this->uploadDirectory . DIRECTORY_SEPARATOR . $path;

        if (file_exists($path)) {
            unlink($path);

            return true;
        }

        return false;
    }

    public function getFilePathByName(string $fileName): string
    {
        return $this->uploadDirectory.DIRECTORY_SEPARATOR.$fileName;
    }
}