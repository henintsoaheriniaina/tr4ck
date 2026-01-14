<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallets = Auth::user()->wallets()->latest()->paginate(12);
        $trashed = Auth::user()->wallets()->onlyTrashed()->latest()->get();
        return view("pages.wallets.index", ["wallets" => $wallets, "trashed" => $trashed]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.wallets.create");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('wallets')->where(fn($query) => $query->where('user_id', Auth::id()))
            ],
            'balance' => 'nullable|numeric|min:0',
        ]);


        Auth::user()->wallets()->create([
            'name' => $validated['name'],
            'balance' => $request->balance ?? 0,
        ]);

        return redirect()->route('wallets.index')->with('success', 'Portefeuille créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet)
    {
        return view("pages.wallets.show");

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wallet $wallet)
    {
        return view("pages.wallets.edit");

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wallet $wallet)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('wallets')
                    ->where(fn($q) => $q->where('user_id', auth()->id()))
                    ->ignore($wallet->id)
            ],
            'balance' => 'required|numeric',
        ]);

        $wallet->update($validated);

        return redirect()->back()->with('success', 'Portefeuille mis à jour !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        $wallet->delete();
        return redirect()->back()->with('success', 'Portefeuille déplacé vers la corbeille.');
    }

    public function restore(int $id)
    {
        $wallet = Wallet::withTrashed()->findOrFail($id);
        $wallet->restore();
        return redirect()->back()->with('success', 'Portefeuille restauré avec succès.');
    }

    public function restoreAll()
    {
        Wallet::onlyTrashed()->restore();
        return redirect()->back()->with('success', 'Tous les portefeuilles ont été restaurés.');
    }

    public function forceDestroy(int $id)
    {
        $wallet = Wallet::withTrashed()->findOrFail($id);
        $wallet->forceDelete();
        return redirect()->back()->with('success', 'Portefeuille supprimé définitivement.');
    }

    public function clearTrash()
    {
        Wallet::onlyTrashed()->forceDelete();
        return redirect()->back()->with('success', 'La corbeille a été vidée.');
    }
}
