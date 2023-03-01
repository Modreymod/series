<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader
{
    //parametre optionnel (avec =) doivent etre passés a la fin
    public function upload(UploadedFile $file, string $directory, string $name = "")
    {
        //renommer photo uniid =nombre aleatoire  annotation + guess = recup extension
        $newFileName = $name . "-" . uniqid() . "." . $file->guessExtension();

        //copie du fichier dans le repertoire et le new name
        $file->move($directory, $newFileName);

        return $newFileName;

    }
}