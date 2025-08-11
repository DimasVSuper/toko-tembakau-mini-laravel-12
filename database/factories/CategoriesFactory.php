<?php

namespace Database\Factories;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoriesFactory extends Factory
{
	protected $model = Categories::class;

	public function definition(): array
	{
		return [
			'user_id' => Str::ulid()->toBase32(),
			'name' => $this->faker->randomElement(['Makan', 'Gaji', 'Transport', 'Belanja', 'Hiburan']),
			'type' => $this->faker->randomElement(['income', 'expense']),
		];
	}
}
