<?php
    namespace Tests\Unit;

    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;
    use App\Models\User;
    use App\Models\Categories;

    class UserUnitTest extends TestCase
    {
        use RefreshDatabase;

        public function test_create_user(): void
        {
            $user = User::factory()->create([
                'name' => 'Unit Test User',
                'email' => 'unit@example.com',
            ]);
            $this->assertDatabaseHas('users', [
                'email' => 'unit@example.com',
            ]);
        }

        public function test_delete_user(): void
        {
            $user = User::factory()->create();
            $this->assertDatabaseHas('users', ['id' => $user->id]);
            $user->delete();
            $this->assertDatabaseMissing('users', ['id' => $user->id]);
        }

        public function test_user_has_categories_relation(): void
        {
            $user = User::factory()->create();
            $category = Categories::factory()->create(['user_id' => $user->id]);
            $this->assertTrue($user->categories->contains($category));
        }

        public function test_update_user(): void
        {
            $user = User::factory()->create([
                'name' => 'Old Name',
            ]);
            $user->update(['name' => 'New Name']);
            $this->assertDatabaseHas('users', [
                'id' => $user->id,
                'name' => 'New Name',
            ]);
        }

        public function test_user_without_categories(): void
        {
            $user = User::factory()->create();
            $this->assertCount(0, $user->Categories);
        }

        public function test_cascade_delete_user_categories(): void
        {
            $user = User::factory()->create();
            $category = Categories::factory()->create(['user_id' => $user->id]);
            $this->assertDatabaseHas('categories', ['id' => $category->id]);
            $user->delete();
            $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        }
    }
