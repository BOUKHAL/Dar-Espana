<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dar España by Capstone - Votre Passerelle vers l'Université Espagnole</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-red: #c60d1e;
            --primary-yellow: #ffca26;
            --dark-red: #a00b1a;
            --light-yellow: #fff3a0;
            --white: #ffffff;
            --gray-100: #f8f9fa;
            --gray-800: #343a40;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--gray-800);
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--dark-red) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><circle cx="200" cy="200" r="100" fill="%23ffca26" opacity="0.1"/><circle cx="800" cy="300" r="150" fill="%23ffca26" opacity="0.05"/><circle cx="400" cy="700" r="80" fill="%23ffca26" opacity="0.1"/></svg>') no-repeat center center;
            background-size: cover;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-text .highlight {
            color: var(--primary-yellow);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-text p {
            font-size: 1.3rem;
            color: var(--white);
            margin-bottom: 30px;
            opacity: 0.95;
            line-height: 1.8;
        }

        .cta-button {
            display: inline-block;
            background: var(--primary-yellow);
            color: var(--gray-800);
            padding: 15px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(255, 202, 38, 0.3);
        }

        .cta-button:hover {
            background: var(--light-yellow);
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(255, 202, 38, 0.4);
        }

        .hero-visual {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .visual-card {
            background: var(--white);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 400px;
            transform: rotate(-2deg);
            transition: all 0.3s ease;
        }

        .visual-card:hover {
            transform: rotate(0deg) scale(1.05);
        }

        .visual-card h3 {
            color: var(--primary-red);
            font-size: 1.8rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .visual-card .stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 30px 0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-yellow);
            display: block;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--gray-800);
            margin-top: 5px;
        }

        .features-section {
            padding: 80px 0;
            background: var(--gray-100);
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            color: var(--primary-red);
            margin-bottom: 20px;
            font-weight: 700;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: var(--gray-800);
            margin-bottom: 60px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .feature-card {
            background: var(--white);
            padding: 40px 30px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border-top: 4px solid var(--primary-yellow);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: var(--white);
        }

        .feature-card h4 {
            font-size: 1.4rem;
            color: var(--primary-red);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .feature-card p {
            color: var(--gray-800);
            line-height: 1.6;
        }

        .footer {
            background: var(--gray-800);
            color: var(--white);
            text-align: center;
            padding: 40px 0;
        }

        .footer p {
            margin-bottom: 10px;
        }

        .footer .highlight {
            color: var(--primary-yellow);
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .hero-content {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }

            .hero-text p {
                font-size: 1.1rem;
            }

            .visual-card {
                transform: none;
                max-width: 100%;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>
                        <span class="highlight">Dar España</span><br>
                        by Capstone
                    </h1>
                    <p>
                        La référence au Maroc pour la préparation à la Selectividad, 
                        l'orientation académique et l'accompagnement administratif des 
                        étudiants souhaitant intégrer les universités publiques espagnoles.
                    </p>
                    <a href="{{ route('login') }}" class="cta-button">
                        Connexion
                    </a>
                </div>
                <div class="hero-visual">
                    <div class="visual-card">
                        <h3>Excellence Académique</h3>
                        <div class="stats">
                            <div class="stat-item">
                                <span class="stat-number">100%</span>
                                <div class="stat-label">Taux de Réussite</div>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">9000+</span>
                                <div class="stat-label">Étudiants Formés</div>
                            </div>
                        </div>
                        <p>Expertise reconnue et partenariats solides avec les universités espagnoles</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title">Nos Services</h2>
            <p class="section-subtitle">
                Une formation complète et adaptée à chaque filière, assurant à nos étudiants 
                les meilleures conditions pour réussir leur projet académique.
            </p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📚</div>
                    <h4>Préparation Selectividad</h4>
                    <p>Formation intensive et personnalisée pour maximiser vos chances de réussite aux examens d'entrée universitaires espagnols.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h4>Orientation Académique</h4>
                    <p>Conseils personnalisés pour choisir la filière et l'université qui correspondent le mieux à vos aspirations et compétences.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">📋</div>
                    <h4>Accompagnement Administratif</h4>
                    <p>Support complet pour toutes les démarches administratives nécessaires à votre inscription dans les universités espagnoles.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🤝</div>
                    <h4>Partenariats Universitaires</h4>
                    <p>Relations privilégiées avec les universités publiques espagnoles pour faciliter votre intégration académique.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🏆</div>
                    <h4>Expertise Reconnue</h4>
                    <p>Équipe pédagogique expérimentée avec un track record prouvé de réussite des étudiants marocains en Espagne.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🌟</div>
                    <h4>Suivi Personnalisé</h4>
                    <p>Accompagnement individualisé tout au long de votre parcours, de la préparation jusqu'à votre intégration universitaire.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 <span class="highlight">Dar España by Capstone</span> - Tous droits réservés</p>
            <p>Votre passerelle vers l'excellence académique en Espagne</p>
        </div>
    </footer>
</body>
</html>