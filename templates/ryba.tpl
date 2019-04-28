<h1><a href="index.html" class="hlavicka">{$title}</a></h1>
{if isset($ryba.foto)}
<p class="obrazek">
<a href="{$ryba.foto}.html" id="{$ryba.foto}"><img src="{$ryba.foto}.jpg" style="width:100%;" class="obr"></a>
</p>
{/if}

{if isset($ryba.nazev_lat)}
<p>
Latinsky: <a href="lat.html#{$ryba.id}">{$ryba.nazev_lat}</a>
</p>
{/if}

{if isset($ryba.nazev_sk)}
<p>
Slovensky: <a href="sk.html#{$ryba.id}">{$ryba.nazev_sk}</a>
</p>
{/if}

{if isset($ryba.nazev_en)}
<p>
Anglicky: <a href="en.html#{$ryba.id}">{$ryba.nazev_en}</a>
</p>
{/if}

{if isset($ryba.nazev_de)}
<p>
Německy: <a href="de.html#{$ryba.id}">{$ryba.nazev_de}</a>
</p>
{/if}

{if isset($ryba.rad.id)}
<p>
Řád: <a href="{$ryba.rad.id}.html#{$ryba.id}">{$ryba.rad.nazev}</a>
</p>
{/if}

{if isset($ryba.celed.id)}
<p>
Čeleď: <a href="{$ryba.celed.id}.html#{$ryba.id}">{$ryba.celed.nazev}</a>
</p>
{/if}

{if isset($ryba.puvod)}
<p>
{$ryba.puvod}
</p>
{/if}

{if isset($ryba.hajeni)}
<p>
{$ryba.hajeni}
</p>
{/if}

{if isset($ryba.lovnadelka)}
<p>
{$ryba.lovnadelka}
</p>
{/if}

{if isset($ryba.ochrana)}
<p>
{$ryba.ochrana}
</p>
{/if}

<h3>Základní údaje</h3>
{foreach from=$ryba.info item=info name=info}

{if $info.typ == 'text'}
<p>{$info.value}</p>
{/if}

{if $info.typ == 'img' and $info.md5 != $ryba.foto}
<p class="obrazek">
<a href="{$info.md5}.html" id="{$info.md5}"><img src="{$info.md5}.jpg" style="width:100%;" class="obr"></a>
</a>
{/if}

{/foreach}

{if isset($ryba.znaky)}
<h3>Rozlišovací znaky</h3>

{foreach from=$ryba.znaky item=znaky name=znaky}

{if $znaky.typ == 'h3'}
<h3>{$znaky.value}</h3>
{/if}

{if $znaky.typ == 'text'}
<p>{$znaky.value}</p>
{/if}

{if $znaky.typ == 'li'}
<ul class="pohled">
<li>{$znaky.value}</li>
</ul>
{/if}

{if $znaky.typ == 'img'}
<p class="obrazek">
<a href="{$znaky.md5}.html" id="{$znaky.md5}"><img src="{$znaky.md5}.jpg" style="width:100%;" class="obr"></a>
</a>
{/if}

{/foreach}

{/if}

{if isset($ryba.vyskyt)}
<h3>Výskyt v ČR</h3>

{foreach from=$ryba.vyskyt item=vyskyt name=vyskyt}

{if $vyskyt.typ == 'text'}
<p>{$vyskyt.value}</p>
{/if}

{if $vyskyt.typ == 'img'}
<p class="obrazek">
<a href="{$vyskyt.md5}.html" id="{$vyskyt.md5}"><img src="{$vyskyt.md5}.jpg" style="width:100%;" class="obr"></a>
</a>
{/if}

{/foreach}
{/if}

{if isset($ryba.biologie)}
<h3>Biologie</h3>

{foreach from=$ryba.biologie item=biologie name=biologie}

{if $biologie.typ == 'text'}
<p>{$biologie.value}</p>
{/if}

{if $biologie.typ == 'img'}
<p class="obrazek">
<a href="{$biologie.md5}.html" id="{$biologie.md5}"><img src="{$biologie.md5}.jpg" style="width:100%;" class="obr"></a>
</a>
{/if}

{/foreach}
{/if}


{if isset($ryba.stariarust) and count($ryba.stariarust)>0}
<h3>Stáří a růst</h3>

{foreach from=$ryba.stariarust item=stariarust name=stariarust}

{if $stariarust.typ == 'text'}
<p>{$stariarust.value}</p>
{/if}

{if $stariarust.typ == 'img'}
<p class="obrazek">
<a href="{$stariarust.md5}.html" id="{$stariarust.md5}"><img src="{$stariarust.md5}.jpg" style="width:100%;" class="obr"></a>
</a>
{/if}

{/foreach}
{/if}

{if isset($ryba.rybolov)}
<h3>Sportovní rybolov</h3>

{foreach from=$ryba.rybolov item=rybolov name=rybolov}

{if $rybolov.typ == 'h3'}
<h3>{$rybolov.value}</h3>
{/if}

{if $rybolov.typ == 'h4'}
<h4>{$rybolov.value}</h4>
{/if}

{if $rybolov.typ == 'text'}
<p>{$rybolov.value}</p>
{/if}

{if $rybolov.typ == 'img'}
<p class="obrazek">
<a href="{$rybolov.md5}.html" id="{$rybolov.md5}"><img src="{$rybolov.md5}.jpg" style="width:100%;" class="obr"></a>
</a>
{/if}

{/foreach}
{/if}

<script src="swipe.js"></script>
<script>
swipeonelement('obr', '{$next.id}.html', '{$prev.id}.html');
</script>
