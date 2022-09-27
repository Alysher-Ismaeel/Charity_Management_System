<?php

namespace Database\Factories\Health;

use App\Models\Health\MedicalTool;
use App\Models\Health\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Medicine::class;
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
