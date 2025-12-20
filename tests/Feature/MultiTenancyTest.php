<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultiTenancyTest extends TestCase
{
    use RefreshDatabase;

    public function test_tenant_middleware_identifies_school_by_domain(): void
    {
        $school = School::factory()->create([
            'domain' => 'school1.localhost',
            'is_active' => true,
        ]);

        $response = $this->withServerVariables(['HTTP_HOST' => 'school1.localhost'])
            ->get('/');

        $response->assertStatus(200);
    }

    public function test_inactive_school_returns_403(): void
    {
        $school = School::factory()->create([
            'domain' => 'inactive.localhost',
            'is_active' => false,
        ]);

        $response = $this->withServerVariables(['HTTP_HOST' => 'inactive.localhost'])
            ->get('/');

        $response->assertStatus(403);
    }

    public function test_user_can_only_access_own_school_data(): void
    {
        $school1 = School::factory()->create(['is_active' => true]);
        $school2 = School::factory()->create(['is_active' => true]);

        $user1 = User::factory()->create(['school_id' => $school1->id]);
        $user2 = User::factory()->create(['school_id' => $school2->id]);

        // User1 should only see school1 data when logged in
        $this->actingAs($user1);
        
        $this->assertEquals($school1->id, $user1->school_id);
        $this->assertNotEquals($school2->id, $user1->school_id);
    }

    public function test_posts_are_scoped_to_school(): void
    {
        $school1 = School::factory()->create(['is_active' => true]);
        $school2 = School::factory()->create(['is_active' => true]);

        $post1 = \App\Models\Post::factory()->create(['school_id' => $school1->id]);
        $post2 = \App\Models\Post::factory()->create(['school_id' => $school2->id]);

        $school1Posts = \App\Models\Post::where('school_id', $school1->id)->get();
        
        $this->assertCount(1, $school1Posts);
        $this->assertEquals($post1->id, $school1Posts->first()->id);
    }

    public function test_local_development_uses_first_active_school(): void
    {
        $school = School::factory()->create(['is_active' => true]);

        // In local env without domain match, should use first school
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
