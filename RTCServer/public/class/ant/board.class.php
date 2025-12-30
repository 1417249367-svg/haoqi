<?php
/**
 * 
 * User: linmao
 * Date: 15-9-2
 * Time: 上午9:34
 */

class Board extends Model{

    function __construct(){
		$this->tableName = "ant_board";
		$this->db = new DB ();
    }

    /**
     * 获取公告内容
     * @param unknown $id
     * @return Ambigous <string, unknown>
     */
	function get_boardcontent($id) {
 
 		if (! isPos($id,"{"))
			
			$id = "{" . $id . "}";
 
		$this->addParamWhere ( "col_id", $id );
		$row = $this->getDetail ();
		
		// 取出TEXT中的内容
		$content = $row ["col_content"];
		$datapath = date ( "Ymd", strtotime ( $row ["col_dt_create"] ) );
		
		// 格式转换
		$reader = new MsgReader ();
		
		
		$html = $reader->btf2html($content, $id, $datapath);
	
		
		return $html ;
	}
	
	
	/**
	 * 添加查询添加
	 * @param string $loginname
	 * @param string $node_id
	 * @return Ambigous <unknown, string>
	 */
	function get_wheresql($loginname = "",$node_id = "",$where="") {

		// 根据组织树查询(某部门创建的)
		if ($node_id != "") {
			// 根据部门查询
			$arr_node = explode ( "_", $node_id );
			if (count ( $arr_node ) > 3) {
				$emp_type = $arr_node [1];
				$emp_id = $arr_node [2];
				$ids = "";
				$relation = new EmpRelation ();
				$ids = $relation->getChildIds ( $emp_type, $emp_id, 1 );
				
				if ($ids == "")
					$ids = "0";
				
 
				$field_loginname = $this -> db->getSelectFieldAdd ( "col_loginname", "'" . BIGANT_DOMAIN . "'" );
				$where = getWhereSQL ( $where, " col_creator in(select " . $field_loginname . " from hs_user where col_id in(" . $ids . ")) " );
			}
			

			$where = getWhereSQL ( $where, " (col_ispublic=1 or col_creator='" . $loginname . "' or col_id in(select col_boardid from ant_board_visiter where col_hsitem='" . $loginname . "'))" );
		}
		
 
		return $where ;
 
	}
	
	
	/**
	 * 公告列表
	 * @param string $loginname
	 * @param string $node_id
	 * @param number $ispage
	 * @param number $pageIndex
	 * @param number $pageSize
	 * @return Ambigous <multitype:, number, void, boolean, multitype:multitype: , multitype:unknown , multitype:Ambigous <multitype:, string> >
	 */
	function get_boardlist($loginname = "",$node_id = "",$where = "",$ispage = 0 ,$pageIndex = 0,$pageSize = 0) {
		 
		$where = $this->get_wheresql ($loginname,$node_id,$where);
		
		$this->where ( $where );
		$this->order ( "col_id");
		
	
		if ($ispage == 0)
			$data = $this->getList ();
		else
			$data = $this->getPage ( $pageIndex, $pageSize );
		
		return $data ;
	}
	

	/**
	 * 根据帐号得到公告
	 * @param unknown $loginname
	 * @return unknown
	 */
	function get_list_byloginname($loginname) {
		 
		//loginname add domainname
		$loginname = userAppendDomain($loginname);
		
		$date = $this->db->getSelectDateField("col_dt_create");
		
		$where = 	" where col_ispublic=1 or " .
					" (col_ispublic=0 and col_id in(select col_boardid from ant_board_visiter where Col_HsItem = '".$loginname."' ))";
		$this->field = "col_id,col_creator_ID,col_creator_name,col_content,col_subject,col_dt_modify,$date,col_creator";
		$this->where ( $where );
		$this->order ( "col_dt_create desc");
		$data = $this->getList ();

		return $data ;
	}
	
}