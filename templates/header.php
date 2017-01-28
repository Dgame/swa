<?php /** @var Swa\User\User $user */ ?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SWA - Online Banking</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="bootstrap/css/nav.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <!-- The justified navigation menu is meant for single line per list item.
         Multiple lines will require custom code not provided by Bootstrap. -->
    <?php if (!empty($user)): ?>
    <?php $tab = isset($_GET['q']) ? $_GET['q'] : 'index'; ?>
    <div class="masthead">
        <h3 class="text-muted">SWA - Online Banking</h3>
        <p>Du bist nicht <?= $user->name ?>? <a href="/logout">Logout</a></p>
        <nav>
            <ul class="nav nav-justified">
                <li <?= $tab === 'index' ? 'class="active"' : '' ?>><a href="/index">Home</a></li>
                <li <?= $tab === 'profile' ? 'class="active"' : '' ?>><a href="/profile">Persönliche Daten</a></li>
                <li <?= $tab === 'transfer' ? 'class="active"' : '' ?>><a href="/transfer">Überweisung</a></li>
                <li <?= $tab === 'balance' ? 'class="active"' : '' ?>><a href="/balance">Kontostand</a></li>
            </ul>
        </nav>
    </div>
<?php endif; ?>