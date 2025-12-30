<?php
	/**
	*file skin.php
	*@author zwz
	*@date 2015-1-20 上午9:48:56
	*@version : v1.0
	*/

	require_once("fun.php");
	require_once(__ROOT__ . "/class/common/Ziper.class.php");
	require_once(__ROOT__ . "/class/common/SimpleIniIterator.class.php");

	
	$op = g ( "op" );
	$printer = new Printer ();
	switch ($op) {
		case "list" :
			list_skin ();
			break;
		case "use_skin" :
			use_skin ();
			break;
		case "disuse_skin" :
			disuse_skin ();
			break;
		default :
			break;
	}
	
	function list_skin(){
		Global $printer;
		$xml_dom = new DOMDocument();
		$xml_dom->load(__ROOT__ . "/data/skin/skin_list.xml");
		$rows = $xml_dom->getElementsByTagName('row');

		$arr_skin = array();
		// 遍历节点
		foreach ($rows as $row) {
			$arr_skin[] = array(
							"skin_id" => $row->getAttribute('Id') ,
							"skin_name" => $row->getAttribute('Name') ,
							"skin_picture" => $row->getAttribute('Picture')
			);
		}
		//var_dump($arr_skin);
		$printer->out_list($arr_skin,-1,0);
	}
	
	function use_skin (){
		Global $printer;
		
		$skinId = g("skinid","1");
		$skinPath = "";
		$target_dir = RTC_DATADIR . "\\WebRoot\\Update";
		
		$xml_dom = new DOMDocument();
		$xml_dom->load(__ROOT__ . "/data/skin/skin_list.xml");
		$rows = $xml_dom->getElementsByTagName('row');
		
		// 遍历节点，标记当前的皮肤
		foreach ( $rows as $row ) {
			if ($row->getAttribute ( 'Id' ) == $skinId) {
				
				//获取当前设置的皮肤路径
				$skinPath = __ROOT__ . $row->getAttribute ( 'Path' );
				
				$row->setAttribute("IsCurrent", "1");
                $xml_dom->save(__ROOT__ . "/data/skin/skin_list.xml");
                
			}
			else 
			{
				$row->setAttribute("IsCurrent", "0");
				$xml_dom->save(__ROOT__ . "/data/skin/skin_list.xml");
			}
		}
		// 解压文件
		$ziper = new Ziper();
		$result = $ziper->unZip($skinPath);

		$zip_dir = $result["target"]; // 解压的文件夹
		
		// 读取info.ini，生成 update.xml 到 update 目录
		$ini_file = $zip_dir . "\\Info.ini";
		
		if (! file_exists($ini_file))
			$printer->fail("皮肤包错误,Info.ini不存在");
		
		$ini_content = readFileContent($ini_file);
		$ini_data = str2array($ini_content, "\r\n", "=");
		
		$xml_file_path = $target_dir . "\\Update.xml";
		
		$skin_file = $zip_dir . "\\Skin.zip";
		
		// 创建更新目录
		mkdirs($target_dir);
		
		// 判断更新是否存在
		if (! file_exists($skin_file))
			$printer->fail("更新包错误, Skin.zip不存在");
		
		// 拷贝更新包到更新目录
		copy($skin_file, $target_dir . "\\Skin.zip" );
		
		// 构造xml
		$xml_content = "";
		
		$itemExist = false;
		// 判断更新目录下是否有xml存在
		if (file_exists($xml_file_path)) {
			$xml_dom->load($xml_file_path);
			$updateItems = $xml_dom->getElementsByTagName('Item');
		
			// 遍历节点查找
			foreach ($updateItems as $item) {
				if($item->getAttribute('Type') == $ini_data["Type"]){
					$itemExist = true;
					$item->setAttribute('Name', 'RTCSkin');
					$item->setAttribute('Ver', $ini_data["Ver"]);
					$item->setAttribute('FileType', 'zip');
					$item->setAttribute('Path', 'Update/Skin.zip');
					$item->setAttribute('Enforce', $ini_data['Enforce']);
					$item->setAttribute("Md5", $ini_data["Md5"]);
					$xml_dom->save($xml_file_path);
					break;
				}
			}
		
			//没有相应的item，则append
			if (! $itemExist) {
		
				$updateList = $xml_dom->getElementsByTagName("UpdateList");
				$newItem = $xml_dom->createElement('Item');
				$newItem->setAttribute('Name', 'RTCSkin');
				$newItem->setAttribute('Type', $ini_data['Type']);
				$newItem->setAttribute('Ver', $ini_data['Ver']);
				$newItem->setAttribute('FileType', 'zip');
				$newItem->setAttribute('Path', 'Update/Skin.zip');
				$newItem->setAttribute('Enforce', $ini_data['Enforce']);
				$newItem->setAttribute("Md5", $ini_data["Md5"]);
				$updateList->item(0)->appendChild($newItem);
				$xml_dom->save($xml_file_path);
			}
		} else {
			$handle = fopen($xml_file_path, "w");
			$contents = fwrite($handle, $xml_content);
			fclose($handle);
		}
		
		$xml_content = file_get_contents($xml_file_path, "w");
		$xml_content = str_replace("\"", "'", $xml_content);
		$handle = fopen($xml_file_path, "w");
		$contents = fwrite($handle, $xml_content);
		fclose($handle);
		
		$printer->success();
	}
	
	
	function disuse_skin(){
		Global $printer;
		$skinId = g("skinid","1");
		$skinPath = "";
		$target_dir = RTC_DATADIR . "\\WebRoot\\Update";
		
		$xml_dom = new DOMDocument();
		$xml_dom->load(__ROOT__ . "/data/skin/skin_list.xml");
		$rows = $xml_dom->getElementsByTagName('row');
		
		// 遍历节点，标记当前的皮肤
		foreach ( $rows as $row ) {
			if ($row->getAttribute ( 'Id' ) == $skinId) {
				$row->setAttribute("IsCurrent", "0");
                $xml_dom->save(__ROOT__ . "/data/skin/skin_list.xml");
                break;
			}
		}
		
		// 删除文件
		$file = $target_dir . "\\Update.xml";
		$itemExist = false;
		
		if (file_exists ( $file )) {
			$xml_dom->load ( $file );
			$updateItems = $xml_dom->getElementsByTagName ( 'Item' );
		
			// 遍历节点查找
			foreach ( $updateItems as $item ) {
				if ($item->getAttribute ( 'Type' ) == "RTCSkin") {
					$updateList = $xml_dom->getElementsByTagName ( "UpdateList" );
					$updateList->item ( 0 )->removeChild ( $item );
					$xml_dom->save ( $file );
					break;
				}
			}
		}
		
		// 删除文件
		$file = $target_dir . "\\Skin.zip";
		if (file_exists ( $file ))
			unlink ( $file );
		$printer->success ();
	}