<?php

namespace Tests\Feature\Admin;

use App\Models\Post;
use App\Models\School;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    protected School $school;
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->school = School::factory()->create(['is_active' => true]);
        
        Role::create(['name' => 'admin']);
        
        $this->admin = User::factory()->create([
            'school_id' => $this->school->id,
        ]);
        $this->admin->assignRole('admin');
    }

    public function test_admin_can_view_posts_index(): void
    {
        Post::factory()->count(3)->create(['school_id' => $this->school->id]);

        $response = $this->actingAs($this->admin)
            ->withSession(['school_id' => $this->school->id])
            ->get(route('admin.posts.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_create_post(): void
    {
        $category = Category::factory()->create(['school_id' => $this->school->id]);

        $response = $this->actingAs($this->admin)
            ->withSession(['school_id' => $this->school->id])
            ->post(route('admin.posts.store'), [
                'title' => 'Test Post',
                'slug' => 'test-post',
                'content' => 'This is test content',
                'category_id' => $category->id,
                'is_published' => true,
            ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'school_id' => $this->school->id,
        ]);
    }

    public function test_admin_can_update_post(): void
    {
        $post = Post::factory()->create(['school_id' => $this->school->id]);

        $response = $this->actingAs($this->admin)
            ->withSession(['school_id' => $this->school->id])
            ->put(route('admin.posts.update', $post), [
                'title' => 'Updated Title',
                'slug' => $post->slug,
                'content' => 'Updated content',
                'is_published' => true,
            ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_admin_can_delete_post(): void
    {
        $post = Post::factory()->create(['school_id' => $this->school->id]);

        $response = $this->actingAs($this->admin)
            ->withSession(['school_id' => $this->school->id])
            ->delete(route('admin.posts.destroy', $post));

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_admin_cannot_access_other_school_posts(): void
    {
        $otherSchool = School::factory()->create(['is_active' => true]);
        $otherPost = Post::factory()->create(['school_id' => $otherSchool->id]);

        $response = $this->actingAs($this->admin)
            ->withSession(['school_id' => $this->school->id])
            ->get(route('admin.posts.edit', $otherPost));

        $response->assertStatus(403);
    }
}
