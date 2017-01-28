<?php /** @var Swa\User\User $user */ ?>
<div class="well well-sm">
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <img src="http://placehold.it/380x500" alt="" class="img-rounded img-responsive"/>
        </div>

        <div class="col-sm-6 col-md-8">
            <h4><?= $user->name ?></h4>
            <small><cite title="<?= $user->address->location ?>"><?= $user->address->plz ?> <?= $user->address->location ?>
                    <i class="glyphicon glyphicon-map-marker"></i></cite></small>
            <p>
                <i class="glyphicon glyphicon-envelope"></i><?= $user->email ?>
                <br/>
                <i class="glyphicon glyphicon-phone"></i><?= $user->telephone ?>
                <br/>
                <i class="glyphicon glyphicon-gift"></i><?= $user->birthdate->format('d.m.Y') ?>
            </p>
        </div>

        <div class="col-sm-6 col-md-6">
            <h3>Persönliche Daten ändern</h3>
            <form action="/profile/<?= $user->id ?>" method="post">
                <div class="form-group">
                    <label for="birthday">Geburtsdatum:</label>
                    <input type="date" name="birthdate" class="form-control" id="birthday"
                           value="<?= $user->birthdate->format('Y-m-d') ?>"/>
                </div>
                <div class="form-group">
                    <label for="location">Wohnort:</label>
                    <input type="text" name="location" class="form-control" id="location"
                           value="<?= $user->address->location ?>"/>
                </div>
                <div class="form-group">
                    <label for="email">E-Mail:</label>
                    <input type="email" name="email" class="form-control" id="email" value="<?= $user->email ?>"/>
                </div>
                <div class="form-group">
                    <label for="tel">Telefon:</label>
                    <input type="tel" name="tel" class="form-control" id="tel" value="<?= $user->telephone ?>"/>
                </div>
                <div class="form-group">
                    <label for="blz">Bankleitzahl:</label>
                    <input type="number" name="blz" class="form-control" id="blz" value="<?= $user->bankAccount->bankleitzahl ?>"
                           maxlength="15"/>
                </div>
                <div class="form-group">
                    <label for="ktnr">Kontonummer:</label>
                    <input type="number" name="ktnr" class="form-control" id="ktnr"
                           value="<?= $user->bankAccount->kontonummer ?>" maxlength="15"/>
                </div>
                <button type="submit" class="btn btn-default">Absenden</button>
            </form>
        </div>
    </div>

    <br />
    <br />

    <div class="row">
        <div class="col-sm-6 col-md-4"></div>
        <div class="col-sm-6 col-md-6 alert alert-danger">
            <h4>Passwort ändern</h4>
            <form action="/profile/pw/<?= $user->id ?>" method="post">
                <div class="form-group">
                    <label for="pwd">Altes Passwort:</label>
                    <input type="password" name="old_password" class="form-control" id="pwd" value=""/>
                </div>
                <div class="form-group">
                    <label for="pwd">Neues Passwort:</label>
                    <input type="password" name="new_password" class="form-control" id="pwd" value=""/>
                </div>
                <button type="submit" class="btn btn-default">Passwort ändern</button>
            </form>
        </div>
    </div>
</div>
