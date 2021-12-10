<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Jobs;
use App\Models\ServiceUser;
use App\Models\User;

class JobsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Jobs::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service_user_id' => ServiceUser::factory(),
            'user_id' => User::factory(),
            'scheduled_time' => $this->faker->dateTime(),
            'desc' => $this->faker->text,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'address' => $this->faker->text,
        ];
    }
}
