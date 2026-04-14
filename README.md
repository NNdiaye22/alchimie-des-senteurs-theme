# Alchimie des Senteurs — Theme WordPress

Theme WordPress premium pour boutique d'encens, compatible WooCommerce. Design blanc epure avec animation scroll-driven sur canvas.

---

## Prerequis

- WordPress **6.0** minimum
- PHP **8.0** minimum
- Plugin **WooCommerce** installe et active
- Un hebergeur supportant PHP (LocalWP, XAMPP, o2switch, OVH, Infomaniak...)

---

## Installation

### 1. Telecharger le theme

- Sur GitHub : bouton **Code > Download ZIP**
- Ou cloner le depot :
  ```bash
  git clone https://github.com/NNdiaye22/alchimie-des-senteurs-theme.git
  ```

### 2. Installer WooCommerce

Dans WordPress : **Extensions > Ajouter > rechercher WooCommerce > Installer > Activer**

### 3. Televerser et activer le theme

1. **Apparence > Themes > Ajouter > Televerser un theme**
2. Choisir le fichier ZIP telecharge
3. Cliquer **Installer maintenant**
4. Cliquer **Activer**

### 4. Configurer la page d'accueil

1. **Reglages > Lecture**
2. Selectionner **Une page statique**
3. Page d'accueil > **Accueil**
4. Page des articles > **Blog** *(optionnel)*

### 5. Configurer la boutique WooCommerce

1. **WooCommerce > Reglages > Onglet Avance**
2. Page de la boutique > **Boutique**
3. Page panier > **Panier**
4. Page commande > **Commander**
5. Page mon compte > **Mon compte**

### 6. Importer le contenu de demonstration *(optionnel)*

1. **Outils > Importer > WordPress > Installer maintenant**
2. Lancer l'importateur
3. Televerser le fichier `demo-content/alchimie-demo-content.xml`
4. Assigner l'auteur a ton compte admin
5. Cocher **Telecharger et importer les fichiers joints**
6. Cliquer **Valider**

> Le fichier XML pre-remplit : 8 pages, 6 produits WooCommerce, 2 categories, 2 articles de blog et 4 menus.

### 7. Configurer les menus

1. **Apparence > Menus**
2. Creer ou assigner les menus aux emplacements :
   - **Menu Principal** -> navigation principale
   - **Footer - Collection** -> colonne 2 du footer
   - **Footer - Boutique** -> colonne 3 du footer
   - **Footer - Aide** -> colonne 4 du footer

### 8. Personnaliser le theme

Dans **Apparence > Personnaliser** :

| Option | Description |
|--------|-------------|
| Logo | Televerser ton logo (PNG transparent recommande) |
| Footer - Presentation | Texte de description boutique |
| Footer - WhatsApp | Lien WhatsApp (ex: `https://wa.me/221XXXXXXXX`) |
| Footer - Instagram | URL Instagram |
| Footer - Facebook | URL Facebook |
| Footer - Copyright | Texte copyright |
| Footer - Moyens de paiement | Liste separee par virgules (ex: `Orange Money,Wave,Carte`) |
| Nb produits en vitrine | Nombre de produits affiches sur la homepage |

### 9. Configurer les widgets du footer *(optionnel)*

**Apparence > Widgets** -> 4 zones disponibles pour personnaliser chaque colonne du footer.

---

## Structure des fichiers

```
alchimie-des-senteurs-theme/
|-- assets/
|   |-- css/
|   |   |-- main.css            <- styles principaux + responsive
|   |   `-- woocommerce.css     <- styles WooCommerce
|   `-- js/
|       |-- canvas.js           <- animation encens scroll-driven (homepage)
|       `-- main.js             <- burger menu, compteur panier AJAX
|-- demo-content/
|   `-- alchimie-demo-content.xml  <- contenu de demonstration importable
|-- inc/
|   |-- customizer.php          <- options Personnaliser
|   |-- enqueue.php             <- chargement assets CSS/JS
|   `-- woocommerce.php         <- hooks et filtres WooCommerce
|-- template-parts/
|   |-- hero.php                <- section canvas anime
|   |-- quote.php               <- citation
|   |-- collection.php          <- grille produits homepage
|   |-- featured-product.php    <- produit mis en avant
|   |-- philosophy.php          <- section philosophie
|   `-- newsletter.php          <- formulaire newsletter
|-- woocommerce/
|   |-- archive-product.php     <- page boutique
|   |-- single-product.php      <- page produit
|   `-- content-product.php     <- carte produit dans la boucle
|-- 404.php
|-- footer.php
|-- front-page.php              <- template page d'accueil
|-- functions.php               <- point d'entree principal
|-- header.php
|-- index.php
|-- page.php
|-- screenshot.png              <- apercu dans Apparence > Themes (1200x900px)
|-- single.php
`-- style.css                   <- en-tete obligatoire WordPress
```

---

## Multilingue

Le theme est entierement prepare pour la traduction (`__()`, `esc_html_e()`, textdomain `alchimie-des-senteurs`).
Pour ajouter une langue, installer **Polylang** (gratuit) ou **WPML** (payant).

---

## Plugins recommandes

| Plugin | Utilite |
|--------|---------|
| WooCommerce | Boutique en ligne (obligatoire) |
| Polylang | Multilingue (optionnel) |
| WPForms Lite | Formulaire de contact |
| Mailchimp for WooCommerce | Newsletter |
| Yoast SEO | Referencement |

---

## Personnalisation avancee

- **Couleurs** : modifier les variables CSS dans `assets/css/main.css` -> bloc `:root { }` en debut de fichier
- **Police** : modifier `font-family` dans le `body` dans `main.css`
- **Produits homepage** : configurer via **Apparence > Personnaliser > Nb produits en vitrine**
- **Screenshot** : remplacer `screenshot.png` par une image **1200x900px**

---

*Theme cree par **BUUR DIGITAL***
