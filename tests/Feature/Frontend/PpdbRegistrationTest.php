<?php

namespace Tests\Feature\Frontend;

use App\Models\School;
use App\Models\PpdbPeriod;
use App\Models\PpdbRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PpdbRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected School $school;
    protected PpdbPeriod $period;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->school = School::factory()->create(['is_active' => true]);
        
        $this->period = PpdbPeriod::factory()->create([
            'school_id' => $this->school->id,
            'is_active' => true,
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(30),
            'quota' => 100,
        ]);
        
        app()->instance('currentSchool', $this->school);
    }

    public function test_ppdb_registration_form_accessible_during_active_period(): void
    {
        $response = $this->withSession(['school_id' => $this->school->id])
            ->get('/ppdb/daftar');

        $response->assertStatus(200);
    }

    public function test_ppdb_registration_can_be_submitted(): void
    {
        $response = $this->withSession(['school_id' => $this->school->id])
            ->post('/ppdb/daftar', [
                'student_name' => 'Ahmad Fauzi',
                'birth_place' => 'Jakarta',
                'birth_date' => '2010-05-15',
                'gender' => 'L',
                'religion' => 'Islam',
                'address' => 'Jl. Merdeka No. 123',
                'father_name' => 'Budi Santoso',
                'mother_name' => 'Siti Aminah',
                'parent_phone' => '081234567890',
            ]);

        $this->assertDatabaseHas('ppdb_registrations', [
            'student_name' => 'Ahmad Fauzi',
            'school_id' => $this->school->id,
            'period_id' => $this->period->id,
        ]);

        $response->assertSessionHas('success');
    }

    public function test_ppdb_status_check_works(): void
    {
        $registration = PpdbRegistration::factory()->create([
            'school_id' => $this->school->id,
            'period_id' => $this->period->id,
            'registration_number' => 'PPDB-2024-0001',
        ]);

        $response = $this->withSession(['school_id' => $this->school->id])
            ->get('/ppdb/status?no=PPDB-2024-0001');

        $response->assertStatus(200);
        $response->assertSee($registration->student_name);
    }

    public function test_ppdb_status_shows_not_found_for_invalid_number(): void
    {
        $response = $this->withSession(['school_id' => $this->school->id])
            ->get('/ppdb/status?no=INVALID-NUMBER');

        $response->assertStatus(200);
        $response->assertSee('tidak ditemukan');
    }

    public function test_contact_form_can_be_submitted(): void
    {
        $response = $this->withSession(['school_id' => $this->school->id])
            ->post('/kontak', [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'subject' => 'Pertanyaan',
                'message' => 'Ini adalah pesan test.',
            ]);

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'John Doe',
            'school_id' => $this->school->id,
        ]);

        $response->assertSessionHas('success');
    }
}
