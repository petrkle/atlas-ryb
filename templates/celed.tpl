<h1><a href="celedi.html" class="hlavicka">{$title}</a></h1>

<ul>
{foreach from=$celed.clenove item=ryba}
<li><a href="{$ryba.id}.html">{$ryba.nazev}</a></li>
{/foreach}
</ul>
