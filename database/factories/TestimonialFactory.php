<?php
// database/factories/TestimonialFactory.php
namespace Database\Factories;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'role' => $this->faker->jobTitle(),
            'company' => $this->faker->company(),
            'link' => $this->faker->url(),
            'rating' => $this->faker->numberBetween(4,5),
            'content' => $this->faker->paragraph(2),
            'project_title' => $this->faker->words(3, true),
            'is_published' => true,
            'published_at' => now(),
        ];
    }
}
