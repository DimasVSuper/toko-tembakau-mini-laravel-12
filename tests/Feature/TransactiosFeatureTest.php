<?php
    namespace Tests\Feature;

    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;
    use App\Models\User;
    use App\Models\Categories;
    use App\Models\Transactions;

    class TransactiosFeatureTest extends TestCase
    {
        use RefreshDatabase;

        public function test_guest_cannot_access_transactions(): void
        {
            $response = $this->get('/transactions');
            $response->assertRedirect('/login');
        }

        public function test_user_can_crud_transaction(): void
        {
            $user = User::factory()->create();
            $this->actingAs($user);
            $category = Categories::factory()->create(['user_id' => $user->id]);

            // Create
            $response = $this->post('/transactions', [
                'category_id' => $category->id,
                'amount' => 12345,
                'type' => 'income',
                'date' => now()->toDateString(),
                'description' => 'Test transaksi',
            ]);
            $response->assertStatus(201);
            $this->assertDatabaseHas('transactions', [
                'amount' => 12345,
                'user_id' => $user->id,
                'category_id' => $category->id,
            ]);

            $trx = Transactions::first();

            // Read (index)
            $response = $this->get('/transactions');
            $response->assertStatus(200)->assertJsonFragment(['amount' => 12345]);

            // Update
            $response = $this->put('/transactions/' . $trx->id, [
                'category_id' => $category->id,
                'amount' => 54321,
                'type' => 'income',
                'date' => now()->toDateString(),
                'description' => 'Update transaksi',
            ]);
            $response->assertStatus(200);
            $this->assertDatabaseHas('transactions', [
                'amount' => 54321,
                'description' => 'Update transaksi',
            ]);

            // Delete
            $response = $this->delete('/transactions/' . $trx->id);
            $response->assertStatus(200);
            $this->assertDatabaseMissing('transactions', [
                'id' => $trx->id,
            ]);
        }
    }
