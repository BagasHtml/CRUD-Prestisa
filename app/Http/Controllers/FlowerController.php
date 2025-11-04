<?php

namespace App\Http\Controllers;

use App\Models\Flower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FlowerController extends Controller
{
    public function index()
    {
        $flowers = Flower::withCount('transactions')->latest()->paginate(12);
        $totalStock = Flower::sum('stock');
        $lowStockCount = Flower::lowStock()->count(); // pastikan ada scopeLowStock() di model
        $categories = Flower::distinct()->pluck('category');

        // kalau view kamu pakai nama flowerr.blade.php, ubah jadi 'flowers.flowerr'
        return view('flowers.flowerr', compact('flowers', 'totalStock', 'lowStockCount', 'categories'));
    }

    public function create()
    {
        return view('flowers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:flowers|max:50',
            'name' => 'required|max:255',
            'category' => 'required|max:100',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'supplier' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('flowers', 'public');
        }

        Flower::create($validated);

        return redirect()
            ->route('flowers.index')
            ->with('success', 'Data bunga berhasil ditambahkan!');
    }

    public function show(Flower $flower)
    {
        $transactions = $flower->transactions()->latest()->paginate(10);
        return view('flowers.show', compact('flower', 'transactions'));
    }

    public function edit(Flower $flower)
    {
        return view('flowers.edit', compact('flower'));
    }

    public function update(Request $request, Flower $flower)
    {
        $validated = $request->validate([
            'code' => 'required|max:50|unique:flowers,code,' . $flower->id,
            'name' => 'required|max:255',
            'category' => 'required|max:100',
            'price' => 'required|numeric|min:0',
            'supplier' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($flower->image) {
                Storage::disk('public')->delete($flower->image);
            }
            $validated['image'] = $request->file('image')->store('flowers', 'public');
        }

        $flower->update($validated);

        return redirect()
            ->route('flowers.index')
            ->with('success', 'Data bunga berhasil diperbarui!');
    }

    public function destroy(Flower $flower)
    {
        if ($flower->image) {
            Storage::disk('public')->delete($flower->image);
        }

        $flower->delete();

        return redirect()
            ->route('flowers.index')
            ->with('success', 'Data bunga berhasil dihapus!');
    }
}
