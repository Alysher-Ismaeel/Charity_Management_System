<?php

namespace Database\Factories\Food;

use App\Models\Feeding\FoodSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FoodSectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = FoodSection::class;
    public function definition()
    {
        return [
            'name' => $this->faker->text(20),
            'count'=>$this->faker->numberBetween(1,100),
            'cost'=>$this->faker->numberBetween(500,5000),
            'image'=>$this->faker->image(),
        ];
    }
}
