<h1><a href="index.html" class="hlavicka">{$title}</a></h1>

<ul>
{foreach from=$ryby item=ryba}
{if isset($ryba.nazev_sk)}
<li><a href="{$ryba.id}.html" id="{$ryba.id}">{$ryba.nazev_sk}</a></li>
{/if}
{/foreach}
</ul>
