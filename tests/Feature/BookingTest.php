<?php

namespace Tests\Feature;

use App\Domains\User\Entities\User;
use App\Domains\Arenas\Entities\Arena;
use App\Domains\Arenas\Entities\TimeSlot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function a_user_can_book_a_time_slot()
    {
        // إنشاء مستخدم يدويًا
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // إنشاء Arena يدويًا
        $arena = Arena::create([
            'name' => 'Test Arena',
            'description' => 'Sample description',
            'owner_id' => $user->id,
        ]);

        // إنشاء TimeSlot يدويًا
        $timeSlot = TimeSlot::create([
            'arena_id' => $arena->id,
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'is_booked' => false,
        ]);

        // تسجيل الدخول كمستخدم
        $this->actingAs($user);

        // تنفيذ طلب الحجز
        $response = $this->postJson('/api/bookings', [
            'arena_id' => $arena->id,
            'time_slot_id' => $timeSlot->id,
        ]);

        // التحقق من الاستجابة
        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'arena_id', 'user_id', 'time_slot_id', 'status']);

        // التأكد من إدراج الحجز في قاعدة البيانات
        $this->assertDatabaseHas('bookings', [
            'arena_id' => $arena->id,
            'user_id' => $user->id,
            'time_slot_id' => $timeSlot->id,
            'status' => 'pending',
        ]);
    }
}
