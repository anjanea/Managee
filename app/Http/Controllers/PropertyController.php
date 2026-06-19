<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query();

        // Filter by search keyword (name, location, address, reviews comments, or rating stars)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhereHas('reviews', function($rq) use ($search) {
                      $rq->where('comment', 'like', "%{$search}%");
                  });

                // Extract numeric star ratings if user typed things like "5 bintang", "bintang 5", "rating 5", or just a number 1-5
                $starSearch = null;
                if (preg_match('/(\d+)\s*bintang/i', $search, $matches)) {
                    $starSearch = (int)$matches[1];
                } elseif (preg_match('/bintang\s*(\d+)/i', $search, $matches)) {
                    $starSearch = (int)$matches[1];
                } elseif (preg_match('/rating\s*(\d+)/i', $search, $matches)) {
                    $starSearch = (int)$matches[1];
                } elseif (is_numeric(trim($search))) {
                    $val = (int)trim($search);
                    if ($val >= 1 && $val <= 5) {
                        $starSearch = $val;
                    }
                }

                if ($starSearch !== null) {
                    $q->orWhereRaw('(select coalesce(round(avg(stars)), 0) from reviews where reviews.property_id = properties.id) = ?', [$starSearch]);
                }
            });
        }

        // Filter by property type
        if ($request->filled('type') && $request->input('type') !== 'all') {
            $query->where('type', $request->input('type'));
        }

        // Filter by minimum rating stars (dynamic reviews average - using round to match the rounded UI presentation)
        if ($request->filled('rating') && $request->input('rating') !== 'all') {
            $rating = (int)$request->input('rating');
            $query->whereRaw('(select coalesce(round(avg(stars)), 0) from reviews where reviews.property_id = properties.id) >= ?', [$rating]);
        }

        // Filter by Min Price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int)$request->input('min_price'));
        }

        // Filter by Max Price
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int)$request->input('max_price'));
        }

        // Apply Sorting
        $sort = $request->input('sort');
        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'stars_desc') {
            $query->select('properties.*')
                  ->selectSub('select coalesce(avg(stars), 0) from reviews where reviews.property_id = properties.id', 'avg_stars')
                  ->orderBy('avg_stars', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Paginate results (9 per page as in mockup)
        $properties = $query->paginate(9)->withQueryString();

        return view('properti.index', compact('properties'));
    }

    public function blogIndexPublic()
    {
        $posts = \App\Models\BlogPost::where('is_own', false)->orderBy('views', 'desc')->orderBy('created_at', 'desc')->get();
        return view('blog.index', compact('posts'));
    }

    public function blogMyPostsPublic()
    {
        $posts = \App\Models\BlogPost::where('is_own', false)
            ->where('author', auth()->user()->name)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('blog.my_posts', compact('posts'));
    }

    public function blogCreatePublic()
    {
        $backUrl = url()->previous();
        if (str_contains($backUrl, 'blog/saya')) {
            $backUrl = route('blog.my_posts_public');
        } else {
            $backUrl = route('blog.public');
        }
        return view('blog.create', compact('backUrl'));
    }

    public function blogStorePublic(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|string',
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'category.required' => 'Kategori artikel wajib diisi.',
            'content.required' => 'Konten artikel wajib diisi.',
        ]);

        $image = 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=600';
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Ensure target folder exists
            if (!file_exists(public_path('uploads/blogs'))) {
                mkdir(public_path('uploads/blogs'), 0755, true);
            }
            $file->move(public_path('uploads/blogs'), $filename);
            $image = '/uploads/blogs/' . $filename;
        } elseif ($request->filled('image')) {
            $image = $request->input('image');
        }

        $title = $request->input('title');
        
        // Automatic fallback if summary is left blank
        $summary = $request->input('summary');
        if (empty($summary)) {
            $summary = \Illuminate\Support\Str::limit(strip_tags($request->input('content')), 120, '...');
        }
        
        \App\Models\BlogPost::create([
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title) . '-' . uniqid(),
            'summary' => $summary,
            'category' => $request->input('category'),
            'content' => $request->input('content'),
            'author' => auth()->user()->name,
            'image' => $image,
            'is_own' => false,
        ]);

        $backUrl = $request->input('back_url') ?: route('blog.public');

        return redirect($backUrl)->with('success', 'Artikel Anda berhasil diterbitkan!');
    }

    public function blogEditPublic($slug)
    {
        $post = \App\Models\BlogPost::where('slug', $slug)->firstOrFail();
        
        if ($post->author !== auth()->user()->name) {
            abort(403, 'Anda tidak diizinkan mengubah artikel ini.');
        }

        $backUrl = url()->previous();
        if (str_contains($backUrl, 'blog/saya')) {
            $backUrl = route('blog.my_posts_public');
        } else {
            $backUrl = route('blog.public');
        }

        return view('blog.edit', compact('post', 'backUrl'));
    }

    public function blogUpdatePublic(\Illuminate\Http\Request $request, $slug)
    {
        $post = \App\Models\BlogPost::where('slug', $slug)->firstOrFail();

        if ($post->author !== auth()->user()->name) {
            abort(403, 'Anda tidak diizinkan mengubah artikel ini.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|string',
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'category.required' => 'Kategori artikel wajib diisi.',
            'content.required' => 'Konten artikel wajib diisi.',
        ]);

        $image = $post->image ?: 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=600';
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            if (!file_exists(public_path('uploads/blogs'))) {
                mkdir(public_path('uploads/blogs'), 0755, true);
            }
            $file->move(public_path('uploads/blogs'), $filename);
            $image = '/uploads/blogs/' . $filename;
        } elseif ($request->filled('image')) {
            $image = $request->input('image');
        }
        
        $summary = $request->input('summary');
        if (empty($summary)) {
            $summary = \Illuminate\Support\Str::limit(strip_tags($request->input('content')), 120, '...');
        }

        $post->update([
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'summary' => $summary,
            'content' => $request->input('content'),
            'image' => $image,
        ]);

        $backUrl = $request->input('back_url') ?: route('blog.public');

        return redirect($backUrl)->with('success', 'Artikel Anda berhasil diperbarui!');
    }

    public function blogDestroyPublic($slug)
    {
        $post = \App\Models\BlogPost::where('slug', $slug)->firstOrFail();

        if ($post->author !== auth()->user()->name) {
            abort(403, 'Anda tidak diizinkan menghapus artikel ini.');
        }

        $post->delete();

        return redirect()->route('blog.public')->with('success', 'Artikel Anda berhasil dihapus!');
    }

    public function showPublic($id)
    {
        $property = Property::findOrFail($id);
        $property->increment('views');
        
        $dbReviews = \App\Models\Review::with('user')
            ->where('property_id', $property->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('properti.show', compact('property', 'dbReviews'));
    }

    public function checkoutPublic(\Illuminate\Http\Request $request, $id)
    {
        if (auth()->check() && auth()->user()->role === 'owner') {
            return redirect()->route('properties.show_public', $id)
                ->with('warning', 'Akun Owner tidak dapat melakukan pemesanan properti.');
        }

        $property = Property::findOrFail($id);
        $checkin = $request->query('checkin') ?: now()->format('Y-m-d');
        $checkout = $request->query('checkout') ?: now()->addMonth()->format('Y-m-d');
        $guests = $request->query('guests', 2);
        
        return view('checkout', compact('property', 'checkin', 'checkout', 'guests'));
    }
}
