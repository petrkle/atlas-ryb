var ryby = {
{foreach from=$ryby item=ryba name=r}
{$ryba.id|replace:'-':'_'}:{literal}{{/literal}c:'{$ryba.nazev}',l:'{$ryba.nazev_lat}'{if isset($ryba.nazev_en)},e:'{$ryba.nazev_en}'{/if}{if isset($ryba.nazev_sk)},s:'{$ryba.nazev_sk}'{/if}{if isset($ryba.nazev_de)},d:'{$ryba.nazev_de}'{/if}{literal}}{/literal},
{/foreach}
{foreach from=$celedi item=celed key=key name=c}
{$key|replace:'-':'_'}:{literal}{{/literal}c:'{$celed.nazev}'{literal}}{/literal},
{/foreach}
{foreach from=$rady item=rad key=key name=r}
{$key|replace:'-':'_'}:{literal}{{/literal}c:'{$rad.nazev}'{literal}}{/literal}{if !$smarty.foreach.r.last},{/if}

{/foreach}
}
