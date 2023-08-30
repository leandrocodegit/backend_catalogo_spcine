<?php

namespace App\Imports;

use App\Models\Catalogo\Imagem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class ImportImagens implements ToCollection
{

    public function collection(Collection $rows)
    {

        foreach ($rows as $index => $row) {

            if ($index === 0)
                continue;
            if ($row[0] === 'INS' && $row[1] === 'INS') {

                $url = $this->copyAndSaveImage($row[10], $row[3]);

                $catalogo = Imagem::updateOrCreate([
                    'catalogo_id' => $row[3],
                    'principal' => $row[4] === 1 ? true : false,
                    'titulo' => $row[5],
                    'descricao' => $row[6],
                    'ordem' => $row[7],
                    'url' => $url,
                ]);
            }
        }
    }


    function copyAndSaveImage($url, $destinationPath)
    {
        $client = new Client();

        echo $url  ."\n";
        echo $destinationPath  ."\n";


        try {
            $response = $client->get($url);
            $contentType = $response->getHeaderLine('content-type');
            $extension = explode('/', $contentType)[1];
            $id = uniqid();
            $fileName = $id . '.' . $extension;

            echo 'imagens/' . $destinationPath . '/' . $fileName ."\n";
            Storage::disk('public')->put('imagens/' . $destinationPath . '/' . $fileName, $response->getBody());

            sleep(3);
            $this->convert('imagens/' . $destinationPath . '/' . $fileName, 'imagens/' . $destinationPath . '/' . $id . '.webp' );

            return  $destinationPath . '/' . $id . '.webp';
        } catch (\Exception $e) {
            echo $e . "\n";
            echo "Failed to copy imagem from url\n";
        }
    }

    function convert($inputImagePath, $outputImagePath)
    {
        echo $inputImagePath . "\n";
        echo  $outputImagePath . "\n";

        $image = imagecreatefromjpeg($inputImagePath);
        if ($image !== false) {
            if (Storage::disk('public')->exists($inputImagePath)) {
                exec("cwebp $inputImagePath -o $outputImagePath");
                Storage::disk('public')->delete($inputImagePath);
            } else {
                echo "Failed to convert image to WebP format.";
            }

            imagedestroy($image);
        } else {
            echo "Failed to load the input image.";
        }
    }

}
