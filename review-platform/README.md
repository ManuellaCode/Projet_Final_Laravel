# Review Platform - Backend API

API REST pour l'analyse automatique d'avis clients avec IA.

## 🚀 Installation
```bash
# Cloner le repo
git clone https://github.com/votre-username/review-platform.git
cd review-platform

# Installer les dépendances
composer install

# Copier .env
cp .env.example .env

# Générer la clé
php artisan key:generate

# Créer la base de données SQLite
touch database/database.sqlite

# Configurer .env (DB_CONNECTION=sqlite)

# Lancer les migrations
php artisan migrate

# (Optionnel) Créer des données de test
php artisan db:seed

# Démarrer le serveur
php artisan serve
```

## 📚 API Endpoints

### Authentification
- `POST /api/register` - Inscription
- `POST /api/login` - Connexion
- `POST /api/logout` - Déconnexion (auth required)
- `GET /api/user` - Profil utilisateur (auth required)

### Reviews
- `GET /api/reviews` - Liste des avis (auth required)
- `POST /api/reviews` - Créer un avis (auth required)
- `GET /api/reviews/{id}` - Détail d'un avis (auth required)
- `PUT /api/reviews/{id}` - Modifier un avis (auth required)
- `DELETE /api/reviews/{id}` - Supprimer un avis (auth required)

### Analyse IA
- `POST /api/analyze` - Analyser un texte (auth required)

### Dashboard
- `GET /api/dashboard` - Statistiques (auth required)

## 🧪 Credentials de test

- **Admin** : `admin@example.com` / `password123`
- **User** : `user@example.com` / `password123`

## 🛠️ Technologies

- Laravel 12
- PHP 8.2+
- SQLite
- Laravel Sanctum (API authentication)

## 👥 Équipe

- **Personne 1** : Backend Core + Chef de projet ✅
- **Personne 2** : Authentification
- **Personne 3** : CRUD Reviews + Module IA
- **Personne 4** : Dashboard & Statistiques
- **Personne 5** : Frontend Vue 3

## 📝 Documentation

Import `postman_collection.json` dans Postman pour tester l'API.

## 🔗 Structure du projet
```
review-platform/
├── app/
│   ├── Http/Controllers/Api/
│   │   ├── AuthController.php (à implémenter)
│   │   ├── ReviewController.php (à implémenter)
│   │   ├── AnalysisController.php (à implémenter)
│   │   └── DashboardController.php (à implémenter)
│   ├── Models/
│   │   ├── User.php ✅
│   │   └── Review.php ✅
│   └── Services/
│       └── SentimentAnalysisService.php (à implémenter)
├── database/
│   ├── migrations/ ✅
│   └── seeders/
│       └── DatabaseSeeder.php ✅
├── routes/
│   └── api.php ✅
└── README.md
```

## 🚀 Prochaines étapes

1. **Personne 2** : Implémenter AuthController (register, login, logout)
2. **Personne 3** : Implémenter ReviewController (CRUD) + Service IA
3. **Personne 4** : Implémenter DashboardController (statistiques)
4. **Personne 5** : Créer les composants Vue et intégrer l'API