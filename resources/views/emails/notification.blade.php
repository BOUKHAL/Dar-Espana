<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $notification->titre }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #c60d1e 0%, #a00d1a 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .logo {
            width: 120px;
            height: auto;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #c60d1e;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .notification-title {
            background-color: #ffca26;
            color: #333;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: 600;
            font-size: 18px;
            border-left: 4px solid #c60d1e;
        }
        .message {
            font-size: 16px;
            line-height: 1.8;
            margin: 20px 0;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #ffca26;
        }
        .student-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .student-info h3 {
            color: #c60d1e;
            margin: 0 0 10px 0;
            font-size: 16px;
        }
        .student-info p {
            margin: 5px 0;
            font-size: 14px;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .footer p {
            margin: 5px 0;
            font-size: 14px;
        }
        .footer .highlight {
            color: #ffca26;
            font-weight: 600;
        }
        .divider {
            height: 2px;
            background: linear-gradient(90deg, #c60d1e, #ffca26);
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Dar España by Capstone</h1>
            <p>Votre passerelle vers l'excellence académique</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Bonjour {{ $etudiant->prenom }} {{ $etudiant->nom }},
            </div>

            <div class="notification-title">
                📢 {{ $notification->titre }}
            </div>

            <div class="message">
                {!! nl2br(e($notification->message)) !!}
            </div>

            <div class="divider"></div>

            <div class="student-info">
                <h3>📋 Vos informations :</h3>
                <p><strong>Centre :</strong> {{ $etudiant->centre->nom }}</p>
                <p><strong>Option :</strong> {{ $etudiant->option->nom }}</p>
                <p><strong>Filière :</strong> {{ $etudiant->filiere->nom }}</p>
                <p><strong>Email :</strong> {{ $etudiant->email }}</p>
            </div>

            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                Si vous avez des questions, n'hésitez pas à nous contacter ou à vous connecter à votre espace étudiant.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2025 <span class="highlight">Dar España by Capstone</span></p>
            <p>Tous droits réservés</p>
            <p style="margin-top: 15px; font-size: 12px; opacity: 0.8;">
                Cet email a été envoyé le {{ $notification->envoye_le ? $notification->envoye_le->format('d/m/Y à H:i') : now()->format('d/m/Y à H:i') }}
            </p>
        </div>
    </div>
</body>
</html>
