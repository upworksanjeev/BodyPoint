<?php

namespace App\Http\Controllers;

use App\Enums\VaultCategory;
use App\Mail\vaultMail;
use App\Services\Vault\VaultAccessService;
use App\Services\Vault\VaultCatalogService;
use App\Services\Vault\VaultSearchQuery;
use App\Support\Vault\VaultCatalogImporter;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class VaultController extends Controller
{
    public function __construct(
        private readonly VaultCatalogService $catalog,
        private readonly VaultAccessService $access,
    ) {
    }

    public function index(Request $request): View
    {
        $customerClass = $this->access->currentCustomerClass();
        $search = VaultSearchQuery::fromRequest($request);
        $isSearching = $search->hasCriteria();

        return view('vault.index', $this->shared($search, $customerClass) + [
            'isSearching' => $isSearching,
            'results' => $isSearching ? $this->catalog->search($search, $customerClass) : collect(),
            'frequentlyUsed' => $this->catalog->frequentlyUsed($customerClass),
            'newlyAdded' => $this->catalog->newlyAdded($customerClass),
            'categories' => $this->catalog->categorySummaries($customerClass),
        ]);
    }

    public function category(Request $request, VaultCategory $category): View
    {
        $customerClass = $this->access->currentCustomerClass();
        $search = VaultSearchQuery::fromRequest($request, $category);

        return view('vault.category', $this->shared($search, $customerClass) + [
            'category' => $category,
            'results' => $this->catalog->search($search, $customerClass),
        ]);
    }

    public function tour(): View
    {
        $customerClass = $this->access->currentCustomerClass();

        return view('vault.tour', [
            'starters' => $this->catalog->tourStarters($customerClass),
            'videoUrl' => config('vault.tour_video_embed_url'),
        ]);
    }

    /**
     * Browser-hit replacement for `php artisan migrate` + VaultAssetSeeder
     * when SSH is not available. Lives under /admin so a Nova login counts.
     * Safe to re-run: existing marketing tags and shelf flags are left alone.
     */
    public function seedCatalog(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->user() === null) {
            return redirect('/admin/login');
        }

        abort_unless((bool) $request->user()->is_admin, 403);

        Artisan::call('migrate', ['--force' => true]);

        $summary = app(VaultCatalogImporter::class)->import();

        return response()->json([
            'message' => sprintf(
                'Vault catalogue: %d created, %d updated (%d total).',
                $summary['created'],
                $summary['updated'],
                $summary['total']
            ),
            'created' => $summary['created'],
            'updated' => $summary['updated'],
            'total' => $summary['total'],
        ]);
    }

    public function submitReview(Request $request): RedirectResponse
    {
        try {
            Mail::to(config('vault.review_mailbox'))->send(new vaultMail($request->all()));

            return redirect()->back()->with('success', 'Email sent successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to send email: '.$e->getMessage());
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function shared(VaultSearchQuery $search, ?string $customerClass): array
    {
        $subCategories = [];
        $groups = [];

        if ($search->category !== null) {
            $subCategories = $this->catalog->subCategorySummaries($search->category, $customerClass);
            if ($search->subCategory !== null) {
                $groups = $this->catalog->groupSummaries($search->category, $search->subCategory, $customerClass);
            }
        }

        return [
            'search' => $search,
            'fileTypes' => $this->catalog->availableFileTypes($search, $customerClass),
            'subCategories' => $subCategories,
            'groups' => $groups,
        ];
    }
}
