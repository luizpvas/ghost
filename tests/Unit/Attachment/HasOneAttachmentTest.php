<?php

namespace Tests\Unit\Attachment;

use App\Models\Attachment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HasOneAttachmentTest extends TestCase
{
    use RefreshDatabase;

    function test_starts_with_nothing_attached()
    {
        // Given we just created a new record
        $user = User::factory()->create();

        // Then it shouldn't have any attachments
        $this->assertFalse($user->avatar->attached());
    }

    function test_attaches_a_file_from_uploaded_file()
    {
        // Setup
        Storage::fake();
        $this->assertEquals(Attachment::count(), 0);

        // Given we have a record with no attachments
        $user = User::factory()->create();

        // When we attach a file to the record
        $user->avatar->attach(UploadedFile::fake()->image('avatar.png'));

        // Then an attachment record should be created
        $this->assertEquals(1, Attachment::count());

        // ... and a file should be stored on disk.
        $this->assertEquals(1, count(Storage::files('attachments')));

        // ... and the record should have an attachment
        $this->assertTrue($user->avatar->attached());
    }

    function test_delets_previous_attachment_when_updating()
    {
        // Setup
        Storage::fake();

        // Given we have a record with an attached file
        $user = User::factory()->create();
        $user->avatar->attach(UploadedFile::fake()->image('avatar.png'));

        // When we update with a new attachment
        $user->avatar->attach(UploadedFile::fake()->image('avatar.png'));

        // Then no additional records should be created in the database.
        $this->assertEquals(1, Attachment::count());

        // ... and no additional files should exist on disk (previous one was deleted)
        $this->assertEquals(1, count(Storage::files('attachments')));
    }

    function test_deletes_the_attachment()
    {
        // Setup
        Storage::fake();

        // Given we have a record with an attached file
        $user = User::factory()->create();
        $user->avatar->attach(UploadedFile::fake()->image('avatar.png'));

        // When we delete the attachment
        $user->avatar->purge();

        // Then the attachment record should be deleted
        $this->assertFalse($user->avatar->attached());
        $this->assertEquals(0, Attachment::count());

        // ... and the file on disk should be deleted
        $this->assertEquals(0, count(Storage::files('attachments')));
    }
}
