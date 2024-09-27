<?php

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
// use PHPUnit\Framework\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        // $categories = Category::factory(5)->create();
        $categories = [
            ['name' => 'Category 1'],
            ['name' => 'Category 2'],
            ['name' => 'Category 3'],
            ['name' => 'Category 4'],
            ['name' => 'Category 5'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonStructure(['categories' => [['id', 'name', 'created_at', 'updated_at']]]);
    }

    public function test_store()
    {
        $response = $this->postJson('/api/categories', [
            'name' => 'New Category'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas(
            'categories',
            [
                'name' => 'New Category'
            ]
        );
    }

    public function test_update()
    {
        $category = Category::create(['name' => 'Original Category']);

        $updatedData = ['name' => 'Updated Category Name'];

        $response = $this->putJson("/api/categories/{$category->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson(['status' => 200, 'message' => 'Category updated successfully']);

        $this->assertDatabaseHas('categories', $updatedData);
    }

    public function test_destroy()
    {
        $category = Category::create(['name' => 'Category to Delete']);

        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(200)
            ->assertJson(['status' => 200, 'message' => 'Category deleted successfully']);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
