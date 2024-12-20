<?php

namespace Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Tests\DatabaseTest;

class AuthTest extends DatabaseTest
{
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function test_that_user_is_authenticated(): void
    {
        // Given
        Sanctum::actingAs($this->getUser());

        // When
        $response = $this->json('GET', route('cards.index'));

        // Then
        $response->assertOk();
    }

    public function test_that_user_is_unauthenticated(): void
    {
        // Given

        // When
        $response = $this->json('GET', route('cards.index'));

        // Then
        $response->assertUnauthorized();
    }
}
