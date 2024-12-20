<?php

namespace App\Classes\MediaLibrary;

use App\Models\NftCard;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\DefaultPathGenerator;

class CustomPathGenerator extends DefaultPathGenerator
{
    protected function getBasePath(Media $media): string
    {
        $uuid = $media->getAttribute('uuid');
        $path = app()->runningUnitTests() ? 'testing' : '';

        if ($media->model_type === NftCard::class) {
            $path .= '/nft/cards/';
        }

        return $path.$uuid;
    }
}
