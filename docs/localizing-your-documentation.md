# Localizing your documentation

You can configure your docs context for localization.

```yaml
# config/packages/mobizel_markdown_docs.yaml

mobizel_markdown_docs:
    contexts:
        main:
            path: /docs/{locale}
            docs_dir: '%kernel.project_dir%/docs/{locale}'
            requirements:
                locale: '[a-z]+'
```
