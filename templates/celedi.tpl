<h1><a href="index.html" class="hlavicka">{$title}</a></h1>

<ul>
{foreach from=$celedi item=celed key=key}
<li><a href="{$key}.html">{$celed.nazev}</a></li>
{/foreach}
</ul>
