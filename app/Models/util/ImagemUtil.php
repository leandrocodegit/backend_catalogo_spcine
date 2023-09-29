<?php

namespace App\Models\util;

use App\Models\Catalogo\Imagem;
use Illuminate\Support\Facades\Storage;

class ImagemUtil
{

    public function __construct()
    {
    }

    public static function convert($imagem)

    {

        $output = new \Symfony\Component\Console\Output\ConsoleOutput();


        $imagemDB = Imagem::firstWhere('id', $imagem->id);

        $inputImagePath = 'imagens/' . $imagemDB->url;
        $originalImagePath = $imagemDB->catalogo_id . '/' . uniqid() . '.webp';
        $outputImagePath = 'imagens/' . $originalImagePath;

        $output->write('$outputImagePath = ' . 'imagens/' . $originalImagePath);
        $output->write('              ');

        $output->write('$imagemDB->url = ' . 'imagens/' . $imagemDB->url);

       // sleep(2);

        if (Storage::disk('public')->exists('imagens/' . $imagem->url)) {
            exec("cwebp $inputImagePath -o $outputImagePath");
            Storage::disk('public')->delete($inputImagePath);
            $imagemDB->update([
                'url' => $originalImagePath
            ]);
        } else {
            echo "Failed to convert image to WebP format.";
        }
    }

}
