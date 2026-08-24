<?php

namespace Tests\Feature;

use App\Enums\VaultCategory;
use App\Models\User;
use App\Models\VaultAsset;
use App\Support\Vault\VaultCatalogImporter;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Covers Partner Vault search, category browse, the tour, and pricing visibility.
 *
 * Creates and removes its own account and assets so it is safe against a populated database.
 */
class VaultCatalogTest extends TestCase
{
    private ?User $user = null;

    /** @var array<int, VaultAsset> */
    private array $assets = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Vault Catalog Test',
            'email' => 'vault-catalog-'.Str::random(12).'@example.test',
            'password' => bcrypt(Str::random(16)),
        ]);
        $this->user->forceFill(['email_verified_at' => now()])->save();

        Permission::firstOrCreate(['name' => 'accessVault', 'guard_name' => 'web'], ['group' => 'vault']);
        $this->user->givePermissionTo('accessVault');

        $this->assets[] = VaultAsset::factory()->create([
            'title' => 'Stayflex Anterior Trunk Support',
            'tags' => ['harness', 'upper body'],
            'category' => VaultCategory::ProductAndTechnical,
            'sub_category' => 'Product Instructions',
            'group_name' => 'Upper Body Instructions',
        ]);
        $this->assets[] = VaultAsset::factory()->create([
            'title' => 'BPI009 Grommet Straps',
            'category' => VaultCategory::ProductAndTechnical,
            'sub_category' => 'Product Instructions',
            'group_name' => 'Hardware Instructions',
        ]);
        $this->assets[] = VaultAsset::factory()->create([
            'title' => 'Trifold Brochure',
            'tags' => ['brochure'],
            'is_frequently_used' => true,
            'is_tour_starter' => true,
            'is_newly_added' => true,
        ]);
        $this->assets[] = VaultAsset::factory()->pricing('Americas')->create();
        $this->assets[] = VaultAsset::factory()->pricing('International')->create();
        $this->assets[] = VaultAsset::factory()->create([
            'title' => 'Hidden Inactive File',
            'is_active' => false,
        ]);
    }

    protected function tearDown(): void
    {
        foreach ($this->assets as $asset) {
            $asset->delete();
        }

        if ($this->user) {
            $this->user->syncPermissions([]);
            $this->user->forceDelete();
        }

        parent::tearDown();
    }

    public function test_guests_are_sent_to_login(): void
    {
        $this->get(route('vault'))->assertRedirect();
    }

    public function test_users_without_vault_access_cannot_open_the_library(): void
    {
        $this->user->revokePermissionTo('accessVault');

        $this->actingAs($this->user)
            ->get(route('vault'))
            ->assertRedirect(route('dashboard'));
    }

    public function test_search_finds_an_asset_by_name_and_shows_a_count(): void
    {
        $this->actingAs($this->user)
            ->get(route('vault', ['q' => 'Stayflex']))
            ->assertOk()
            ->assertSee('Stayflex Anterior Trunk Support')
            ->assertSee('1 asset')
            ->assertDontSee('Hidden Inactive File');
    }

    public function test_search_shows_an_empty_state_when_nothing_matches(): void
    {
        $this->actingAs($this->user)
            ->get(route('vault', ['q' => 'zzzxnotanasset']))
            ->assertOk()
            ->assertSee('No assets match your search')
            ->assertSee('0 assets');
    }

    public function test_file_type_and_category_filters_narrow_results(): void
    {
        $this->actingAs($this->user)
            ->get(route('vault', ['type' => 'pdf', 'category' => 'marketing-collateral']))
            ->assertOk()
            ->assertSee('Trifold Brochure')
            ->assertDontSee('Stayflex Anterior Trunk Support');
    }

    public function test_the_category_page_lists_assets_with_a_breadcrumb(): void
    {
        $this->actingAs($this->user)
            ->get(route('vault.category', 'product-and-technical'))
            ->assertOk()
            ->assertSee('Product and Technical')
            ->assertSee('Stayflex Anterior Trunk Support')
            ->assertSee('Partner Vault');
    }

    public function test_category_group_filters_replace_the_old_nested_accordions(): void
    {
        $this->actingAs($this->user)
            ->get(route('vault.category', [
                'category' => 'product-and-technical',
                'sub' => 'Product Instructions',
            ]))
            ->assertOk()
            ->assertSee('Upper Body Instructions')
            ->assertSee('Hardware Instructions')
            ->assertSee('Stayflex Anterior Trunk Support')
            ->assertSee('BPI009 Grommet Straps');

        $this->actingAs($this->user)
            ->get(route('vault.category', [
                'category' => 'product-and-technical',
                'sub' => 'Product Instructions',
                'group' => 'Hardware Instructions',
            ]))
            ->assertOk()
            ->assertSee('BPI009 Grommet Straps')
            ->assertDontSee('Stayflex Anterior Trunk Support');
    }

    public function test_the_vault_page_shows_subcategory_and_group_chips_after_a_category_is_chosen(): void
    {
        $this->actingAs($this->user)
            ->get(route('vault', ['category' => 'product-and-technical']))
            ->assertOk()
            ->assertSee('Sub-category')
            ->assertSee('Product Instructions')
            ->assertDontSee('Upper Body Instructions');

        $this->actingAs($this->user)
            ->get(route('vault', [
                'category' => 'product-and-technical',
                'sub' => 'Product Instructions',
            ]))
            ->assertOk()
            ->assertSee('Group')
            ->assertSee('Upper Body Instructions')
            ->assertSee('Hardware Instructions');
    }

    public function test_the_tour_shows_the_intro_and_starter_shortlist(): void
    {
        $this->actingAs($this->user)
            ->get(route('vault.tour'))
            ->assertOk()
            ->assertSee('New to the Vault?')
            ->assertSee('Start here')
            ->assertSee('Trifold Brochure');
    }

    public function test_pricing_is_hidden_for_manufacturer_accounts(): void
    {
        $this->withSession([
            'customer_details' => [
                'CustomerClass' => 'WM',
                'CustomerName' => 'Vault Test Customer',
            ],
        ]);

        $this->actingAs($this->user)
            ->get(route('vault', ['q' => 'Americas']))
            ->assertOk()
            ->assertDontSee('Americas.xlsx');

        $this->actingAs($this->user)
            ->get(route('vault.category', 'pricing-guide'))
            ->assertOk()
            ->assertSee('0 assets');
    }

    public function test_pricing_is_visible_for_an_allowed_customer_class(): void
    {
        $this->withSession([
            'customer_details' => [
                'CustomerClass' => 'VA',
                'CustomerName' => 'Vault Test Customer',
            ],
        ]);

        $this->actingAs($this->user)
            ->get(route('vault.category', 'pricing-guide'))
            ->assertOk()
            ->assertSee('Americas')
            ->assertDontSee('International');
    }

    public function test_the_landing_page_shows_shelves_when_not_searching(): void
    {
        $this->actingAs($this->user)
            ->get(route('vault'))
            ->assertOk()
            ->assertSee('Frequently used')
            ->assertSee('Newly added')
            ->assertSee('Browse by category')
            ->assertSee('Review My Document')
            ->assertSee('vault-search', false);
    }

    public function test_guests_cannot_run_the_vault_seeder_route(): void
    {
        $this->get(route('vault.seed-catalog'))
            ->assertRedirect('/admin/login');
    }

    public function test_non_admins_cannot_run_the_vault_seeder_route(): void
    {
        $this->actingAs($this->user)
            ->get(route('vault.seed-catalog'))
            ->assertForbidden();
    }

    public function test_admins_can_run_the_vault_seeder_route(): void
    {
        Role::findOrCreate('Admin', 'web');
        $this->user->assignRole('Admin');

        $this->mock(VaultCatalogImporter::class, function ($mock) {
            $mock->shouldReceive('import')->once()->andReturn([
                'created' => 10,
                'updated' => 2,
                'total' => 12,
            ]);
        });

        $this->actingAs($this->user)
            ->get(route('vault.seed-catalog'))
            ->assertOk()
            ->assertJson([
                'created' => 10,
                'updated' => 2,
                'total' => 12,
            ]);
    }
}
