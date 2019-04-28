<h1><a href="about.html" class="hlavicka">{$title}</a></h1>

<ul>
{foreach from=$ryby item=ryba}
<li><a href="{$ryba.id}.html">{$ryba.nazev}</a></li>
{/foreach}
</ul>
