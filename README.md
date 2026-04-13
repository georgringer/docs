# georgringer/docs

TYPO3 backend extension that adds a documentation toolbar button. Clicking the button opens the project documentation in an iframe modal.

## Features

- Toolbar icon in the TYPO3 backend (help icon)
- Opens a configurable documentation URL in a modal iframe
- Fully translatable (EN/DE included)

## Configuration

The documentation URL can be changed in the TYPO3 Extension Manager or Install Tool under **Admin Tools → Settings → Extension Configuration → docs**.

| Setting | Default | Description |
|---------|---------|-------------|
| `docUrl` | `/_assets/docs/Inhalt/Inhaltselemente.html` | URL to the documentation HTML page |

## Generating the documentation

The documentation is built with [daux.io](https://daux.io) from the `docs/` directory:

```bash
# Static HTML generieren
daux generate --destination=public/_assets/docs/
```

To also include auto-generated component documentation from TYPO3:

```bash
ddev typo3 fbase:component:documentation \
  packages/f_theme/Resources/Private/Ui \
  --format=markdown > docs/Inhalt/Komponenten.md

daux generate --destination=public/_assets/docs/
```

## Installation

The package is included as a local path repository via Composer:

```bash
composer require georgringer/docs
```
