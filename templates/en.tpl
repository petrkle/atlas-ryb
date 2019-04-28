<h1><a href="index.html" class="hlavicka">{$title}</a></h1>

<ul>
{foreach from=$ryby item=ryba}
{if isset($ryba.nazev_en)}
<li><a href="{$ryba.id}.html" id="{$ryba.id}">{$ryba.nazev_en}</a></li>
{/if}
{/foreach}
</ul>
