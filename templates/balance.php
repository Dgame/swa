<?php /** @var Swa\User\User $user */
use Swa\User\Transfer; ?>
<div class="well well-sm">
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <h4>Hallo <?= $user->name ?></h4>
            <br />
            <?php
            $class = '';
            if ($user->bankAccount->balance > 0) {
                $class = 'alert-success';
            } else if ($user->bankAccount->balance < 0) {
                $class = 'alert-danger';
            }
            ?>
            <p>Ihr Kontostand beträgt <span class="alert <?= $class ?>"><?= number_format($user->bankAccount->balance, 0, '.', '.') ?> €</span></p>
        </div>
        <div class="col-sm-6 col-md-6">
            <h4>Ihre letzten getätigten Überweisungen</h4>
            <ol>
                <?php $transfer = new Transfer($user); ?>
                <?php foreach ($transfer->getTransfersFrom() as $transaction): ?>
                    <li>Sie haben <b><?= $transaction->user->name ?></b> am <?= $transaction->date->format('d.m.Y') ?> um <?= $transaction->date->format('H:i:s') ?> <b><?= number_format($transaction->amount, 0, '.', '.') ?></b> € überwiesen</li>
                <?php endforeach; ?>
            </ol>

            <h4>Ihre letzten emfpangenen Überweisungen</h4>
            <ol>
                <?php foreach ($transfer->getTransfersToo() as $transaction): ?>
                    <li><b><?= $transaction->user->name ?></b> hat Ihnen am <?= $transaction->date->format('d.m.Y') ?> um <?= $transaction->date->format('H:i:s') ?> <b><?= number_format($transaction->amount, 0, '.', '.') ?></b> € überwiesen</li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</div>