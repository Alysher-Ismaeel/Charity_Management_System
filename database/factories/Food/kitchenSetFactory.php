<?php

namespace Database\Factories\Food;

use App\Models\Feeding\KitchenSet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class kitchenSetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = KitchenSet::class;
    public function definition()
    {
        return [
            'name' => $this->faker->text(20),
            'count'=>$this->faker->numberBetween(1,100),
            'cost'=>$this->faker->numberBetween(5000,50000),
            'image'=>$this->faker->image(),
        ];
    }
}
