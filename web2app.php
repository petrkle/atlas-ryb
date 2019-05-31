<?php

require('config.php');
require('func.php');

if(!is_dir(WWW)){
	mkdir(WWW, 0755, true);
}

$ryby = get_ryby();
$seznamryb = array();
$seznamobrazku = array();
$crop = array();
$celedi = array();
$rady = array();

$VERSION = `git describe --tags --always --dirty`;

foreach($ryby as $url => $nazev){

	$ryba = get_rybainfo($url, $nazev);

	$foto = false;
	foreach($ryba['info'] as $key => $info){
		if($info['typ'] == 'img'){
			if(!is_file(TMP.'/'.$info['id'].'.jpg')){
			 print RYBY.'/'.$info['url']."\n";
			 savefile(RYBY.'/'.urlprostazeni($info['url']), TMP.'/'.$info['id'].'.jpg');
			}

			$md5 = md5(file_get_contents(TMP.'/'.$info['id'].'.jpg'));
			$ryba['info'][$key]['md5'] = $md5;
			$seznamobrazku[$md5] = TMP.'/'.$info['id'].'.jpg';

			if(!$foto){
				$ryba['foto'] = $md5;
			}

			$smarty->assign('title', $ryba['nazev']);
			$smarty->assign('img', $md5);
			$smarty->assign('backlink', $url);
			$html = $smarty->fetch('img.tpl');
			file_put_contents(WWW.'/'.$md5.'.html', $html);
		}
	}

	foreach($ryba['biologie'] as $key => $biologie){
		if($biologie['typ'] == 'img'){
			if(!is_file(TMP.'/'.$biologie['id'].'.jpg')){
			 print RYBY.'/'.$biologie['url']."\n";
			 savefile(RYBY.'/'.urlprostazeni($biologie['url']), TMP.'/'.$biologie['id'].'.jpg');
			}

			$md5 = md5(file_get_contents(TMP.'/'.$biologie['id'].'.jpg'));
			$ryba['biologie'][$key]['md5'] = $md5;
			$seznamobrazku[$md5] = TMP.'/'.$biologie['id'].'.jpg';

			$smarty->assign('title', $ryba['nazev']);
			$smarty->assign('img', $md5);
			$smarty->assign('backlink', $url);
			$html = $smarty->fetch('img.tpl');
			file_put_contents(WWW.'/'.$md5.'.html', $html);

		}
	}

	foreach($ryba['znaky'] as $key => $znaky){
		if($znaky['typ'] == 'img'){
			if(!is_file(TMP.'/'.$znaky['id'].'.jpg')){
			 print RYBY.'/'.$znaky['url']."\n";
			 savefile(RYBY.'/'.urlprostazeni($znaky['url']), TMP.'/'.$znaky['id'].'.jpg');
			}

			$md5 = md5(file_get_contents(TMP.'/'.$znaky['id'].'.jpg'));
			$ryba['znaky'][$key]['md5'] = $md5;
			$seznamobrazku[$md5] = TMP.'/'.$znaky['id'].'.jpg';

			$smarty->assign('title', $ryba['nazev']);
			$smarty->assign('img', $md5);
			$smarty->assign('backlink', $url);
			$html = $smarty->fetch('img.tpl');
			file_put_contents(WWW.'/'.$md5.'.html', $html);

		}
	}

	foreach($ryba['vyskyt'] as $key => $vyskyt){
		if($vyskyt['typ'] == 'img'){
			if(!is_file(TMP.'/'.$vyskyt['id'].'.jpg')){
			 print RYBY.'/'.$vyskyt['url']."\n";
			 savefile(RYBY.'/'.urlprostazeni($vyskyt['url']), TMP.'/'.$vyskyt['id'].'.jpg');
			}

			$md5 = md5(file_get_contents(TMP.'/'.$vyskyt['id'].'.jpg'));
			$ryba['vyskyt'][$key]['md5'] = $md5;
			$seznamobrazku[$md5] = TMP.'/'.$vyskyt['id'].'.jpg';

			$smarty->assign('title', $ryba['nazev']);
			$smarty->assign('img', $md5);
			$smarty->assign('backlink', $url);
			$html = $smarty->fetch('img.tpl');
			file_put_contents(WWW.'/'.$md5.'.html', $html);

		}
	}

	foreach($ryba['stariarust'] as $key => $stariarust){
		if($stariarust['typ'] == 'img'){
			if(!is_file(TMP.'/'.$stariarust['id'].'.jpg')){
			 print RYBY.'/'.$stariarust['url']."\n";
			 savefile(RYBY.'/'.urlprostazeni($stariarust['url']), TMP.'/'.$stariarust['id'].'.jpg');
			}

			$md5 = md5(file_get_contents(TMP.'/'.$stariarust['id'].'.jpg'));
			$ryba['stariarust'][$key]['md5'] = $md5;
			$seznamobrazku[$md5] = TMP.'/'.$stariarust['id'].'.jpg';

			$smarty->assign('title', $ryba['nazev']);
			$smarty->assign('img', $md5);
			$smarty->assign('backlink', $url);
			$html = $smarty->fetch('img.tpl');
			file_put_contents(WWW.'/'.$md5.'.html', $html);

		}
	}

	foreach($ryba['rybolov'] as $key => $rybolov){
		if($rybolov['typ'] == 'img'){
			if(!is_file(TMP.'/'.$rybolov['id'].'.jpg')){
			 print RYBY.'/'.$rybolov['url']."\n";
			 savefile(RYBY.'/'.urlprostazeni($rybolov['url']), TMP.'/'.$rybolov['id'].'.jpg');
			}

			$md5 = md5(file_get_contents(TMP.'/'.$rybolov['id'].'.jpg'));
			$ryba['rybolov'][$key]['md5'] = $md5;
			$seznamobrazku[$md5] = TMP.'/'.$rybolov['id'].'.jpg';

			$smarty->assign('title', $ryba['nazev']);
			$smarty->assign('img', $md5);
			$smarty->assign('backlink', $url);
			$html = $smarty->fetch('img.tpl');
			file_put_contents(WWW.'/'.$md5.'.html', $html);

		}
	}

	$ryby[$url] = $ryba;
}

foreach($ryby as $ryba){
	if(!isset($celedi[$ryba['celed']['id']])){
		$celedi[$ryba['celed']['id']]['nazev'] = $ryba['celed']['nazev'];
		$celedi[$ryba['celed']['id']]['clenove'] = array();
	}
	array_push($celedi[$ryba['celed']['id']]['clenove'], $ryba);

	if(!isset($rady[$ryba['rad']['id']])){
		$rady[$ryba['rad']['id']]['nazev'] = $ryba['rad']['nazev'];
		$rady[$ryba['rad']['id']]['clenove'] = array();
	}
	array_push($rady[$ryba['rad']['id']]['clenove'], $ryba);
	array_push($seznamryb, $ryba);
}

$poradi = 0;

foreach($ryby as $ryba){

	if(isset($seznamryb[($poradi+1)])){
		$next = $seznamryb[($poradi+1)];
	}else{
		$next = $seznamryb[0];
	}

	if(isset($seznamryb[($poradi-1)])){
		$prev = $seznamryb[($poradi-1)];
	}else{
		$prev = $seznamryb[(count($seznamryb)-1)];
	}

	$smarty->assign('next', $next);
	$smarty->assign('prev', $prev);
	$smarty->assign('title', $ryba['nazev']);
	$smarty->assign('ryba', $ryba);
	$html = $smarty->fetch('hlavicka.tpl');
	$html .= $smarty->fetch('ryba.tpl');
	$html .= $smarty->fetch('paticka.tpl');
	file_put_contents(WWW.'/'.$ryba['id'].'.html', $html);
	$poradi++;
}

$smarty->assign('title', APPNAME);
$smarty->assign('ryby', $ryby);
$html = $smarty->fetch('hlavicka.tpl');
$html .= $smarty->fetch('index.tpl');
$html .= $smarty->fetch('paticka.tpl');
file_put_contents(WWW.'/index.html', $html);

$smarty->assign('title', APPNAME);
$smarty->assign('VERSION', $VERSION);
$smarty->assign('pocet', count($ryby));
$html = $smarty->fetch('hlavicka.tpl');
$html .= $smarty->fetch('about.tpl');
$html .= $smarty->fetch('paticka.tpl');
file_put_contents(WWW.'/about.html', $html);

foreach($celedi as $key => $celed){
	$smarty->assign('title', $celed['nazev']);
	$smarty->assign('celed', $celed);
	$html = $smarty->fetch('hlavicka.tpl');
	$html .= $smarty->fetch('celed.tpl');
	$html .= $smarty->fetch('paticka.tpl');
	file_put_contents(WWW.'/'.$key.'.html', $html);
}

foreach($rady as $key => $rad){
	$smarty->assign('title', $rad['nazev']);
	$smarty->assign('rad', $rad);
	$html = $smarty->fetch('hlavicka.tpl');
	$html .= $smarty->fetch('rad.tpl');
	$html .= $smarty->fetch('paticka.tpl');
	file_put_contents(WWW.'/'.$key.'.html', $html);
}

$smarty->assign('celedi', $celedi);
$smarty->assign('rady', $rady);

$smarty->assign('title', 'Čeledi');
$html = $smarty->fetch('hlavicka.tpl');
$html .= $smarty->fetch('celedi.tpl');
$html .= $smarty->fetch('paticka.tpl');
file_put_contents(WWW.'/celedi.html', $html);

$smarty->assign('title', 'Řády');
$html = $smarty->fetch('hlavicka.tpl');
$html .= $smarty->fetch('rady.tpl');
$html .= $smarty->fetch('paticka.tpl');
file_put_contents(WWW.'/rady.html', $html);

$html = $smarty->fetch('ryby.js.tpl');
file_put_contents(WWW.'/ryby.js', $html);

uasort($ryby, 'sort_by_lat');

$smarty->assign('title', 'Osteichthyes');
$smarty->assign('ryby', $ryby);
$html = $smarty->fetch('hlavicka.tpl');
$html .= $smarty->fetch('lat.tpl');
$html .= $smarty->fetch('paticka.tpl');
file_put_contents(WWW.'/lat.html', $html);

uasort($ryby, 'sort_by_en');

$smarty->assign('title', 'Fishes');
$smarty->assign('ryby', $ryby);
$html = $smarty->fetch('hlavicka.tpl');
$html .= $smarty->fetch('en.tpl');
$html .= $smarty->fetch('paticka.tpl');
file_put_contents(WWW.'/en.html', $html);

uasort($ryby, 'sort_by_sk');

$smarty->assign('title', 'Ryby (SK)');
$smarty->assign('ryby', $ryby);
$html = $smarty->fetch('hlavicka.tpl');
$html .= $smarty->fetch('sk.tpl');
$html .= $smarty->fetch('paticka.tpl');
file_put_contents(WWW.'/sk.html', $html);

uasort($ryby, 'sort_by_de');

$smarty->assign('title', 'Fische');
$smarty->assign('ryby', $ryby);
$html = $smarty->fetch('hlavicka.tpl');
$html .= $smarty->fetch('de.tpl');
$html .= $smarty->fetch('paticka.tpl');
file_put_contents(WWW.'/de.html', $html);

copy('templates/ryby.css', WWW.'/ryby.css');
copy('templates/roboto-regular.ttf', WWW.'/roboto-regular.ttf');
copy('ryba512.png', WWW.'/ryba512.png');
copy('ryba.svg', WWW.'/ryba.svg');
copyToDir('templates/*.js', WWW);
copyToDir('templates/*.svg', WWW);

foreach($seznamobrazku as $md5 => $source){
	if(!is_file(WWW.'/'.$md5.'.jpg')){
		system("convert -quality 80 $source ".WWW.'/'.$md5.'.jpg');
	}
}
