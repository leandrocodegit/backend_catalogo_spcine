<?php

namespace App\Models\util;

use App\Models\Catalogo\Imagem;
use Illuminate\Support\Facades\Storage;

class ImagemUtil
{
    public function __construct()
    {
    }

    public static function convert($imagem){

        $imagemDB = Imagem::find($imagem->id);

        echo "Id = ";
        echo $imagem->id;
        echo "\n";
        echo "Url = ";
        echo $imagemDB->url;
        echo "\n";
        echo "Url = ";
        echo $imagem->url;
        echo "\n";


        $id = uniqid();
        $inputImagePath = 'imagens/' . $imagemDB->url;
        $originalImagePath = $imagemDB->catalogo_id . '/' . $id . '.webp';
        $outputImagePath = 'imagens/' . $originalImagePath;

        echo Storage::disk('public')->exists('imagens/' . $imagemDB->url);
        echo "\n";
        echo $originalImagePath;
        echo "\n";


        try {
            if (Storage::disk('public')->exists('imagens/' . $imagemDB->url)) {
                exec("cwebp $inputImagePath -o $outputImagePath");
                echo ("cwebp $inputImagePath -o $outputImagePath");
                Storage::disk('public')->delete($inputImagePath);
                $imagemDB->update([
                    'url' => $originalImagePath
                ]);
                echo "\n";
                echo "Imagem convertida com sucesso!";
            }
        } catch (\Exception $err) {
            echo "Failed to copy imagem from url\n";
        }
    }

}
