# Setup

```bash
composer config extra.symfony.allow-contrib true
composer require mobizel/markdown-docs-bundle
```

If you don't use Symfony Flex, add the required routes on `config/routes.yaml`: 

```yaml
_mobizel_markdowns:
    resource: '@MobizelMarkdownDocsBundle/Resources/config/routes.xml'
```
