<?php 

/*------------------------------------------- 
域操作
---------------------------------------------*/ 
class LdapHelper 
{ 

	private $ldapConnection;
	public $ldapBind;
	private $adminUsername = NULL;
	private $adminPassword = NULL;
	private $ldapHost;
	private $ldapBaseDN = "";
	public  $orgUnit = array();
	
	private $ldapAttrs = array (
					"displayname",
					"cn",
					"homephone",
					"samaccountname",
					"title",
					"telephonenumber",
					"mail",
					"userprincipalname"
			);
	
	function __construct($host,$user,$pswd) 
	{ 
		$this->ldapHost = $host;
		$this->adminUsername = $user;
		$this->adminPassword = $pswd;
		$this->ldapBaseDN = $this->get_base_dn();
	} 
	
	//建立连接
	function connect()
	{
		$this->ldapConnection = ldap_connect ( $this->ldapHost );
		if( !$this->ldapConnection )
			recordLog("Ldap服务器连接失败");
			
		ldap_set_option ( $this->ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3 );
		ldap_set_option ( $this->ldapConnection, LDAP_OPT_REFERRALS, 0 );	
		$this->ldapBind = ldap_bind ( $this->ldapConnection, $this->adminUsername . "@" . $this->ldapHost, $this->adminPassword );
		if (!$this->ldapBind) {
			recordLog("Bind to Active Directory failed. Either the LDAPs connection failed or the login credentials are incorrect. AD said: " . $this->getLastError () );
		}		
	}
	
	
	//列出用户
	function list_user($dn = "")
	{
		
		$this->connect();
		if($dn == "")
			$dn = $this->ldapBaseDN;
		recordLog($dn);
		$filter = "(objectclass=user)";
		
		$data = ldap_search ( $this->ldapConnection, $dn, $filter, $this->ldapAttrs, 0, 0, 0 ) or die ( "ldap search failed" );
		
		$data = ldap_get_entries ( $this->ldapConnection, $data );
		
		$count = $data['count'];
		
		if($count > 0)
		{
			for($i=0;$i<$count;$i++)
			{
				$users[$i] = array($this->dn2path( $data[$i]['dn'],true),$data[$i]['samaccountname'][0],$data[$i]['displayname'][0],"1",$data[$i]['description'][0],$data[$i]['telephonenumber'][0],$data[$i]['title'][0],"123");	
			}
		}
		else
		{
			$users = array();
		}
		return $users;
	}
	
	//列出组织单位
	function list_org($dn = "")
	{
		$this->connect();
		if($dn == "")
			$dn = $this->ldapBaseDN;
		$filter = "(objectclass=organizationalunit)";
		
		$data = ldap_search ( $this->ldapConnection, $dn, $filter, $this->ldapAttrs, 0, 0, 0 );
		$data = ldap_get_entries ( $this->ldapConnection, $data );
		
		$count = $data['count'];
		
		if($count > 0)
		{
			for($i=0;$i<$count;$i++)
			{
				$depts[$i] = $this->dn2path( $data[$i]['dn']);	
				$this->orgUnit[$i] = $data[$i]['dn'];
			}
		}
		else
		{
			$depts = array();
		}
		return $depts;
	}
	
	function get_base_dn()
	{
		$arr_temp = explode("." ,$this->ldapHost );
		$baseDN = "";
		
		foreach($arr_temp as $key=>$val)
		{
			if($baseDN != "")
				$baseDN .= "," ;
			$baseDN .= "DC=" . $val ;
		}
		
		recordLog($baseDN);
		
		return $baseDN;
	}
	
	//dn转化成path
	function dn2path($dn,$isUser=false)
	{
		$path = "";
		
		$dn = str_replace("," . $this->ldapBaseDN,"",$dn);

		
		$arr_ou = explode(",",$dn);
		
		$count = count($arr_ou);
		$j = 0;
		if($isUser)
			$j = 1;
		
		for($i=$count-1; $i >= $j; $i--)
		{
			$pos = strpos($arr_ou[$i],"CN=");
			if($pos <= 0)
			{
				$orgName = str_replace("OU=","",$arr_ou[$i]) ;
				if($path != "")
					$path .= "/";
				$path .= $orgName ;
			}
		}
		
		recordLog($path);
		//return $dn;
		
		return $path ;
	}

	
	//生成一个XML的内容
	function Export()
	{
		
	}
	
	//获取错误信息
	public function getLastError() {
		return @ldap_error ( $this->ldapConnection );
	}
	
	
	/**
	* 析构函数
	*/
	function __destruct() {
		$this->close ();
	}
	
	
	/**
	 * 关闭LDAP连接
	 * @return void
	 */
	public function close() {
		if ($this->ldapConnection) {
			@ldap_close ( $this->ldapConnection );
		}
	}
} 

?> 