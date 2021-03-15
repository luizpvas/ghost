<?php

namespace Database\Factories;

use App\Models\Session;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Session::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'status' => 'active',
            'confirmation_code' => null
        ];
    }

    /**
     * Updates the session status to pending.
     * 
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function pending()
    {
        return $this->state(function ($attributes) {
            return [
                'status' => 'waiting_confirmation_code',
                'confirmation_code' => \Illuminate\Support\Str::random(5),
            ];
        });
    }
}
