<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query()
            ->whereHas('wallet', fn($q) => $q->where('user_id', auth()->id()))
            ->with(['wallet', 'tags']);

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        $transactions = $query->latest()->with(['wallet', 'tags'])->paginate(15)
        ;

        $wallets = auth()->user()->wallets()->get();
        $tags = auth()->user()->tags()->pluck('name');

        return view('pages.transactions.index', compact('transactions', 'wallets', 'tags'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wallet_id' => [
                'required',
                Rule::exists('wallets', 'id')->where(fn($q) => $q->where('user_id', auth()->id())),
            ],
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'happened_at' => 'nullable|date|before_or_equal:now',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:30',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            $transaction = Transaction::create([
                'wallet_id' => $validated['wallet_id'],
                'description' => $validated['description'],
                'amount' => $validated['amount'],
                'type' => $validated['type'],
                'happened_at' => $validated['happened_at'] ?? now(),
            ]);
            if (!empty($validated['tags'])) {
                $tagIds = collect($validated['tags'])->map(function ($tagName) {
                    return Tag::firstOrCreate(
                        [
                            'name' => trim($tagName),
                            'user_id' => auth()->id()
                        ],
                        ['color' => 'primary']
                    )->id;
                });
                $transaction->tags()->attach($tagIds);
            }
            return redirect()->back()->with('success', 'Transaction enregistrée avec succès !');
        });
    }

    public function update(Request $request, Transaction $transaction)
    {

        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'happened_at' => 'required|date',
            'tags' => 'nullable|array',
        ]);

        DB::transaction(function () use ($validated, $request, $transaction) {
            $transaction->update($validated);
            if ($request->has('tags')) {
                $tagIds = collect($validated['tags'])->map(function ($tagName) {
                    return Tag::firstOrCreate(
                        ['name' => trim($tagName), 'user_id' => auth()->id()],
                        ['color' => 'primary']
                    )->id;
                });
                $transaction->tags()->sync($tagIds);
            }
        });

        return back()->with('success', 'Transaction mise à jour !');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return back()->with('success', 'Transaction supprimée (archivée).');
    }
}
