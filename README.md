# mobizel/markdown-docs-bundle

## Setup
```bash
composer require mobizel/markdown-docs-bundle
```

```yaml
# config/routes/mobizel_markdown_docs.yaml

_mobizel_markdowns:
    resource: '@MobizelMarkdownDocsBundle/Resources/config/routes.xml'

```

## Write your own doc 
Markdown templates are on `docs` directory.

Your files are already available on your server.

Example:
`docs/dummy/foo.md` is available at [/docs/dummy/foo](http://localhost:8000/docs/dummy/foo)
