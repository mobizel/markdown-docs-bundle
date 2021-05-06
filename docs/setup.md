# Setup

```bash
composer config extra.symfony.allow-contrib true
composer require mobizel/markdown-docs-bundle
```

If you don't use Symfony Flex, add the required configuration on `config/packages/mobizel_markdown_docs.yaml`: 

```yaml
mobizel_markdown_docs:
    contexts:
        main:
            path: /docs
            docs_dir: '%kernel.project_dir%/docs'
```
