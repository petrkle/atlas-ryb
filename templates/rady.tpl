<h1><a href="index.html" class="hlavicka">{$title}</a></h1>

<ul>
{foreach from=$rady item=rad key=key}
<li><a href="{$key}.html">{$rad.nazev}</a></li>
{/foreach}
</ul>
