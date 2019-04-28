<h1><a href="rady.html" class="hlavicka">{$title}</a></h1>

<ul>
{foreach from=$rad.clenove item=ryba}
<li><a href="{$ryba.id}.html">{$ryba.nazev}</a></li>
{/foreach}
</ul>
