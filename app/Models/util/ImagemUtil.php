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

        $id = uniqid();
        $inputImagePath = 'imagens/' . $imagemDB->url;
        $originalImagePath = $imagemDB->catalogo_id . '/' . $id . '.webp';
        $outputImagePath = 'imagens/' . $originalImagePath;

        try {
            if (Storage::disk('public')->exists('imagens/' . $imagemDB->url)) {
                exec("cwebp $inputImagePath -o $outputImagePath");
                Storage::disk('public')->delete($inputImagePath);
                $imagemDB->update([
                    'url' => $originalImagePath
                ]);
            }
        } catch (\Exception $err) {
        }
    }

    public static function criarCapa($imagem){

        echo $imagem->url;
        $imagemDB = Imagem::find($imagem->id);

        $inputImagePath = 'imagens/' . $imagemDB->url;
        $originalImagePath = 'imagens/' . $imagemDB->catalogo_id;

        try {
            if (Storage::disk('public')->exists('imagens/' . $imagemDB->url)) {
                echo "\n";
                exec("cwebp $inputImagePath -o $originalImagePath/capa.ppm");
                echo "cwebp $inputImagePath -o $originalImagePath/capa.ppm";
                echo "\n";
                echo "convert $originalImagePath/capa.ppm -resize 500X350 $originalImagePath/capa.ppm";
                exec("convert $originalImagePath/capa.ppm -resize 500X350 $originalImagePath/capa.ppm");
                echo "\n";
                echo "cwebp $originalImagePath/capa.ppm -o $originalImagePath/capa.webp";
                exec("cwebp $originalImagePath/capa.ppm -o $originalImagePath/capa.webp");
                echo "\n";
            }
        } catch (\Exception $err) {
        }
    }

}
