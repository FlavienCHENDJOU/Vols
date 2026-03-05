<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AéroFlight - Réservez votre prochain voyage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link type="text/css" rel="stylesheet" href="{{asset('css/homestyle.css')}}" />
</head>
<body>

    <nav class="top-nav">
        <div class="logo">AéroFlight <i class="fas fa-plane"></i></div>
        <div class="nav-links d-none-mobile">
            <a href="{{ url('connexion') }}">Vols</a>
            <a href="{{ url('connexion') }}">Hotels</a>
            <a href="{{ url('connexion') }}">Sites</a>
        </div>
        <div class="nav-auth">
            <a href="{{ url('connexion') }}" class="btn-login">Connexion</a>
            <a href="{{ url('accueil') }}" class="btn-signup">S'inscrire</a>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <h1 class="main-title">Où allez-vous <span class="highlight">ensuite ?</span></h1>
            <p class="sub-title">Explorez le monde avec des tarifs imbattables et un service premium.</p>

            <div class="search-container">
                <form action="{{ url('/vols') }}" method="GET">
                    <div class="trip-type">
                        <label><input type="radio" name="trip" checked> <span>Aller-retour</span></label>
                        <label><input type="radio" name="trip"> <span>Aller simple</span></label>
                    </div>

                    <div class="search-bar">
                        <div class="input-group">
                            <i class="fas fa-plane-departure"></i>
                            <input type="text" name="depart" placeholder="De (Ex: Paris)">
                        </div>
                        <div class="input-group">
                            <i class="fas fa-plane-arrival"></i>
                            <input type="text" name="destination"  placeholder="À (Ex: Douala)">
                        </div>
                        <div class="input-group">
                            <i class="far fa-calendar"></i>
                            <input type="text" onfocus="(this.type='date')" name="date" placeholder="Date de départ">
                        </div>
                        <div class="input-group">
                            <i class="fas fa-user"></i>
                            <select name="classe" >
                                <option value="economique">Toutes les classes</option>
                                <option value="economique">Économique</option>
                                <option value="business">Business</option>
                                <option value="premiere">Première</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-search-main">
                            <i class="fas fa-search"></i> Rechercher les vols
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </header>

    <section class="destination-grid" style=" padding: 3% 5% 1% 5%;">
        <div class="feature-item">
            <i class="fas fa-shield-alt"></i>
            <h3>Pas de frais cachés</h3>
            <p>Ce que vous voyez est ce que vous payez.</p>
        </div>
        <div class="feature-item">
            <i class="fas fa-headset"></i>
            <h3>Support 24/7</h3>
            <p>Notre équipe est là pour vous aider à chaque étape.</p>
        </div>
        <div class="feature-item">
            <i class="fas fa-calendar-check"></i>
            <h3>Réservation Flexible</h3>
            <p>Modifiez vos dates sans stress.</p>
        </div>
    </section>

    <section class="destinations">
        <h2 class="section-title">Destinations Populaires</h2>
        <div class="destination-grid">
            <div class="dest-card">
                <img src="img/amerique.jpeg" alt="Amérique">
                <div class="dest-info">
                    <h3>Amérique</h3>
                    <p>À partir de 499€</p>
                    <a href="{{ url('connexion') }}" class="btn-book">Réserver</a>
                </div>
            </div>
            <div class="dest-card">
                <img src="img/afrique.jpeg" alt="Afrique">
                <div class="dest-info">
                    <h3>Afrique</h3>
                    <p>À partir de 320€</p>
                    <a href="{{ url('connexion') }}" class="btn-book">Réserver</a>
                </div>
            </div>
            <div class="dest-card">
                <img src="img/europe.jpg" alt="Europe">
                <div class="dest-info">
                    <h3>Europe</h3>
                    <p>À partir de 150€</p>
                    <a href="{{ url('connexion') }}" class="btn-book">Réserver</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="main-footer">
        <p>&copy; 2026 AéroFlight. </p>
    </footer>

</body>
</html>

