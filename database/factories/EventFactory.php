<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        $name = $this->faker->unique()->sentence();

        File::copy(
            public_path() . "/images/image.png",
            public_path() . "/images/" . Str::kebab(Str::substr($this->model, 11)) . "/" . Str::slug($name) . ".png",
        );

        return [
            "name" => $name,
            "name_id" => $this->faker->unique()->sentence(),
            "description" => $this->faker->paragraph(),
            "description_id" => $this->faker->paragraph(),
            "location" => $this->faker->address(),
            "start" => $this->faker->dateTime(),
            "end" => $this->faker->dateTime(),
            "image" => Str::slug($name) . ".png",
            "slug" => Str::slug($name),
            "active" => $this->faker->boolean(),
        ];
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                "active" => true,
            ];
        });
    }

    public function nonActive()
    {
        return $this->state(function (array $attributes) {
            return [
                "active" => false,
            ];
        });
    }
}
