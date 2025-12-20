<?php

namespace Tests\Feature\SuperAdmin;

use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SchoolManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        
        $this->superAdmin = User::factory()->create();
        $this->superAdmin->assignRole('super-admin');
    }

    public function test_super_admin_can_view_dashboard(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->get('/super-admin');

        $response->assertStatus(200);
    }

    public function test_super_admin_can_view_schools_list(): void
    {
        School::factory()->count(5)->create();

        $response = $this->actingAs($this->superAdmin)
            ->get('/super-admin/schools');

        $response->assertStatus(200);
    }

    public function test_super_admin_can_create_school(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->post('/super-admin/schools', [
                'name' => 'SDN 1 Test',
                'domain' => 'sdn1test.localhost',
                'email' => 'sdn1test@example.com',
                'admin_name' => 'Admin Test',
                'admin_email' => 'admin@sdn1test.com',
                'admin_password' => 'password123',
            ]);

        $this->assertDatabaseHas('schools', [
            'name' => 'SDN 1 Test',
            'domain' => 'sdn1test.localhost',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'admin@sdn1test.com',
        ]);
    }

    public function test_super_admin_can_toggle_school_status(): void
    {
        $school = School::factory()->create(['is_active' => true]);

        $response = $this->actingAs($this->superAdmin)
            ->post("/super-admin/schools/{$school->id}/toggle-status");

        $school->refresh();
        $this->assertFalse($school->is_active);
    }

    public function test_super_admin_can_impersonate_school_admin(): void
    {
        $school = School::factory()->create(['is_active' => true]);
        $schoolAdmin = User::factory()->create(['school_id' => $school->id]);
        $schoolAdmin->assignRole('admin');

        $response = $this->actingAs($this->superAdmin)
            ->post("/super-admin/schools/{$school->id}/impersonate");

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_regular_user_cannot_access_super_admin(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/super-admin');

        $response->assertStatus(403);
    }
}
