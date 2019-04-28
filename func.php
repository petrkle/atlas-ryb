<?php

function savehtml($url){
	if(!is_file(TMP.'/'.url2fn($url))){
		print "$url\n";
		savefile($url, TMP.'/'.url2fn($url));
	}
}

function savefile($url, $filename){
	if(!is_file($filename)){
		if(!is_dir(dirname($filename))){
			mkdir(dirname($filename), 0755, true);
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_REFERER, RYBY);
		curl_setopt($ch, CURLOPT_USERAGENT, 'php '.phpversion());
		curl_setopt($ch,CURLOPT_ENCODING, '');
		file_put_contents($filename, curl_exec($ch));
		curl_close($ch);
	}
}

function asciize($str) {
    $str = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $str));
    $str = preg_replace('/[^a-z0-9.]/', ' ', $str);
    $str = preg_replace('/\s\s+/', ' ', $str);
    $str = str_replace(' ', '-', trim($str));
    return $str;
}

function url2fn($url){
	$url = str_replace(RYBY, '', $url);
	return preg_replace('/[^a-z0-9]*/', '', $url).'.html';
}

function get_img($url){
	$linky = array();

	$dom = new DOMDocument();
	$dom->loadHTML(file_get_contents(TMP.'/'.url2fn($url)));
	$xpath = new DOMXPath($dom);
	$obrazky = $xpath->query('//*[@id="rigth-outline"]/p/a/img');

	foreach($obrazky as $obrazek) {
		$src = $obrazek->getAttribute("src");
		array_push($linky, preg_replace('/t\.jpg$/', '.jpg', $src));
	}
	return $linky;
}

function get_ryby(){
	savehtml(RYBY.'/'.ATLAS.'/');
	$linky = array();
	$dom = new DOMDocument();
	$dom->loadHTML(file_get_contents(TMP.'/'.url2fn(ATLAS)));
	$xpath = new DOMXPath($dom);
	$odkazy = $xpath->query('//*[@id="fish-box-1"]/div/ul/li/a');
	foreach($odkazy as $odkaz){
		$href = preg_replace("/".ATLAS."\/(.*)\/$/", '\1', $odkaz->getAttribute("href"));
		$linky[$href] = $odkaz->nodeValue;
	}
	return $linky;
}

function get_rybainfo($url, $nazev){
	$navrat = array();
	$navrat['id'] = $url;
	$navrat['nazev'] = $nazev;
	savehtml(RYBY.'/'.ATLAS.'/'.$url.'/');

	$dom = new DOMDocument();
	$dom->loadHTML(file_get_contents(TMP.'/'.url2fn(ATLAS.'/'.$url.'/')));
	$xpath = new DOMXPath($dom);

	$zi = $xpath->query('//*[@id="zakladni-info"]/p');

	$navrat['info'] = array();

	foreach($zi as $info){

	$nodeposition = count($xpath->query('preceding::*', $info));

		$info = trim(preg_replace(['(\s+)u', '(^\s|\s$)u'], [' ', ''],$info->nodeValue));
		if(strlen($info) > 0){
			$navrat['info'][$nodeposition] = array('typ' => 'text', 'value' => $info);
		}
	}

	$zii = $xpath->query('//*[@id="zakladni-info"]/p/a');

	foreach($zii as $img){

	$nodeposition = count($xpath->query('preceding::*', $img));
		$href = $img->getAttribute("href");
		$navrat['info'][$nodeposition] = array('typ' => 'img', 'url' => $href, 'id' => $url.md5($href));
	}

	$odkazy = $xpath->query('//*[@id="atlas-hlavicka"]/ul/li/a');
	foreach($odkazy as $odkaz){
		$href = $odkaz->getAttribute("href");
		if(preg_match('/'.ATLAS.'\/rad\/(.*)\//', $href, $m)){
			$navrat['rad']['id'] = $m[1];
			$navrat['rad']['nazev'] = $odkaz->nodeValue;
		}

		if(preg_match('/'.ATLAS.'\/celed\/(.*)\//', $href, $m)){
			$navrat['celed']['id'] = $m[1];
			$navrat['celed']['nazev'] = $odkaz->nodeValue;
		}
	
	}

	$info = $xpath->query('//*[@id="atlas-hlavicka"]/ul/li');

	foreach($info as $line){
		$line = $line->nodeValue;

		if(preg_match('/latinsky: (.*)/', $line, $m)){
			$navrat['nazev_lat'] = $m[1];
		}

		if(preg_match('/slovensky: (.*)/', $line, $m)){
			$navrat['nazev_sk'] = $m[1];
		}
	
		if(preg_match('/anglicky: (.*)/', $line, $m)){
			$navrat['nazev_en'] = preg_replace('/,.*/' ,'', $m[1]);
		}

		if(preg_match('/německy: (.*)/', $line, $m)){
			$navrat['nazev_de'] = preg_replace('/,.*/' ,'', $m[1]);
		}

		if(preg_match('/lovná délka/i', $line)){
			$navrat['lovnadelka'] = $line;
		}

		if(preg_match('/hájen(|í|ý)/i', $line) or preg_match('/od.*do/i', $line)){
			if(preg_match('/^od /', $line)){
				$line = "Hájení ".$line;
			}
			$navrat['hajeni'] = $line;
		}

		if(preg_match('/(původní|území|povodí|vysaz|dovez)/i', $line)){
			$navrat['puvod'] = $line;
		}

		if(preg_match('/chráněn/i', $line)){
			$navrat['ochrana'] = $line;
		}

	}

	$fotky = $xpath->query('//*[@id="atlas-foto-ryb"]/a');

	foreach($fotky as $fotka){
		$href = preg_replace('/\/\//', '/', $fotka->getAttribute("href"));
		if(!isset($navrat['fotky'])){
			$navrat['fotky'] = array();
		}
		array_push($navrat['fotky'], array('url' => $href, 'id' => $url.md5($href)));
	}

	ksort($navrat['info']);

	$rozlisovaciznaky = $xpath->query('//*[@id="rozlisovaci-znaky"]/p');

	$navrat['znaky'] = array();

	foreach($rozlisovaciznaky as $znak){
		$nodeposition = count($xpath->query('preceding::*', $znak));
		$znak = trim(preg_replace(['(\s+)u', '(^\s|\s$)u'], [' ', ''],$znak->nodeValue));
		if(strlen($znak) > 0){
			if(preg_match('/čeho si všímat/ui', $znak)){
				$navrat['znaky'][$nodeposition] = array('typ' => 'h3', 'value' => preg_replace('/:$/', '', $znak));
			}else{
				$navrat['znaky'][$nodeposition] = array('typ' => 'text', 'value' => $znak);
			}
		}
	}

	$znaky = $xpath->query('//*[@id="rozlisovaci-znaky"]/ul/li|//*[@id="rozlisovaci-znaky"]/ul/ul/li');

	foreach($znaky as $znak){
		$nodeposition = count($xpath->query('preceding::*', $znak));
		$znak = trim(preg_replace(['(\s+)u', '(^\s|\s$)u'], [' ', ''],$znak->nodeValue));
		if(strlen($znak) > 0){
			$navrat['znaky'][$nodeposition] = array('typ' => 'li', 'value' => $znak);
		}
	}

	$znakyobr = $xpath->query('//*[@id="rozlisovaci-znaky"]/p/a|//*[@id="rozlisovaci-znaky"]/ul/a');

	foreach($znakyobr as $img){
		$nodeposition = count($xpath->query('preceding::*', $img));
		$href = $img->getAttribute("href");
		$navrat['znaky'][$nodeposition] = array('typ' => 'img', 'url' => $href, 'id' => $url.md5($href));
	}

	$znakyh3 = $xpath->query('//*[@id="rozlisovaci-znaky"]/h3');

	foreach($znakyh3 as $h3){
		$nodeposition = count($xpath->query('preceding::*', $h3));
		$h3 = trim(preg_replace(['(\s+)u', '(^\s|\s$)u'], [' ', ''], $h3->nodeValue));
		if(strlen($h3) > 0){
			$navrat['znaky'][$nodeposition] = array('typ' => 'h3', 'value' => preg_replace('/:$/', '', $h3));
		}
	}

	ksort($navrat['znaky']);

	$biologie = $xpath->query('//*[@id="bilogie"]/p');

	$navrat['biologie'] = array();

	foreach($biologie as $foo){
		$nodeposition = count($xpath->query('preceding::*', $foo));
		$foo = trim(preg_replace(['(\s+)u', '(^\s|\s$)u'], [' ', ''], $foo->nodeValue));
		if(strlen($foo) > 0){
			$foo = preg_replace('/ sepstruzi /', ' se pstruzi ', $foo);
			$navrat['biologie'][$nodeposition] = array('typ' => 'text', 'value' => $foo);
		}
	}

	$bioobr = $xpath->query('//*[@id="bilogie"]/p/a');

	foreach($bioobr as $img){
		$nodeposition = count($xpath->query('preceding::*', $img));
		$href = $img->getAttribute("href");
		$navrat['biologie'][$nodeposition] = array('typ' => 'img', 'url' => $href, 'id' => $url.md5($href));
	}

	ksort($navrat['biologie']);

	$vyskyt = $xpath->query('//*[@id="vyskyt"]/p');

	$navrat['vyskyt'] = array();

	foreach($vyskyt as $foo){

	$nodeposition = count($xpath->query('preceding::*', $foo));

		$foo = trim(preg_replace(['(\s+)u', '(^\s|\s$)u'], [' ', ''], $foo->nodeValue));
		if(strlen($foo) > 0){
			$navrat['vyskyt'][$nodeposition] = array('typ' => 'text', 'value' => $foo);
		}
	}

	$vyskytobr = $xpath->query('//*[@id="vyskyt"]/p/a');

	foreach($vyskytobr as $img){

	$nodeposition = count($xpath->query('preceding::*', $img));
		$href = $img->getAttribute("href");
		$navrat['vyskyt'][$nodeposition] = array('typ' => 'img', 'url' => $href, 'id' => $url.md5($href));
	}

	ksort($navrat['vyskyt']);


	$stariarust = $xpath->query('//*[@id="stari-a-rust"]/p');

	$navrat['stariarust'] = array();

	foreach($stariarust as $foo){

	$nodeposition = count($xpath->query('preceding::*', $foo));

		$foo = trim(preg_replace(['(\s+)u', '(^\s|\s$)u'], [' ', ''], $foo->nodeValue));
		if(strlen($foo) > 0){
			$navrat['stariarust'][$nodeposition] = array('typ' => 'text', 'value' => $foo);
		}
	}

	$stariarustobr = $xpath->query('//*[@id="stari-a-rust"]/p/a');

	foreach($stariarustobr as $img){

	$nodeposition = count($xpath->query('preceding::*', $img));
		$href = $img->getAttribute("href");
		$navrat['stariarust'][$nodeposition] = array('typ' => 'img', 'url' => $href, 'id' => $url.md5($href));
	}

	$stariarusth3 = $xpath->query('//*[@id="stari-a-rust"]/h3');
	if(count($stariarusth3)>0){
		$h3 = count($xpath->query('preceding::*', $stariarusth3[0]));
	}

	if(isset($h3)){
		foreach($navrat['stariarust'] as $key => $item){
			if($key>$h3){
				unset($navrat['stariarust'][$key]);
			}
		}
	}

	ksort($navrat['stariarust']);



	$rybolov = $xpath->query('//*[@id="sportovni-rybolov"]/p');

	$navrat['rybolov'] = array();

	foreach($rybolov as $foo){

		$nodeposition = count($xpath->query('preceding::*', $foo));
		$foo = trim(preg_replace(['(\s+)u', '(^\s|\s$)u'], [' ', ''], $foo->nodeValue));
		if(strlen($foo) > 0){
			$navrat['rybolov'][$nodeposition] = array('typ' => 'text', 'value' => $foo);
		}
	}

	$rybolovobr = $xpath->query('//*[@id="sportovni-rybolov"]/p/a');

	foreach($rybolovobr as $img){

	$nodeposition = count($xpath->query('preceding::*', $img));
		$href = $img->getAttribute("href");
		$navrat['rybolov'][$nodeposition] = array('typ' => 'img', 'url' => $href, 'id' => $url.md5($href));
	}

	$rybolovh3 = $xpath->query('//*[@id="sportovni-rybolov"]/h3');

	foreach($rybolovh3 as $h3){
		$nodeposition = count($xpath->query('preceding::*', $h3));
		$h3 = trim(preg_replace(['(\s+)u', '(^\s|\s$)u'], [' ', ''], $h3->nodeValue));
		if(strlen($h3) > 0){
			$navrat['rybolov'][$nodeposition] = array('typ' => 'h3', 'value' => preg_replace('/:$/', '', $h3));
		}
	}

	$rybolovh4 = $xpath->query('//*[@id="sportovni-rybolov"]/h4');

	foreach($rybolovh4 as $h4){
		$nodeposition = count($xpath->query('preceding::*', $h4));
		$h4 = trim(preg_replace(['(\s+)u', '(^\s|\s$)u'], [' ', ''], $h4->nodeValue));
		if(strlen($h4) > 0){
			$navrat['rybolov'][$nodeposition] = array('typ' => 'h4', 'value' => $h4);
		}
	}

	ksort($navrat['rybolov']);

	return($navrat);
}

function copyToDir($pattern, $dir)
{
    foreach (glob($pattern) as $file) {
        $dest = realpath($dir) . DIRECTORY_SEPARATOR . basename($file);
        if(is_file($file)) {
            copy($file, $dest);
        }
    }
}

function sort_by_nazev($a, $b)
{
	$coll = collator_create( 'cs_CZ.UTF-8' );
	return collator_compare($coll, $a['nazev'], $b['nazev']);
}

function sort_by_lat($a, $b)
{
	$coll = collator_create( 'cs_CZ.UTF-8' );
	return collator_compare($coll, $a['nazev_lat'], $b['nazev_lat']);
}

function sort_by_en($a, $b)
{
	$coll = collator_create( 'en_US.UTF-8' );
	if(isset($a['nazev_en']) and isset($b['nazev_en'])){
		return collator_compare($coll, $a['nazev_en'], $b['nazev_en']);
	}else{
		return false;
	}
}

function sort_by_sk($a, $b)
{
	$coll = collator_create( 'sk_SK.UTF-8' );
	if(isset($a['nazev_sk']) and isset($b['nazev_sk'])){
		return collator_compare($coll, $a['nazev_sk'], $b['nazev_sk']);
	}else{
		return false;
	}
}

function sort_by_de($a, $b)
{
	$coll = collator_create( 'de_DE.UTF-8' );
	if(isset($a['nazev_de']) and isset($b['nazev_de'])){
		return collator_compare($coll, $a['nazev_de'], $b['nazev_de']);
	}else{
		return false;
	}
}

function urlprostazeni($url){
	return implode('/', array_map('rawurlencode', explode('/',$url)));
}
