<?php

namespace Database\Factories;

use App\Models\TuitionFee;
use Illuminate\Database\Eloquent\Factories\Factory;

class TuitionFeeFactory extends Factory
{
    protected $model = TuitionFee::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->sentence(),
            'name_id' => $this->faker->unique()->sentence(),
            'description' => $this->faker->paragraph(),
            'description_id' => $this->faker->paragraph(),
            'active' => $this->faker->boolean(),
        ];
    }

    public function active()
    {
        return $this->state(fn ($attributes) => ['active' => true]);
    }

    public function nonActive()
    {
        return $this->state(fn ($attributes) => ['active' => false]);
    }
}
