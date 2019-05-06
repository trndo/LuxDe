<?php

declare(strict_types=1);

/*
 * This file is part of the "LuxDe School" package.
 * (c) Gopkalo Vitaliy <trndogv@gmail.com>
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $uploadDir;

    public function __construct($uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    /**
     * @param UploadedFile $uploadedFile
     *
     * @throws FileException
     *
     * @return string
     */
    public function upload(UploadedFile $uploadedFile)
    {
        $originName = $this->hash($uploadedFile->getClientOriginalName());

        try {
            $uploadedFile->move(
                $this->uploadDir,
                $originName
            );
        } catch (FileException $exception) {
            return $exception->getMessage();
        }

        return $originName;
    }

    private function hash(string $imageName)
    {
        return \md5(\uniqid($imageName));
    }

    /**
     * @return mixed
     */
    public function getUploadDir()
    {
        return $this->uploadDir;
    }
}
