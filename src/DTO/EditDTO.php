<?php


namespace App\DTO;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class EditDTO
{
    private $name;
    private $text;
    private $file;

    /**
     * @return mixed
     */
    public function getName():string
    {
        return $this->name;
    }


    /**
     * @param $name
     * @return EditDTO
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }


    /**
     * @param $text
     * @return EditDTO
     */
    public function setText($text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
     * @param $file
     * @return EditDTO
     */
    public function setFile(UploadedFile $file): self
    {
        $this->file = $file;

        return $this;
    }
}