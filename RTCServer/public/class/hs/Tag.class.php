<?php
/**
 * 群组管理

 * @date    20140410
 */
 
class Tag extends Model
{
	function __construct()
	{
		$this -> tableName = "HS_TAG" ;
		$this -> db = new DB();
	}
	


    function setTag($empType, $empIds, $tagIds,$flag)
    {
		$relation = new Model("hs_tag_data");

		$arr_empId = explode(",",$empIds);
		$field_other = array();
		foreach($arr_empId as $empId)
		{
			$field_keys = array("col_emp_type"=>$empType,"col_emp_id"=>$empId);
			$relation -> setRelationData($field_keys,"col_tag_id",$tagIds,$field_other,$flag);
		}
        return true;
    }

    /// <summary>
    /// 只返回TAG
    /// </summary>
    /// <param name="empType"></param>
    /// <param name="empId"></param>
    /// <returns></returns>
    function getTag($empType, $empId)
    {
        $sql = " select * from hs_tag where col_id in(select col_tag_id from hs_tag_data where col_emp_type=" . $empType . "  and col_emp_id=" . $empId . ")";
		$result = $this -> db -> executeDataTable($sql) ;
		return $result ;
    }

    /// <summary>
    /// 返回关联
    /// </summary>
    /// <param name="empType"></param>
    /// <param name="empIds"></param>
    /// <returns></returns>
    function getRelation($empType, $empIds)
    {
        if (empIds == "")
            return null;

        $sql = "select A.*,B.col_emp_type,B.col_emp_id from hs_tag A ,hs_tag_data  B " .
                " where B.col_emp_type=" . $empType . " and B.col_emp_id in(" . $empIds . ") and A.col_id=B.col_tag_id";

		$result = $this -> db -> executeDataTable($sql) ;
		return $result ;
    }
	

	

}
	
?>