# How to add docs contexts

You can add several contexts of the documentation.

For example, you can add a context to browse the legacy versions of your documentation.

```yaml
# config/packages/mobizel_markdown_docs.yaml

mobizel_markdown_docs:
    contexts:
        legacy:
            path: /{version}
            docs_dir: '/path/to/your/legacy_docs/{versions}'
            requirements:
                version: '(\d+)\.(\d+)'
```

Another example is to add a context for your packages

```yaml
mobizel_markdown_docs:
    contexts:
        packages:
            path: /packages/{package}/{version}
            docs_dir: '/path/to/your/packages_docs/{package}/{version}'
            requirements:
                package: '.+'
                version: '(\d+)\.(\d+)'
```
