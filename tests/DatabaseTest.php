<?php

namespace Tests;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Storage;

abstract class DatabaseTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    protected function tearDown(): void
    {
        $directory = 'testing';

        $files = Storage::disk('public')->allFiles($directory);

        Storage::disk('public')->delete($files);

        $directories = Storage::disk('public')->allDirectories($directory);

        foreach ($directories as $subDirectory) {
            Storage::disk('public')->deleteDirectory($subDirectory);
        }

        parent::tearDown();
    }
}
