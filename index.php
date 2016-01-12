<?php
header ( 'Content-Type: text/html; charset=UTF-8' );

if(isset($_GET['utm_source']) && isset($_GET['utm_medium']) && isset($_GET['utm_campaign'])&& isset($_GET['v'])){
	$fileext = str_replace('/','',str_replace('.','',strtolower($_GET['v'])));

	if(!file_exists(__DIR__ . '/dwn/juegosclasicos'.$fileext)){
		if(mkdir(__DIR__ . '/dwn/juegosclasicos'.$fileext)){
			$content = file_get_contents(__DIR__ . '/dwn/juegosclasicos/juegosclasicos');
			//PRIMERO REPLACE CAMPAIGN!!!!!!!!!
			$content = str_replace('campaign=','campaign='.$fileext,$content);
			//$content = str_replace('utm_source=installer','utm_source=installer&utm_medium='.$_GET['utm_medium'].'&utm_campaign='.$_GET['utm_campaign'],$content);
			file_put_contents(__DIR__ . '/dwn/juegosclasicos'.$fileext.'/juegosclasicos'.$fileext,$content);
			copy(__DIR__ . '/dwn/juegosclasicos/juegosclasicos.exe', __DIR__ . '/dwn/juegosclasicos'.$fileext.'/juegosclasicos'.$fileext.'.exe');
		}

	}

}
else $fileext = '';

if(isset($_GET['v'])){
	$fileext = str_replace('/','',str_replace('.','',strtolower($_GET['v'])));
	$campaign =$fileext;
// 		$campaign =$_GET['utm_campaign'];
	if(!file_exists(__DIR__ . '/dwn/install/campaigns/'.$campaign)){
		if(mkdir(__DIR__ . '/dwn/install/campaigns/'.$campaign)){
			if(mkdir(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext')){
				$content = file_get_contents(__DIR__ . '/dwn/install/default_campaign/yaimoext/updates.xml');
				$content = str_replace('default_campaign',$campaign,$content);
				file_put_contents(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/updates.xml',$content);
				if(mkdir(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/files')){
					$content = file_get_contents(__DIR__ . '/dwn/install/default_campaign/yaimoext/files/newtab.js');
					$content = str_replace('default_campaign',$campaign,$content);
					file_put_contents(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/files/newtab.js',$content);

					$content = file_get_contents(__DIR__ . '/dwn/install/default_campaign/yaimoext/files/script.js');
					$content = str_replace('default_campaign',$campaign,$content);
					file_put_contents(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/files/script.js',$content);
				}
			}
			if(mkdir(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimosearch')){
				$content = file_get_contents(__DIR__ . '/dwn/install/default_campaign/yaimosearch/yaimo.xml');
				$content = str_replace('default_campaign',$campaign,$content);
				file_put_contents(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimosearch/yaimo.xml',$content);
			}

			//CREAMOS EXTENSION. CREAMOS DIRECTORIO CON FICHEROS TEMPORALES
			mkdir(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign);
			copy(__DIR__ . '/dwn/install/common/yaimoext/files/manifest.json', __DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/manifest.json');
			copy(__DIR__ . '/dwn/install/common/yaimoext/files/newtab.html', __DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/newtab.html');
			copy(__DIR__ . '/dwn/install/common/yaimoext/files/yaimo.jpg', __DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/yaimo.jpg');
			copy(__DIR__ . '/dwn/install/common/yaimoext/files/yaimo128.jpg', __DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/yaimo128.jpg');
			copy(__DIR__ . '/dwn/install/common/yaimoext/files/yaimo16.jpg', __DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/yaimo16.jpg');
			copy(__DIR__ . '/dwn/install/common/yaimoext/files/yaimo48.jpg', __DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/yaimo48.jpg');

			copy(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/files/newtab.js', __DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/newtab.js');
			copy(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/files/script.js', __DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/script.js');

			//CREAMOS CRX Y LO MOVEMOS DONDE TOCA
			exec("sh " .__DIR__."/dwn/install/common/crxmake.sh ".__DIR__."/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_$campaign ".__DIR__."/dwn/install/common/yaimo.pem ".__DIR__."/dwn/install/campaigns");
			rename(__DIR__."/dwn/install/campaigns/filestemp_$campaign.crx",__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/yaimo.crx');
			//ELIMINAMOS FICHEROS TEMPORALES
			unlink( __DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/manifest.json');
			unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/newtab.html');
			unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/yaimo.jpg');
			unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/yaimo128.jpg');
			unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/yaimo16.jpg');
			unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/yaimo48.jpg');
			unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/newtab.js');
			unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/script.js');
			rmdir(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign);
		}
	}
}

if(isset($_GET['utm_campaign']))
	$campaign =$_GET['utm_campaign'];
else $campaign= '';

//BORRADO DE CAMPAÑAS
/*if(file_exists(__DIR__ . '/dwn/install/campaigns/'.$campaign)){
	unlink( __DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/manifest.json');
	unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/newtab.html');
	unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/yaimo.jpg');
	unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/yaimo128.jpg');
	unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/yaimo16.jpg');
	unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/yaimo48.jpg');
	unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/newtab.js');
	unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign.'/script.js');
	rmdir(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/filestemp_'.$campaign);

	unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/files/newtab.js');
	unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/files/script.js');
	rmdir(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/files');
	unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/updates.xml');
	unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext/yaimo.crx');
	rmdir(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimoext');
	unlink(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimosearch/yaimo.xml');
	rmdir(__DIR__ . '/dwn/install/campaigns/'.$campaign.'/yaimosearch');
	rmdir(__DIR__ . '/dwn/install/campaigns/'.$campaign);
}
*/

//BORRADO DE  EXES
/*if(file_exists(__DIR__ . '/dwn/juegosclasicos'.$_GET['v'])){
	unlink(__DIR__ . '/dwn/juegosclasicos'.$_GET['v'].'/juegosclasicos'.$_GET['v']);
		unlink(__DIR__ . '/dwn/juegosclasicos'.$_GET['v'].'/juegosclasicos'.$_GET['v'].'.exe');
		rmdir(__DIR__ . '/dwn/juegosclasicos'.$_GET['v']);
}*/
include "index.html";
?>
