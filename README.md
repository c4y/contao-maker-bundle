# Contao Maker Bundle

Erzeugt ein Bundle, z.B. in /bundles/TestBundle und fügt auf Wunsch das Repository zur composer.json hinzu.

Im Bundle können nun Inhaltselemente, Routen (API) etc. erzeugt werden.

Das Bundle ist entstanden in Anlehnung an das offizielle Contao-Maker-Bundle, aber hier in Bezug auf eigene Bundles.

## make:bundle

Hier werden die folgenden Dateien erstellt:

Beispiel: 

`cmaker make:bundle bundles/Test C4Y`


- bundles/Test/config/routing.yml
- bundles/Test/config/services.yml
- bundles/Test/src/ContaoManager/Plugin.php
- bundles/Test/src/DependencyInjection/ContaoTestExtension.php
- bundles/Test/src/ContaoTestBundle.php
- composer.json


Der Namespace setzt sich wie folgt zusammen:
C4Y\TestBundle

Auf Wunsch wird das Repository in die composer.json eingetragen:

```json
"repositories": [
        {
            "type": "path",
            "url": "bundles/Test"
        }
    ]
```

Nach der Erstellung kann das Bundle mit `composer require c4y/test` erstellt werden.

Der Composername wird aus dem Bundle-Ordner generiert.

Aus `bundles/ContaoMeinTest` wird `c4y/contao-mein-test`.

## make:ce

**Beispiel**

`cmaker make:ce bundles/Test MeinInhaltselement`

Erstelle Dateien:

- bundles/Test/contao/dca/tl_content.php
- bundles/Test/contao/languages/de/tl_content.php
- bundles/Test/contao/templates/ce_mein_inhaltselement.html5
- bundles/Test/src/Controller/ContentElement/MeinInhaltselementController.php

## make:api

Erstellt eine eigene FrontendRoute /example

**Beispiel**

```bash
cmaker make:api bundles/Test ApiTest
```

Erstellte Datei:

```bash
bundles/Test/src/Controller/TestController.php
```

