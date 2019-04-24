<?php


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
     * @return string
     * @throws FileException
     */
    public function upload(UploadedFile $uploadedFile)
    {
        $originName = $this->hash($uploadedFile->getClientOriginalName());

        try {
            $uploadedFile->move(
                $this->uploadDir,
                $originName
            );
        }catch(FileException $exception){

            return $exception->getMessage();
        }

        return $originName;

    }

    private function hash(string $imageName)
    {
        return md5(uniqid($imageName));
    }

    /**
     * @return mixed
     */
    public function getUploadDir()
    {
        return $this->uploadDir;
    }


}