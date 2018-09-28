<?php

namespace Spatie\MediaLibrary\ImageGenerators\FileTypes;

use Imagick;
use ImagickPixel;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\Conversion\Conversion;
use Spatie\MediaLibrary\ImageGenerators\BaseGenerator;

class Psd extends BaseGenerator
{
    public function convert(string $file, Conversion $conversion = null): string
    {
        return $file;

//        $imageFile = pathinfo($file, PATHINFO_DIRNAME).'/'.pathinfo($file, PATHINFO_FILENAME).'.jpg';
//
//        $image = new Imagick();
//        $image->readImage($file);
////        $image->setImageIndex(0);
////        $image->setIteratorIndex(0);
//        $image->stripImage(); //去除图片信息
////        $image->setImageCompressionQuality(80); //图片质量
////        $image->setBackgroundColor(new ImagickPixel('none'));
//        $image->setImageFormat('jpg');
//
//        $image->writeImages($imageFile);
//      dd($imageFile);
//
//        return $imageFile;
    }

    public function requirementsAreInstalled(): bool
    {
        return class_exists('Imagick');
    }

    public function supportedExtensions(): Collection
    {
        return collect('psd');
    }

    public function supportedMimeTypes(): Collection
    {
        return collect('image/vnd.adobe.photoshop');
    }
}
