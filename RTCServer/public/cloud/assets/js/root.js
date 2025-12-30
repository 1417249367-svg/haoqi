var root_list = new Array();

//添加到数组
function root_list_add(root_id,root_path)
{
	root_list[root_list.length] = {"root_id":root_id,"root_path":root_path} ;
}

//得到数据
function root_list_get(root_id)
{
	for(var i=0;i<root_list.length;i++)
	{
		if (root_list[i].root_id == root_id )
			return root_list[i] ;
	}
	return {"root_id":0,"root_path":""} ; ;
}



