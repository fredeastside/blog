<?php

declare(strict_types=1);

namespace App\Category\Service;

use App\Category\Entity\Category;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploadPicture
{
    public function upload(UploadedFile $file): string;

    public function remove(Category $category);

    public function getPictureFile(Category $category): File;
}