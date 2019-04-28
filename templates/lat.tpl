<h1><a href="index.html" class="hlavicka">{$title}</a></h1>

<ul>
{foreach from=$ryby item=ryba}
<li><a href="{$ryba.id}.html" id="{$ryba.id}">{$ryba.nazev_lat}</a></li>
{/foreach}
</ul>
