<?php
class BigUpload{
  private $target_dir; //上传目录
  private $target;
  private $tmpPath; //PHP文件临时目录
  private $blobNum; //第几个文件块
  private $totalBlobNum; //文件块总数
  private $fileName; //文件名
  private $context;
 
  public function __construct(){
	  $this -> db = new DB();
  }
  //移动文件
  function moveFile($target_dir,$tmpPath,$blobNum,$fileName,$context){
	$this->target_dir = $target_dir;
    $this->tmpPath = $tmpPath;
    $this->blobNum = $blobNum;
    $this->fileName = $fileName;
	$this->context = $context;
    $this->touchDir();
    $filename = $this->target_dir.'/'.$this->context.'/'.$this->fileName.'__'.$this->blobNum;
	$filename = iconv_str($filename,"utf-8","gbk");
    move_uploaded_file($this->tmpPath,$filename);
  }
  //建立上传文件夹
  function touchDir(){
	$filename = $this->target_dir.'/'.$this->context;
	$filename = iconv_str($filename,"utf-8","gbk");
    if(!file_exists($filename)){
      return mkdir($filename);
    }
  }
  
  //判断是否是最后一块，如果是则进行文件合成并且删除文件块
  function fileMerge($target_dir,$target,$fileName,$totalBlobNum,$context){
	  $this->target_dir = $target_dir;
	  $this->target = $target;
	  $this->fileName = $fileName;
	  $this->totalBlobNum = $totalBlobNum;
	  $this->context = $context;
	  
	  $sql = " select * from MD5BigFile where Context='".g("context")."' order by BlobNum";
	  $data = $this -> db -> executeDataTable($sql) ;
	  foreach($data as $k=>$v){
		  $content = file_get_contents(iconv_str(RTC_CONSOLE.'/'.$data[$k]['filpath'],"utf-8","gbk"));
		  $newfile = $this->target_dir.'/'. $this->target;
		  $newfile = iconv_str($newfile,"utf-8","gbk");
		  if(!file_exists($newfile)){
		  $fd = fopen($newfile, "w+");
		  }else{
		  $fd = fopen($newfile, "a");
		  }
		  fwrite($fd, $content); // 将切块合并到一个文件
	  }
	  
//      for($i=0; $i< $this->totalBlobNum; $i++){
//		$content = file_get_contents(iconv_str($this->target_dir.'/'.$this->context.'/'. $this->fileName.'__'.$i,"utf-8","gbk"));
//		if(!file_exists(iconv_str($this->target_dir.'/'. $this->target,"utf-8","gbk"))){
//		$fd = fopen(iconv_str($this->target_dir.'/'. $this->target,"utf-8","gbk"), "w+");
//		}else{
//		$fd = fopen(iconv_str($this->target_dir.'/'. $this->target,"utf-8","gbk"), "a");
//		}
//		fwrite($fd, $content); // 将切块合并到一个文件上
//      }
      $this->deleteFileBlob();
  }
  
  //删除文件块
  function deleteFileBlob(){
	  $pathdata = array ();
	  $sql = " select * from MD5BigFile where Context='".g("context")."'";
	  $data = $this -> db -> executeDataTable($sql) ;
	  foreach($data as $k=>$v){
		  $filpath=dirname(RTC_CONSOLE.'/'.$data[$k]['filpath']);
		  if(!in_array($filpath,$pathdata)) array_push($pathdata,$filpath);
		  @unlink(iconv_str(RTC_CONSOLE.'/'.$data[$k]['filpath'],"utf-8","gbk"));
	  }
	  foreach($pathdata as $k=>$v){
		  @rmdir(iconv_str($v,"utf-8","gbk"));
	  }
	  $this -> delete_db(1);
//    for($i=0; $i< $this->totalBlobNum; $i++){
//      @unlink(iconv_str($this->target_dir.'/'.$this->context.'/'. $this->fileName.'__'.$i,"utf-8","gbk"));
//    }
//	@rmdir(iconv_str($this->target_dir.'/'.$this->context,"utf-8","gbk"));
  }
  
  function save_file($target_file,$filename,$filesize,$parent_type,$parent_id,$root_id,$FormFileType,$blobNum,$context)
  {	
//	  $default_dir = RTC_CONSOLE . "/" . $target_file;
//	  $default_dir = iconv_str($default_dir,"utf-8","gbk");
	  $data = $this -> db -> executeDataRow("select * from MD5BigFile where Context='" . $context . "' and BlobNum=".$blobNum);
	  if (count($data)==0){
		  $file_item = array();
		  $file_item["MyID"] = CurUser::getUserId() ;
		  $file_item["FormFileType"] = $FormFileType ;
		  $file_item["TypePath"] = $filename ;
		  $file_item["PcSize"] = $filesize ;
		  $file_item["FilPath"] = $target_file ;
		  $file_item["BlobNum"] = $blobNum ;
		  $file_item["Context"] = $context ;
		  $doc_file = new Model("MD5BigFile");
		  $doc_file -> clearParam();
		  $doc_file -> addParamFields($file_item);
		  $doc_file -> insert();
	  }

  }
  
  function delete_db($FormFileType)
  {
	  $arr_sql = array();
	  $arr_sql[] = " delete from MD5BigFile where FormFileType=" . $FormFileType . " and Context='".g("context")."'" ;
	  return $this -> db -> execute($arr_sql) > 0 ?1:0 ;

  }
}
?>