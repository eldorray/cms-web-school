<?php

namespace Tests\Feature\Admin;

use App\Models\Teacher;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TeacherControllerTest extends TestCase
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

    public function test_admin_can_view_teachers_index(): void
    {
        Teacher::factory()->count(5)->create(['school_id' => $this->school->id]);

        $response = $this->actingAs($this->admin)
            ->withSession(['school_id' => $this->school->id])
            ->get(route('admin.teachers.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_create_teacher(): void
    {
        $response = $this->actingAs($this->admin)
            ->withSession(['school_id' => $this->school->id])
            ->post(route('admin.teachers.store'), [
                'name' => 'Budi Santoso, S.Pd',
                'nip' => '198501012010011001',
                'position' => 'teacher',
                'subject' => 'Matematika',
                'is_active' => true,
            ]);

        $this->assertDatabaseHas('teachers', [
            'name' => 'Budi Santoso, S.Pd',
            'school_id' => $this->school->id,
        ]);
    }

    public function test_admin_can_update_teacher(): void
    {
        $teacher = Teacher::factory()->create(['school_id' => $this->school->id]);

        $response = $this->actingAs($this->admin)
            ->withSession(['school_id' => $this->school->id])
            ->put(route('admin.teachers.update', $teacher), [
                'name' => 'Updated Name',
                'position' => 'principal',
                'is_active' => true,
            ]);

        $this->assertDatabaseHas('teachers', [
            'id' => $teacher->id,
            'name' => 'Updated Name',
            'position' => 'principal',
        ]);
    }

    public function test_admin_can_delete_teacher(): void
    {
        $teacher = Teacher::factory()->create(['school_id' => $this->school->id]);

        $response = $this->actingAs($this->admin)
            ->withSession(['school_id' => $this->school->id])
            ->delete(route('admin.teachers.destroy', $teacher));

        $this->assertDatabaseMissing('teachers', ['id' => $teacher->id]);
    }
}
