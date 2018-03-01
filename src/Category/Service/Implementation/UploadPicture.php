<?php

declare(strict_types=1);

namespace App\Category\Service\Implementation;

use App\Category\Entity\Category;
use App\Common\Service\FileUpload;
use App\Category\Service\UploadPicture as UploadPictureInterface;
use Gumlet\ImageResize;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadPicture implements UploadPictureInterface
{
    private const PIC_WIDTH = 177;
    private const PIC_HEIGHT = 298;

    private $fileUpload;

    public function __construct(FileUpload $fileUpload)
    {
        $this->fileUpload = $fileUpload;
    }

    /**
     * @param UploadedFile $file
     *
     * @return string
     * @throws \Gumlet\ImageResizeException
     */
    public function upload(UploadedFile $file): string
    {
        $fileName = $this->fileUpload->upload($file);
        $filePath = $this->fileUpload->getFilePathByName($fileName);
        $image = new ImageResize($filePath);
        $image->resize(self::PIC_WIDTH, self::PIC_HEIGHT);
        $image->save($filePath);

        return $fileName;
    }

    public function remove(Category $category)
    {
        $this->fileUpload->removeByPath($category->picture());
    }

    public function getPictureFile(Category $category): File
    {
        return $this->fileUpload->getFileByName($category->picture());
    }
}