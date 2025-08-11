<?php

namespace Database\Factories;

use App\Models\Transactions;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransactionsFactory extends Factory
{
	protected $model = Transactions::class;

	public function definition(): array
	{
		return [
			// Gantilah dengan ULID valid dari user dan kategori yang sudah ada jika ingin relasi valid
			'user_id' => Str::ulid()->toBase32(),
			'category_id' => Str::ulid()->toBase32(),
			'amount' => $this->faker->randomFloat(2, 1000, 1000000),
			'type' => $this->faker->randomElement(['income', 'expense']),
			'date' => $this->faker->date(),
			'description' => $this->faker->sentence(),
		];
	}
}
