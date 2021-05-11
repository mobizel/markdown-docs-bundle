# Setup

```bash
composer config extra.symfony.allow-contrib true
composer require mobizel/markdown-docs-bundle
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
