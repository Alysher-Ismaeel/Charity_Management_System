<?php

namespace Database\Factories\Health;

use App\Models\Health\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Patient::class;
    
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'medical_condition'=> $this->faker->text(20),
            'birth_date'=>$this->faker->dateTimeBetween('2008-1-1','2022-1-1'),
            'cost'=>$this->faker->numberBetween(1000,20000),
            'description'=>$this->faker->text(100),
            'image'=>$this->faker->image(),
            'gender'=>$this->faker->randomElement(['male','female']),
        ];
    }
}
