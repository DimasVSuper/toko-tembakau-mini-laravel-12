<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Categories;

class CategoriesFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_categories(): void
    {
        $response = $this->get('/categories');
        $response->assertRedirect('/login');
    }

    public function test_user_can_crud_category(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create
        $response = $this->post('/categories', [
            'name' => 'Makan',
            'type' => 'expense',
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', [
            'name' => 'Makan',
            'type' => 'expense',
            'user_id' => $user->id,
        ]);

        $category = Categories::first();

        // Read (index)
        $response = $this->get('/categories');
        $response->assertStatus(200)->assertJsonFragment(['name' => 'Makan']);

        // Update
        $response = $this->put('/categories/' . $category->id, [
            'name' => 'Belanja',
            'type' => 'expense',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', [
            'name' => 'Belanja',
            'user_id' => $user->id,
        ]);

        // Delete
        $response = $this->delete('/categories/' . $category->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}
