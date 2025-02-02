<?php

namespace Tests\Feature;

 use App\Models\Url;
 use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_it_shortens_url(): void
    {
        $response = $this->post('/encode', [
            'url' => 'http://www.google.com',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['short_url']);
    }

    public function test_that_it_returns_the_url_from_the_short_url(): void
    {
        $longUrl = 'http://www.google.com';

        $url = Url::factory()->create([
            'url' => $longUrl,
        ]);

        $response = $this->post('/decode', [
            'short_url' => rtrim(config('app.url'), '/') . '/' .$url->alias
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'url' => $longUrl
            ]);
    }

    public function test_that_it_fails_to_shorten_url_with_invalid_data(): void
    {
        $response = $this->post('/encode', []);

        $response
            ->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'url' => ['The url field is required.'],
                ]
            ]);
    }

    public function test_that_short_url_redirects_to_url(): void
    {
        $url = 'http://www.google.com';

        $url = Url::factory()->create([
            'url' => $url,
        ]);

        $response = $this->get($url->short_url);

        $response->assertRedirect($url->url);
    }

    public function test_that_it_paginates_all_urls(): void
    {
        Url::factory()->count(30)->create();
        $this->assertDatabaseCount('urls', 30);

        $response = $this->get('/urls');

        $response->assertJsonStructure(['urls', 'meta', 'links']);
        $data = $response->json();
        $urls = $data['urls'];
        $this->assertCount(15, $urls);
    }
}
