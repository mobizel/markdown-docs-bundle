# Customizing templates

```html
<!-- templates/bundles/MobizelMarkdownDocsBundle/base.html.twig -->
{% extends '@!MobizelMarkdownDocs/base.html.twig' %}

{% block title %}
    Custom title - {{ parent() }}
{% endblock %}

{% block stylesheets %}
    {{ parent() }}
    <link rel="stylesheet" href="path/to/your/custom/css/file"/>
{% endblock %}

{% block javascripts %}
    {{ parent() }}
    <script src="path/to/your/custom/js/file"></script>
{% endblock %}
```
