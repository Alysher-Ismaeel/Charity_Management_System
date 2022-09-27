<?php

namespace Database\Factories\Education;

use App\Models\Education\Guarantee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class guaranteeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Guarantee::class;
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'birth_date'=>$this->faker->dateTimeBetween('2008-1-1','2022-1-1'),
            'cost'=>$this->faker->numberBetween(1000,20000),
            'academic_year'=>$this->faker->randomElement(['First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eighth','ninth']),
            'image'=>$this->faker->image(),
        ];
    }
}
