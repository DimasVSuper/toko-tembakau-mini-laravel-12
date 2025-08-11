<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Transactions;
use App\Models\User;
use App\Models\Categories;

class TransactionsUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_transaction(): void
    {
        $user = User::factory()->create();
        $category = Categories::factory()->create(['user_id' => $user->id]);
        $trx = Transactions::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 50000,
            'type' => 'income',
        ]);
        $this->assertDatabaseHas('transactions', [
            'id' => $trx->id,
            'amount' => 50000,
        ]);
    }

    public function test_update_transaction(): void
    {
        $user = User::factory()->create();
        $category = Categories::factory()->create(['user_id' => $user->id]);
        $trx = Transactions::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => 10000,
        ]);
        $trx->update(['amount' => 20000]);
        $this->assertDatabaseHas('transactions', [
            'id' => $trx->id,
            'amount' => 20000,
        ]);
    }

    public function test_delete_transaction(): void
    {
        $user = User::factory()->create();
        $category = Categories::factory()->create(['user_id' => $user->id]);
        $trx = Transactions::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
        $trx->delete();
        $this->assertDatabaseMissing('transactions', [
            'id' => $trx->id,
        ]);
    }

    public function test_transaction_relations(): void
    {
        $user = User::factory()->create();
        $category = Categories::factory()->create(['user_id' => $user->id]);
        $trx = Transactions::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
        $this->assertEquals($user->id, $trx->user->id);
        $this->assertEquals($category->id, $trx->category->id);
    }
}
