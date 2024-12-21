<?php

namespace Tests\Feature;

use App\Enums\MediaCollection;
use App\Models\NftCard;
use App\Notifications\NftCardCreated;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Tests\DatabaseTest;

class NftCardCrudTest extends DatabaseTest
{
    public function test_that_user_can_list_cards(): void
    {
        // Given
        Sanctum::actingAs($this->getUser());

        // When
        $response = $this->json('GET', route('cards.index'));

        // Then
        $response->assertJsonStructure([
            'data',
            'links',
            'meta',
        ]);
    }

    public function test_that_user_can_get_card(): void
    {
        // Given
        Sanctum::actingAs($this->getUser());

        $nftCard = $this->createTestCard();

        // When
        $response = $this->json('GET', route('cards.show', $nftCard));

        // Then
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'collection',
            ],
        ]);
    }

    public function test_that_user_can_create_card(): void
    {
        // Given
        Sanctum::actingAs($this->getUser());

        Notification::fake();

        $image = UploadedFile::fake()->image('koenigsegg_jesko_2019.jpg', 800, 600);

        // When
        $response = $this->json('POST', route('cards.store'), [
            'name' => 'Koenigsegg Jesko',
            'collection' => 'Koenigsegg 2019',
            'image' => $image,
        ]);

        // Then
        $response->assertOk();

        $this->assertNotEmpty(
            $this->getLastCard()->getMedia(MediaCollection::IMAGES->value)
        );

        Notification::assertSentTo($this->user, NftCardCreated::class, function ($notification, $channels) {
            return in_array('mail', $channels);
        });
    }

    public function test_that_user_can_update_card(): void
    {
        // Given
        Sanctum::actingAs($this->getUser());

        $nftCard = $this->createTestCard();

        $image = UploadedFile::fake()->image('el_diablo.jpg', 800, 600);

        // When
        $response = $this->json('PUT', route('cards.update', $nftCard), [
            'name' => 'Lamborghini Diablo',
            'collection' => 'Lamborghini Classics',
            'image' => $image,
        ]);

        $lastCard = $this->getLastCard();
        $lastCardMedia = $lastCard->getFirstMedia(MediaCollection::IMAGES->value);

        // Then
        $response->assertOk();

        $this->assertNotNull($lastCardMedia);
        $this->assertEquals('Lamborghini Diablo', $lastCard->name);
        $this->assertEquals('Lamborghini Classics', $lastCard->collection);
        $this->assertEquals('el_diablo.jpg', $lastCardMedia->file_name);
        $this->assertEquals('el_diablo', $lastCardMedia->name);
    }

    public function test_that_user_can_delete_card(): void
    {
        // Given
        Sanctum::actingAs($this->getUser());

        $nftCard = $this->createTestCard();

        // When
        $response = $this->json('DELETE', route('cards.update', $nftCard));

        // Then
        $response->assertOk();

        $this->assertNull($this->getLastCard());

        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'collection',
            ],
        ]);
    }

    private function getLastCard(): ?NftCard
    {
        return NftCard::query()->orderBy('id', 'desc')->limit(1)->first();
    }

    private function createTestCard(): NftCard
    {
        $image = UploadedFile::fake()->image('koenigsegg_jesko_2019.jpg', 800, 600);

        // When
        $nftCard = $this->getUser()->nftCards()->create([
            'name' => 'Koenigsegg Jesko',
            'collection' => 'Koenigsegg 2019',
        ]);

        $nftCard->addMedia($image)->toMediaCollection(MediaCollection::IMAGES->value);

        return $nftCard;
    }
}
