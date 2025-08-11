<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Categories;
use App\Models\User;
use App\Models\Transactions;

class CategoriesUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_category(): void
    {
        $user = User::factory()->create();
        $category = Categories::factory()->create([
            'user_id' => $user->id,
            'name' => 'Makan',
            'type' => 'expense',
        ]);
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Makan',
        ]);
    }

    public function test_update_category(): void
    {
        $user = User::factory()->create();
        $category = Categories::factory()->create(['user_id' => $user->id, 'name' => 'Lama']);
        $category->update(['name' => 'Baru']);
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Baru',
        ]);
    }

    public function test_delete_category(): void
    {
        $user = User::factory()->create();
        $category = Categories::factory()->create(['user_id' => $user->id]);
        $category->delete();
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

    public function test_category_relations(): void
    {
        $user = User::factory()->create();
        $category = Categories::factory()->create(['user_id' => $user->id]);
        $trx = Transactions::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
        $this->assertEquals($user->id, $category->user->id);
        $this->assertTrue($category->transactions->contains($trx));
    }
}
