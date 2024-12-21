<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NftCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $result = [];

        $data = parent::toArray($request);

        $result['id'] = $data['id'];
        $result['name'] = $data['name'];
        $result['collection'] = $data['collection'];
        $result['media'] = (object)array_map(function (array $mediaItem) {
            $urls = [
                0 => $mediaItem['original_url']
            ];

            foreach ($mediaItem['responsive_images']['responsive']['urls'] as $url) {
                $matches = null;
                preg_match('/_(\d+)_\d+\.[a-zA-Z]+$/', $url, $matches);
                if (empty($matches)) {
                    continue;
                }

                $urls[$matches[1]] = url('/uploads/nft/cards/' . $mediaItem['uuid'] . '/responsive-images/' . $url);
            }

            return [
                'id' => $mediaItem['uuid'],
                'name' => $mediaItem['name'],
                'file_name' => $mediaItem['file_name'],
                'urls' => $urls
            ];
        }, $data['media']);

        return $result;
    }
}
