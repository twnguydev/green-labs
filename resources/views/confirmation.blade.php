<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email de confirmation</title>
</head>
<body>
    <h1>Bienvenue sur GreenLabs !</h1>
    <p>Merci de vous être inscrit sur notre plateforme.</p>
    <p>Veuillez cliquer sur le lien ci-dessous pour confirmer votre compte :</p>
    <a href="{{ url('/confirm/' . $user->confirmation_token) }}">Confirmer mon compte</a>
</body>
</html>