<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\WalletStatus;
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
        $wallets = Auth::user()->wallets()->latest()->paginate(10);
        $statuses = WalletStatus::all();
        return view("pages.wallets.index", ["wallets" => $wallets, "statuses" => $statuses]);
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
        $activeStatus = WalletStatus::where('value', 'active')->first();

        Auth::user()->wallets()->create([
            'name' => $validated['name'],
            'balance' => $request->balance ?? 0,
            'wallet_status_id' => $activeStatus->id,
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
    public function updateStatus(Request $request, Wallet $wallet)
    {
        $validated = $request->validate([
            'status' => 'required|exists:wallet_statuses,value',
        ]);


        $status = WalletStatus::where('value', $validated['status'])->firstOrFail();

        $wallet->update([
            'wallet_status_id' => $status->id
        ]);

        return redirect()->route('wallets.index')->with('success', "Le statut du portefeuille '{$wallet->name}' est désormais : {$status->label}.");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        $wallet->delete();

        return redirect()->back()->with('success', 'Portefeuille déplacé vers la corbeille.');
    }
}
