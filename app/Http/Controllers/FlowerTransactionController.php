<?php

namespace App\Http\Controllers;

use App\Models\Flower;
use App\Models\FlowerTransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FlowerTransactionController extends Controller
{
    public function index()
    {
        $transactions = FlowerTransaction::with('flower')->latest()->paginate(15);
        $todayIn = FlowerTransaction::where('type', 'masuk')->whereDate('transaction_date', Carbon::today())->sum('quantity');
        $todayOut = FlowerTransaction::where('type', 'keluar')->whereDate('transaction_date', Carbon::today())->sum('quantity');
        
        return view('transactions.index', compact('transactions', 'todayIn', 'todayOut'));
    }

    public function create()
    {
        $flowers = Flower::orderBy('name')->get();
        return view('transactions.create', compact('flowers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'flower_id' => 'required|exists:flowers,id',
            'type' => 'required|in:masuk,keluar',
            'quantity' => 'required|integer|min:1',
            'reference_number' => 'required|max:100',
            'transaction_date' => 'required|date',
            'source_destination' => 'required|max:255',
            'notes' => 'nullable',
            'handled_by' => 'required|max:100'
        ]);

        $flower = Flower::findOrFail($validated['flower_id']);

        if ($validated['type'] == 'keluar') {
            if ($flower->stock < $validated['quantity']) {
                return back()->withErrors(['quantity' => 'Stok tidak mencukupi! Stok tersedia: ' . $flower->stock])
                    ->withInput();
            }
            $flower->decrement('stock', $validated['quantity']);
        } else {
            $flower->increment('stock', $validated['quantity']);
        }

        FlowerTransaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dicatat!');
    }

    public function show(FlowerTransaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    public function destroy(FlowerTransaction $transaction)
    {
        $flower = $transaction->flower;
        if ($transaction->type == 'masuk') {
            $flower->decrement('stock', $transaction->quantity);
        } else {
            $flower->increment('stock', $transaction->quantity);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan!');
    }
}