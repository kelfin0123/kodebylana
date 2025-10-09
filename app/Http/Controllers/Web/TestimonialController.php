<?php
// app/Http/Controllers/Web/TestimonialController.php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $perPage = max(6, min((int) $request->query('per_page', 9), 30));

        $testimonials = Testimonial::query()
            ->where('is_published', true)
            ->select(['id','name','photo','role','company','link','rating','content','project_title','published_at','created_at'])
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->paginate($perPage)
            ->withQueryString();

        return view('testimonials', compact('testimonials')); // ini akan ketemu kalau step 1-2 benar
    }
}
