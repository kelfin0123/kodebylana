<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class ServiceController extends Controller
{
    /**
     * Halaman daftar layanan (publik) + filter & pencarian.
     */
    public function index(Request $request): View
    {
        // Jika tabel belum ada (fresh install), tampilkan kosong tanpa error.
        if (! Schema::hasTable('services')) {
            return view('services.index', [
                'services'   => collect(),
                'categories' => [],
                'filters'    => ['category' => '', 'q' => ''],
            ]);
        }

        $filters = [
            'category' => (string) $request->query('category', ''),
            'q'        => (string) $request->query('q', ''),
        ];

        // Cache key mengikuti filter agar tidak tercampur
        $cacheKey = 'public.services.index.' . md5(json_encode($filters));

        $services = Cache::remember($cacheKey, 600, function () use ($filters) {
            $q = Service::query();

            // Tampilkan hanya yang aktif jika kolomnya ada
            if (Schema::hasColumn('services', 'is_active')) {
                $q->where('is_active', true);
            }

            // Filter kategori jika ada
            if ($filters['category'] !== '' && Schema::hasColumn('services', 'category')) {
                $q->where('category', $filters['category']);
            }

            // Pencarian sederhana di name & short_description
            if ($filters['q'] !== '') {
                $keyword = $filters['q'];
                $q->where(function ($qq) use ($keyword) {
                    $qq->where('name', 'like', "%{$keyword}%")
                       ->orWhere('short_description', 'like', "%{$keyword}%");
                });
            }

            // Urutan default: sort_order (jika ada) lalu terbaru
            if (Schema::hasColumn('services', 'sort_order')) {
                $q->orderBy('sort_order')->orderByDesc('id');
            } else {
                $q->latest('id');
            }

            return $q->get();
        });

        // Ambil daftar kategori untuk dropdown filter
        $categories = Schema::hasColumn('services', 'category')
            ? Service::query()
                ->whereNotNull('category')
                ->distinct()
                ->orderBy('category')
                ->pluck('category')
                ->toArray()
            : [];

        return view('services.index', [
            'services'   => $services,
            'categories' => $categories,
            'filters'    => $filters,
        ]);
    }

    /**
     * Halaman detail layanan (resolve by slug, fallback id).
     */
    public function show(string $service): View
    {
        $record = Service::query()
            // Sembunyikan yang tidak aktif kalau kolomnya ada
            ->when(
                Schema::hasColumn('services', 'is_active'),
                fn ($q) => $q->where('is_active', true)
            )
            // Cari berdasarkan slug terlebih dahulu, kalau tidak ketemu pakai id
            ->where(function ($q) use ($service) {
                $q->where('slug', $service)->orWhere('id', $service);
            })
            ->firstOrFail();

        return view('services.show', ['service' => $record]);
    }
}
