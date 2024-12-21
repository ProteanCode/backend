<?php

namespace Database\Seeders;

use App\Enums\MediaCollection;
use App\Enums\NftCardStatus;
use App\Models\NftCard;
use App\Models\User;
use DB;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement('TRUNCATE TABLE nft_cards');
        DB::statement('TRUNCATE TABLE media');

        if (app()->runningUnitTests()) {
            return;
        }

        $cards = NftCard::query()->get();

        /** @var NftCard $card */
        foreach ($cards as $card) {
            $card->delete();
        }

        $users = User::all();

        /** @var User $user */
        foreach ($users as $user) {
            for ($i = 0; $i < 42; $i++) {

                /** @var NftCard $nftCard */
                $nftCard = $user->nftCards()->create([
                    'name' => 'Card no '.$i,
                    'collection' => 'Collection #'.($i % 10),
                    'status' => NftCardStatus::ACTIVE->value,
                ]);

                $width = [400, 500, 600, 700, 800, 900][rand(0, 5)];
                $height = [200, 400, 600, 800, 1000, 1200][rand(0, 5)];

                $nftCard
                    ->addMediaFromUrl('https://picsum.photos/'.$width.'/'.$height)
                    ->toMediaCollection(MediaCollection::IMAGES->value);
            }
        }
    }
}
