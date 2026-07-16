<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Erreur de navigation</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f8d7da; color: #721c24; padding: 50px; }
        .error-container { background: white; padding: 30px; border-radius: 8px; display: inline-block; max-width: 500px; margin: 0 auto; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        a { color: #0056b3; font-weight: bold; text-decoration: none; }
    </style>
</head>
<body>
    <div class="error-container">
        <h2>Une anomalie est survenue</h2>
        <p><?php echo htmlspecialchars($messageErreur); ?></p>
        <p><a href="index.php">Retourner à l'accueil sécurisé</a></p>
    </div>
</body>
</html>