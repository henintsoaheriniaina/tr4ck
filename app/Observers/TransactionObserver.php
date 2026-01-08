<?php
namespace App\Observers;

use App\Models\Transaction;
use App\Models\Wallet;

class TransactionObserver
{
    /**
     * Calculer la valeur réelle (positive pour revenu, négative pour dépense)
     */
    private function getTrueAmount(Transaction $transaction): float
    {
        return $transaction->type === 'income' ? $transaction->amount : -$transaction->amount;
    }

    public function created(Transaction $transaction): void
    {
        $transaction->wallet->increment('balance', $this->getTrueAmount($transaction));
    }

    public function updating(Transaction $transaction): void
    {
        // On ne fait rien si les champs financiers n'ont pas changé
        if (!$transaction->isDirty(['amount', 'type', 'wallet_id'])) {
            return;
        }

        // 1. Annuler l'ancienne transaction sur l'ancien portefeuille
        $oldAmount = $transaction->getOriginal('amount');
        $oldType = $transaction->getOriginal('type');
        $oldWalletId = $transaction->getOriginal('wallet_id');

        $oldWallet = Wallet::find($oldWalletId);
        $oldAdjustment = $oldType === 'income' ? -$oldAmount : $oldAmount;
        $oldWallet->increment('balance', $oldAdjustment);

        // 2. Appliquer la nouvelle valeur sur le portefeuille actuel
        // (Le modèle a déjà les nouvelles valeurs mais n'est pas encore en DB)
        $newAdjustment = $this->getTrueAmount($transaction);
        $transaction->wallet->increment('balance', $newAdjustment);
    }

    public function deleted(Transaction $transaction): void
    {
        // Inverser le montant pour restaurer le solde lors de la suppression
        $adjustment = $transaction->type === 'income' ? -$transaction->amount : $transaction->amount;
        $transaction->wallet->increment('balance', $adjustment);
    }
}
