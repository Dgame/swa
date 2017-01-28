<?php /** @var Swa\User\User $user */
use Swa\User\User; ?>
<div class="well well-sm">
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <h3>Überweisung tätigen</h3>
            <form action="/transfer/<?= $user->id ?>" method="post">
                <div class="form-group">
                    <label for="amount">Betrag:</label>
                    <input type="number" name="amount" value="" id="amount" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="too">An:</label>
                    <select name="too" id="too" class="form-control">
                        <option> ---- Bitte auswählen ----</option>
                        <?php foreach ($user->other() as $person): ?>
                            <option value="<?= $person->id ?>"><?= $person->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-default alert alert-danger">Überweisen</button>
            </form>
        </div>
    </div>
</div>