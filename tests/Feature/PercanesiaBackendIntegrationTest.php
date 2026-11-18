<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PercanesiaBackendIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_shows_featured_products_from_database(): void
    {
        Product::create([
            'name' => 'Tas Patchwork Eksklusif',
            'slug' => 'tas-patchwork-eksklusif',
            'category' => 'Tas',
            'price' => 195000,
            'stock' => 5,
            'is_featured' => true,
            'is_active' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Tas Patchwork Eksklusif');
        $response->assertSee('195.000');
    }

    public function test_katalog_and_filter_works_dynamically(): void
    {
        $tas = Product::create([
            'name' => 'Tote Bag Etnik',
            'slug' => 'tote-bag-etnik',
            'category' => 'Tas',
            'price' => 150000,
            'stock' => 10,
            'is_active' => true,
        ]);

        $dompet = Product::create([
            'name' => 'Dompet Perca Mungil',
            'slug' => 'dompet-perca-mungil',
            'category' => 'Dompet',
            'price' => 50000,
            'stock' => 10,
            'is_active' => true,
        ]);

        // Filter category tas
        $response = $this->get('/katalog?kategori=tas');
        $response->assertStatus(200);
        $response->assertSee('Tote Bag Etnik');
        $response->assertDontSee('Dompet Perca Mungil');

        // Search query
        $searchResponse = $this->get('/katalog?q=Mungil');
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Dompet Perca Mungil');
        $searchResponse->assertDontSee('Tote Bag Etnik');
    }

    public function test_product_detail_page_loads_and_form_adds_to_cart(): void
    {
        $product = Product::create([
            'name' => 'Sarung Bantal Motif Perca',
            'slug' => 'sarung-bantal-motif-perca',
            'category' => 'Sarung Bantal',
            'price' => 85000,
            'stock' => 8,
            'description' => 'Sarung bantal elegan dari katun lembut.',
            'is_active' => true,
        ]);

        $detailResponse = $this->get('/katalog/detail/' . $product->id);
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Sarung Bantal Motif Perca');
        $detailResponse->assertSee('85.000');

        // Test add to cart
        $cartResponse = $this->post('/keranjang', [
            'product_id' => $product->id,
            'quantity' => 2,
            'variant' => 'Sage Green',
        ]);
        $cartResponse->assertRedirect('/keranjang');

        // Check cart page
        $cartIndex = $this->get('/keranjang');
        $cartIndex->assertStatus(200);
        $cartIndex->assertSee('Sarung Bantal Motif Perca');
    }

    public function test_contact_form_submits_and_saves_to_database(): void
    {
        $response = $this->post('/contact/send', [
            'name' => 'Ahmad Fauzi',
            'email' => 'fauzi@example.com',
            'phone' => '08123456789',
            'subject' => 'Custom Order',
            'message' => 'Saya ingin custom selimut perca ukuran 200x200.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Ahmad Fauzi',
            'email' => 'fauzi@example.com',
            'subject' => 'Custom Order',
        ]);
    }

    public function test_admin_dashboard_and_crud_actions(): void
    {
        $product = Product::create([
            'name' => 'Selimut Perca Hangat',
            'slug' => 'selimut-perca-hangat',
            'category' => 'Selimut',
            'price' => 250000,
            'stock' => 2,
            'is_active' => true,
        ]);

        // Dashboard
        $dashboardResponse = $this->get('/admin/dashboard');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Selimut Perca Hangat');

        // Update stock via admin endpoint
        $stockResponse = $this->patchJson('/admin/produk/' . $product->id . '/stock', [
            'stock' => 15,
        ]);
        $stockResponse->assertStatus(200);
        $this->assertEquals(15, $product->fresh()->stock);

        // Delete product
        $deleteResponse = $this->deleteJson('/admin/produk/' . $product->id);
        $deleteResponse->assertStatus(200);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
