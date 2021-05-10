# Setup

```bash
# On *nix and Mac
export SYMFONY_ENDPOINT=https://flex.symfony.com/r/github.com/symfony/recipes-contrib/1142
# On Windows
SET SYMFONY_ENDPOINT=https://flex.symfony.com/r/github.com/symfony/recipes-contrib/1142
```

```bash
composer config extra.symfony.allow-contrib true
composer require mobizel/markdown-docs-bundle
```

```bash
# On *nix and Mac
unset SYMFONY_ENDPOINT
# On Windows
SET SYMFONY_ENDPOINT=
```

If you don't use Symfony Flex, 

Enable the bundle on `config/bundles.php`

```php
<?php

return [
    // [...]
    Mobizel\Bundle\MarkdownDocsBundle\MobizelMarkdownDocsBundle::class => ['all' => true],
];
```

Add the required configuration on `config/packages/mobizel_markdown_docs.yaml`: 

```yaml
mobizel_markdown_docs:
    contexts:
        main:
            path: /docs
            docs_dir: '%kernel.project_dir%/docs'
```

And add the required configuration for routes on `config/routes/mobizel_markdown_docs.yaml`

```yaml
_mobizel_markdowns:
    resource: 'mobizel_markdown_docs.routing.context_loader'
    type: service
```
