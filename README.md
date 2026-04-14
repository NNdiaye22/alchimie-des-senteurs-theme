# Alchimie des Senteurs — Theme WordPress

Theme WordPress premium, compatible WooCommerce.

## Fonctionnalites

- Design blanc epure, animation scroll-driven sur canvas
- Compatible WooCommerce (archive produits, page produit, panier, commande)
- Menus editables via Apparence > Menus
- Footer editable via Apparence > Widgets
- Logo et options via Personnaliser (Customizer)
- Sections homepage configurables

## Installation

1. Telecharger le repository en ZIP
2. Dans WordPress : Apparence > Themes > Ajouter > Televerser
3. Activer le theme
4. Installer WooCommerce si ce n'est pas deja fait

## Structure

```
alchimie-des-senteurs-theme/
  assets/
    css/
      main.css          <- styles principaux
      woocommerce.css   <- styles WooCommerce
    js/
      canvas.js         <- animation encens scroll-driven
      main.js           <- scripts globaux
  woocommerce/
    archive-product.php
    single-product.php
    content-product.php
  inc/
    customizer.php      <- options Personnaliser
    woocommerce.php     <- hooks WooCommerce
    enqueue.php         <- chargement assets
  template-parts/
    hero.php
    collection.php
    philosophy.php
    newsletter.php
  header.php
  footer.php
  index.php
  front-page.php
  page.php
  single.php
  404.php
  functions.php
  screenshot.png
```

## Modification du screenshot

Remplacer `screenshot.png` par une image 1200x900px.
WP l'affiche dans Apparence > Themes.
