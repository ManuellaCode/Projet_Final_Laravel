# 🔄 Guide Git - Review Platform (SIMPLE)

## 👥 Répartition des branches

| Personne        |Branche(s)                                      | Rôle                              |
|-----------------|------------------------------------------------|-----------------------------------|
| Personne 1(moi) | `main`                                         | Chef de projet + Backend Core     |
| Personne 2      | `feature/auth`                                 | Authentification (login/register) |
| Personne 3      | `feature/crud-reviews` + `feature/ia-analysis` | CRUD des avis + Module IA         |
| Personne 4      | `feature/dashboard`                            | Statistiques et Dashboard         |
| Personne 5      | `feature/frontend`                             | Interface Vue 3                   |

---

## 🚀 ÉTAPE 1 : Récupérer le projet

Chaque membre fait ceci **UNE SEULE FOIS** :

```bash
# 1. Télécharger le projet
git clone  https://github.com/ManuellaCode/Projet_Final_Laravel.git

# 2. Entrer dans le dossier
cd review-platform

# 3. Installer Laravel
composer install

# 4. Configurer l'environnement
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan db:seed

# 5. Aller sur TA branche (selon qui tu es)
git checkout feature/auth          # Si tu es Personne 2
git checkout feature/crud-reviews  # Si tu es Personne 3 (commence par ça et après ia-analysis)
git checkout feature/dashboard     # Si tu es Personne 4
git checkout feature/frontend      # Si tu es Personne 5
```

---

## 💻 ÉTAPE 2 : Travailler sur ton code (sur le terinal gitbash)

```bash
# Faire tes modifications dans VS Code...
# Créer tes fichiers, coder, tester...

# Une fois que ça marche, sauvegarder :
git add .
git commit -m "Description de ce que tu as fait"

# Exemples de messages :
# "feat: add login endpoint"
# "feat: create ReviewController"
# "fix: correct validation bug"
# "docs: update README"
```

---

## 📤 ÉTAPE 3 : Envoyer ton travail sur GitHub (sur le terinal gitbash)

```bash
# Envoyer ton code sur GitHub
git push origin feature/TON-NOM-DE-BRANCHE

# Exemples :
git push origin feature/auth
git push origin feature/crud-reviews
```

---

## 🔀 ÉTAPE 4 : Intégrer ton travail dans le projet principal

### **Option A : Via l'interface GitHub (PLUS SIMPLE)**

1. **Va sur le site GitHub** : `https://github.com/VOTRE-USERNAME/review-platform`

2. **Tu verras un message jaune** qui dit :
   ```
   feature/auth had recent pushes
   [Compare & pull request]
   ```
   → **Clique sur le bouton vert "Compare & pull request"**

3. **Remplis le formulaire** :
   - Titre : "Ajout de l'authentification" (par exemple)
   - Description : Explique ce que tu as fait
   - **IMPORTANT** : Vérifie que c'est bien `feature/auth` → `main`

4. **Clique sur "Create pull request"**

5. **Envoie un message à Personne 1** : "J'ai créé ma Pull Request, tu peux vérifier ?"

6. **Personne 1 va :**
   - Regarder ton code
   - Tester que ça marche
   - Cliquer sur "Merge pull request" si tout est OK

---

### **Option B : Via le terminal (SI TU ES À L'AISE)**

```bash
# Sur GitHub, va dans ton repo et crée manuellement une Pull Request
# Ou demande à Personne 1 de merger directement
```

---

## 🔄 ÉTAPE 5 : Récupérer le travail des autres

Quand les autres ont fini leur travail et que c'est mergé dans `main`, tu peux récupérer leurs changements :

```bash
# Aller sur main
git checkout main

# Télécharger les nouveautés
git pull origin main

# Retourner sur ta branche
git checkout feature/TON-NOM-DE-BRANCHE

# Intégrer les nouveautés dans ta branche
git merge main

# Si il y a des conflits, demande de l'aide à Personne 1 !
```

---

## ⚠️ Règles d'OR

### ✅ À FAIRE :
- Travailler sur TA branche uniquement
- Faire des commits réguliers (toutes les 30 min / 1h)
- Messages de commit clairs en français
- Tester ton code avant de push
- Demander de l'aide si tu es bloqué

### ❌ À NE JAMAIS FAIRE :
- Travailler directement sur `main`
- Faire `git push origin main` (sauf Personne 1)
- Supprimer le travail des autres
- Oublier de `git pull` avant de commencer

---

## 🆘 Aide rapide

### "Je suis perdu, je suis sur quelle branche ?"
```bash
git branch
# L'étoile * montre où tu es
```

### "J'ai fait une erreur, je veux annuler"
```bash
# Annuler les dernières modifications (avant commit)
git checkout .

# Demande à Personne 1 pour les cas plus complexes !
```

### "Ça dit 'conflict', je fais quoi ?"
→ **Appelle Personne 1 immédiatement !** Ne touche à rien.

---

## 📞 Contact

Manuella

**Besoin d'aide Git ?** → Demande à Personne 1
**Besoin d'aide code ?** → Demande dans le groupe

---

**Personne 1 valide tous les merges !**

---

## 🎯 Résumé en 5 étapes

1. **Clone** le projet → `git clone ...`
2. **Checkout** ta branche → `git checkout feature/...`
3. **Code** et teste
4. **Commit + Push** → `git add . && git commit -m "..." && git push`
5. **Pull Request** sur GitHub → Demande à Personne 1 de merger

**C'est tout ! 🎉**