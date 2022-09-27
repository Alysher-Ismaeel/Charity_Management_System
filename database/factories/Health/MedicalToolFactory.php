<?php

namespace Database\Factories\Health;

use App\Models\Health\MedicalTool;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MedicalToolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = MedicalTool::class;
    public function definition()
    {
        return [
            'name' => $this->faker->text(20),
            'count'=>$this->faker->numberBetween(1,100),
            'cost'=>$this->faker->numberBetween(10000,50000),
            'image'=>$this->faker->image(),
        ];
    }
}
