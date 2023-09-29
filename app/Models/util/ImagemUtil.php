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

        $imagemDB = Imagem::firstWhere('id', $imagem->id);

        $inputImagePath = 'imagens/' . $imagemDB->url;
        $originalImagePath = $imagemDB->catalogo_id . '/' . uniqid() . '.webp';
        $outputImagePath = 'imagens/' . $originalImagePath;

        try {
            if (Storage::disk('public')->exists('imagens/' . $imagem->url)) {
                exec("cwebp $inputImagePath -o $outputImagePath");
                Storage::disk('public')->delete($inputImagePath);
                $imagemDB->update([
                    'url' => $originalImagePath
                ]);
            }
        } catch (\Exception $err) {
        }
    }

}