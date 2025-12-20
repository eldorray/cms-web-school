<?php

namespace Tests\Feature\Frontend;

use App\Models\Post;
use App\Models\School;
use App\Models\Category;
use App\Models\Event;
use App\Models\Teacher;
use App\Models\Achievement;
use App\Models\Gallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected School $school;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->school = School::factory()->create([
            'is_active' => true,
            'domain' => 'localhost',
        ]);
        
        // Bind school for frontend routes
        app()->instance('currentSchool', $this->school);
    }

    public function test_homepage_displays_correctly(): void
    {
        Post::factory()->count(3)->create(['school_id' => $this->school->id, 'is_published' => true]);
        
        $response = $this->withSession(['school_id' => $this->school->id])
            ->get('/');

        $response->assertStatus(200);
    }

    public function test_posts_index_displays_published_posts(): void
    {
        $published = Post::factory()->create([
            'school_id' => $this->school->id, 
            'is_published' => true,
        ]);
        $draft = Post::factory()->create([
            'school_id' => $this->school->id, 
            'is_published' => false,
        ]);

        $response = $this->withSession(['school_id' => $this->school->id])
            ->get('/berita');

        $response->assertStatus(200);
        $response->assertSee($published->title);
        $response->assertDontSee($draft->title);
    }

    public function test_single_post_page_works(): void
    {
        $post = Post::factory()->create([
            'school_id' => $this->school->id,
            'is_published' => true,
        ]);

        $response = $this->withSession(['school_id' => $this->school->id])
            ->get('/berita/' . $post->slug);

        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    public function test_events_page_displays_correctly(): void
    {
        Event::factory()->create([
            'school_id' => $this->school->id,
            'start_date' => now()->addDays(5),
        ]);

        $response = $this->withSession(['school_id' => $this->school->id])
            ->get('/agenda');

        $response->assertStatus(200);
    }

    public function test_teachers_page_displays_correctly(): void
    {
        Teacher::factory()->count(3)->create([
            'school_id' => $this->school->id,
            'is_active' => true,
        ]);

        $response = $this->withSession(['school_id' => $this->school->id])
            ->get('/guru-staff');

        $response->assertStatus(200);
    }

    public function test_achievements_page_displays_correctly(): void
    {
        Achievement::factory()->count(3)->create([
            'school_id' => $this->school->id,
            'is_published' => true,
        ]);

        $response = $this->withSession(['school_id' => $this->school->id])
            ->get('/prestasi');

        $response->assertStatus(200);
    }

    public function test_galleries_page_displays_correctly(): void
    {
        Gallery::factory()->create([
            'school_id' => $this->school->id,
            'is_published' => true,
        ]);

        $response = $this->withSession(['school_id' => $this->school->id])
            ->get('/galeri');

        $response->assertStatus(200);
    }

    public function test_contact_page_displays_correctly(): void
    {
        $response = $this->withSession(['school_id' => $this->school->id])
            ->get('/kontak');

        $response->assertStatus(200);
    }

    public function test_ppdb_page_displays_correctly(): void
    {
        $response = $this->withSession(['school_id' => $this->school->id])
            ->get('/ppdb');

        $response->assertStatus(200);
    }
}
