# 🌍 Application de Gestion des Déchets - Interface Laravel

Cette application web Laravel permet de gérer différents acteurs et contenus liés à un système de gestion des déchets. Elle interagit avec une **API externe** pour récupérer dynamiquement les données telles que les utilisateurs, agents, ménages, déclarations, quiz et publications.

## 🚀 Fonctionnalités principales

- Authentification et déconnexion
- Visualisation et gestion :
  - des utilisateurs
  - des agents de collecte
  - des ménages
  - des déclarations
  - des quiz (questions interactives)
  - des publications (posts/articles)
- Intégration avec une API externe pour la récupération des données

## 📌 Routes disponibles

### 🔐 Authentification

| Méthode | URI       | Action                        | Nom de route   |
|--------|-----------|-------------------------------|----------------|
| GET    | /logout   | Déconnexion                   | logout         |

---

### 🏠 Tableau de bord

| Méthode | URI     | Action                        | Nom de route   |
|--------|---------|-------------------------------|----------------|
| GET    | /       | Affichage du tableau de bord   | dashboard      |

---

### 👤 Utilisateurs

| Méthode | URI            | Action                     | Nom de route   |
|--------|----------------|----------------------------|----------------|
| GET    | /utilisateurs  | Liste des utilisateurs     | getusers       |

---

### 🚛 Agents de collecte

| Méthode | URI                                           | Action                            | Nom de route    |
|--------|-----------------------------------------------|-----------------------------------|-----------------|
| GET    | /agents-de-collecte                           | Liste des agents                  | agents.index    |
| GET    | /agents-de-collecte/{id}/edit                 | Édition d’un agent                | agents.edit     |
| GET    | /agents-de-collecte/ajouter-nouvel-agent      | Création d’un nouvel agent        | agents.create   |

---

### 🏠 Ménages

| Méthode | URI                              | Action                        | Nom de route      |
|--------|----------------------------------|-------------------------------|-------------------|
| GET    | /menage                          | Liste des ménages             | menages.index     |
| GET    | /menage/{id}/edit                | Édition d’un ménage           | menages.edit      |
| GET    | /menage/ajouter-menage           | Création d’un nouveau ménage  | menages.create    |

---

### 📝 Déclarations

| Méthode | URI             | Action                   | Nom de route     |
|--------|-----------------|--------------------------|------------------|
| GET    | /declarations   | Liste des déclarations   | getsubmissions   |

---

### ❓ Quiz interactifs

| Méthode | URI                   | Action                            | Nom de route     |
|--------|-----------------------|-----------------------------------|------------------|
| GET    | /quizzes              | Liste des quizzes                 | quizzes.index    |
| GET    | /quizzes/create       | Création d’un nouveau quiz        | quizzes.create   |
| GET    | /quizzes/{id}/edit    | Édition d’un quiz existant        | quizzes.edit     |

---

### 📰 Publications (Posts)

| Méthode | URI                   | Action                              | Nom de route     |
|--------|-----------------------|-------------------------------------|------------------|
| GET    | /posts                | Liste des publications              | posts.index      |
| GET    | /posts/create         | Création d’un nouvel article        | posts.create     |
| GET    | /posts/{id}/edit      | Édition d’un article existant       | posts.edit       |

---

## 🔗 Intégration avec l’API externe

Toutes les données listées ci-dessus sont **consommées depuis une API externe**, ce qui signifie que cette application joue un rôle d’interface d'administration pour les données distantes. Cela garantit une mise à jour continue des informations et une centralisation de la gestion.

## 🛠️ Technologies utilisées

- Laravel 10+
- Blade / Livewire
- Bootstrap 5
- API REST externe (via contrôleurs Laravel)

---

## 🧑‍💻 Déploiement local

```bash
git clone https://github.com/ton-utilisateur/ton-projet.git
cd ton-projet
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
