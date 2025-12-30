(function($) {

$.fn.dataList = function(formatData,callback)
{

    var _ = this ;

    var param ;
    var cols = $("thead td",this).length ;
    var container_page ;
    var container_rows ;
    var container_text ;

    _.param = function(){
        return param ;
    }

    _.init = function(){
        param = _.getParam() ;

        if (cols > 0)
        {
            $("thead td",_).each(function(){
                var sortfield = $(this).attr("data-sortfield");
                if (sortfield != undefined)
                {
                    $(this).click(function(){
                        _.sort($(this).attr("data-sortfield"), $(this).attr("data-sortdir")) ;
                    })
                }
                $(this).attr("data-name",$(this).text());
            })
            container_text = "<tr><td colspan='" + cols + "'>{Content}</td></tr>" ;
            container_rows = $("tbody",_) ;
        }
        else
        {
            container_text = "<div>{Content}</div>" ;
            container_rows = $(_) ;

        }

        if (param.ispage)
        {
            container_page = $("<div class='text-center'></div>") ;
            $(_).after(container_page) ;
        }

        _.list() ;
    }


     _.list = function(){
		$("input[name=chk_All]").attr("checked",false);
        var url = param.listurl ;
        if (param.listurl == undefined)
            url = _.getUrl("list") ;
			//document.write(url+JSON.stringify(param));
        $(container_rows).html(container_text.replace("{Content}","<div class='loading'>" + langs.text_loading + "</div>") );
        $.ajax({
           type: "POST",
           url: url,
           data: param,
           dataType:"json",
           success: function(data){
                param.recordcount = data.recordcount ;
                //document.write(JSON.stringify(data));

                if (data.recordcount == 0)
                {
                    $(container_rows).html(container_text.replace("{Content}",langs.text_norecord) );
                    $(container_page).html("");
                    if (callback != undefined)
                        callback(data.rows,data.recordcount);
                }
                else
                {
                    if(param.tmpid == undefined)
                    {
                    	myAlert("tmpid is null") ;
                        return false ;
                    }

                    if (formatData != undefined)
                        data.rows = formatData(data.rows) ;

                    var html = $("#" + param.tmpid).tmpl(data.rows) ;

                    $(container_rows).html(html);

                    formatContainer(container_rows);
//document.write($(container_rows).html);
                    if (param.ispage == 1)
                        _.drawPager() ;

                    if (callback != undefined)
                        callback(data.rows,data.recordcount);
                }
           },
		   error:function(){
			   myAlert("load error");
		   }
        });
    }

    _.reload = function(){
        param = _.getParam() ;
        _.list();
    }
	
    _.query = function(query){
        $(_).attr("data-query",query) ;
    }

    _.search = function(wheresql){
        param.wheresql = wheresql ;
        param.pageindex = 1 ;
        $(_).attr("data-pageindex",param.pageindex) ;
        _.list();
    }

    _.page = function(_pageIndex){

        switch(_pageIndex)
        {
            case "first":
                _pageIndex = 1 ;
                break ;
            case "prev":
                _pageIndex = parseInt(param.pageindex) -1  ;
                break ;
            case "next":
                _pageIndex = parseInt(param.pageindex) + 1 ;
                break ;
            case "last":
                _pageIndex = Math.floor(param.recordcount / param.pagesize)+1 ;
                break ;
        }

        param.pageindex = _pageIndex ;

        $(_).attr("data-pageindex",param.pageindex) ;

        _.list();

        _.drawPager(_pageIndex,param.pagesize,param.recordcount) ;
    }

    _.sort = function(_sortfield,_sortdir){
        if (_sortfield == undefined)
            return ;

        if (_sortdir == undefined)
            _sortdir = 0 ;
        else
            _sortdir = parseInt(_sortdir) ;


        $("thead td",_).each(function(){
            var sortfield = $(this).attr("data-sortfield");
			if (sortfield == undefined)
				return ;
            var sortdir = $(this).attr("data-sortdir");
            if (_sortfield == sortfield)
            {
                var mySort = _sortdir==0?1:0 ;
                $(this).attr("data-sortdir",mySort) ;

                //format header
                $(this).html($(this).attr("data-name") + "<span class='sort-" + mySort + "'></span>");
            }
            else
            {
                $(this).html($(this).attr("data-name"));
            }

        })

        var sortexp = _sortfield + (_sortdir==0?"":" desc") ;
        param.fldsort = sortexp ;
        _.list() ;
    }

    _.getParam = function(){
        var wheresql = $(_).attr("data-where") ;
        var pagesize = $(_).attr("data-pagesize") ;
        var pageindex = $(_).attr("data-pageindex") ;
        var recordcount = $(_).attr("data-recordcount") ;
        var ispage = $(_).attr("data-ispage") ;
        if (wheresql == undefined)
            wheresql = "" ;
        if (pagesize == undefined)
            pagesize = 20 ;
        if (pageindex == undefined)
            pageindex = 1 ;
        if (recordcount == undefined)
            recordcount = 0 ;
        if (ispage == undefined)
            ispage = 1 ;

        var _param = {tmpid:$(_).attr("data-tmpid"),table:$(_).attr("data-table"),fldid:$(_).attr("data-fldid"),fldname:$(_).attr("data-fldname"),
        listurl:$(_).attr("data-listurl"),
        fldlist:$(_).attr("data-fldlist"),fldsort:$(_).attr("data-fldsort"),fldsortdesc:$(_).attr("data-fldsortdesc"),
        wheresql:wheresql,pageindex:pageindex,pagesize:pagesize,recordcount:recordcount,ispage:ispage}

        return _param ;
    }

    _.drawPager = function(){

		var drawpage = $(_).attr("drawpage") ;
		if (drawpage == 0)
			return ;

        var pageCount = Math.floor(param.recordcount / param.pagesize) ;
        var firstPage = 1;
        var lastPage = 1;
        var maxPages = 15 ;
        var html = "";

        if (param.recordcount == 0)
        {
            $(container_page).html("");
        }

        if (param.recordcount % param.pagesize > 0)
            pageCount = pageCount + 1 ;

        lastPage = pageCount;

        if (pageCount > maxPages)
        {
            if (param.pageindex < maxPages)
                lastPage = maxPages;
            else
            {
                var n = (param.pageindex - maxPages) / 10 + 1;
                firstPage = 10 * n;
                lastPage = maxPages + 10 * n;

            }
        }

        if (lastPage > pageCount)
            lastPage = pageCount;


		html += "<li " + ((param.pageindex == firstPage)?"class='disabled'":"")+ "><a href='#'  data-pagenum='first'>&laquo;</a></li>" ;

        for (var i = firstPage; i <= lastPage; i++)
			html += "<li " + ((i == param.pageindex)?"class='active'":"")+ "><a href='#'  data-pagenum='" + i + "'>" + i + "</a></li>" ;

		html += "<li " + ((param.pageindex == pageCount)?"class='disabled'":"")+ "><a href='#'  data-pagenum='last'>&raquo;</a></li>" ;


        html = "<ul class='pagination'>" + html + "</ul>";
		$(".pagination").remove();
        $(container_page).html(html) ;

        $("a",container_page).click(function(){
            _.page($(this).attr("data-pagenum")) ;
        })
    }

    _.del = function(id,_opt)
    {
       param.id = id ;
	   
	   if (_opt != undefined)
	   	param = jQuery.extend(param,_opt);

       var url = _.getUrl("delete") ;
	   //document.write(url+JSON.stringify(param));
       $.ajax({
           type: "POST",
           dataType:"json",
           data:param,
           url: url,
           success: function(result){
			   //alert(JSON.stringify(result));
                if (result.status)
				{
					/*
					if (id.toString().indexOf("{")>-1)
						_.reload();
					else
						removeRows(id);
					*/
				    _.reload();
				}
				else
					myAlert(getErrorText(result.errnum));
           },
           error:function(){
        	   myAlert("delete ajax error");
           }

       });

    }

    //???
    _.setValue = function(fldName,fldValue,id)
    {
       param.id = id ;
       param.fldname = fldName ;
       param.fldvalue = fldValue ;
       var url = _.getUrl("setvalue") ;

       $.ajax({
           type: "POST",
           dataType:"json",
           data:param,
           url: url,
           success: function(result){
                if (result.status)
				{
				    _.reload();
				}
				else
					myAlert(" set fail");
           },
           error:function(){
        	   myAlert("set ajax error");
           }
       });
    }
	
    _.setSwitch = function(id,fldName,e)
    {
       var fldValue = $(e).attr("data-value") == "1"?0:1 ;
       param.id = id ;
       param.fldname = fldName ;
       param.fldvalue = fldValue  ;
       var url = _.getUrl("setvalue") ;
	   //document.write(url+JSON.stringify(param));
       $.ajax({
           type: "POST",
           dataType:"json",
           data:param,
           url: url,
           success: function(result){
                $(e).attr("data-value",fldValue)  ;
                $(e).attr("class",$(e).attr("class").substring(0,10) + fldValue)  ;
           },
           error:function(){
        	   myAlert("set ajax error");
           }
       });
    }
	
    _.setradioSwitch = function(id,fldName,e)
    {
       var fldValue = 1 ;
       param.id = id ;
       param.fldname = fldName ;
       param.fldvalue = fldValue  ;
       var url = _.getUrl("setvalue") ;
	   //document.write(url+JSON.stringify(param));
       $.ajax({
           type: "POST",
           dataType:"json",
           data:param,
           url: url,
           success: function(result){
				$("input[name='defaultrole'][data-value='1']").attr("data-value", 0);
                $(e).attr("data-value",fldValue)  ;
				dataList.reload();
                //$(e).attr("class",$(e).attr("class").substring(0,10) + fldValue)  ;
           },
           error:function(){
        	   myAlert("set ajax error");
           }
       });
    }
	
    _.setradioSwitch1 = function(id,fldName,e)
    {
       var fldValue = 1 ;
       param.id = id ;
       param.fldname = fldName ;
       param.fldvalue = fldValue  ;
       var url = _.getUrl("setdefaultvalue") ;
	   //document.write(url+JSON.stringify(param));
       $.ajax({
           type: "POST",
           dataType:"json",
           data:param,
           url: url,
           success: function(result){
				$("input[name='defaultrole'][data-value='1']").attr("data-value", 0);
                $(e).attr("data-value",fldValue)  ;
				dataList.reload();
                //$(e).attr("class",$(e).attr("class").substring(0,10) + fldValue)  ;
           },
           error:function(){
        	   myAlert("set ajax error");
           }
       });
    }


    _.batchSwitch = function(title,field)
    {
        batch_switch(title,field,param.table, param.fldid);
    }

    _.swapUp = function(fld_name,attr_name,e)
    {
        _.swap("up",fld_name,attr_name,e);
    }
    _.swapDown = function(fld_name,attr_name,e)
    {
        _.swap("down",fld_name,attr_name,e);
    }
    _.swap = function(direct,fld_name,attr_name,e)
    {
		var curr_row,swap_row,rows;
		curr_row = $(e).parent().parent() ;
		rows = $("tr",$(curr_row).parent());

		if (direct == "up")
		{
			swap_row = $(curr_row).prev();

			if ($(swap_row).html() == undefined)
				swap_row = rows[rows.length-1] ;
		}
		else
		{
			swap_row = $(curr_row).next();
			if ($(swap_row).html() == undefined)
				swap_row = rows[0] ;
		}

	   param.fldswap = fld_name;
       param.curr_id = $(curr_row).attr("data-id") ;
       param.curr_value = $(curr_row).attr(attr_name) ;
       param.swap_id = $(swap_row).attr("data-id") ;
       param.swap_value = $(swap_row).attr(attr_name) ;
       var url = _.getUrl("swap") ;
	   //document.write(url+JSON.stringify(param));
       $.ajax({
           type: "POST",
           dataType:"json",
           data:param,
           url: url,
           success: function(result){
                _.reload();
           },
           error:function(){
        	   myAlert("set ajax error");
           }
       });

    }




    _.getUrl = function(op)
    {
        var obj = $(_).attr("data-obj") ;
        if (obj == undefined)
            obj = "db" ;
        var query = $(_).attr("data-query") ;

        if (query == undefined)
            query = "" ;

        return getAjaxUrl(obj,op,query) ;
    }

    _.init() ;

    return _ ;

}

})(jQuery);


function getLikeSQL(fields,key)
{

    var arrFields = fields.split(",");
    var whereKey = "" ;
    for(var i=0;i<arrFields.length;i++)
    {
        if (whereKey != "")
            whereKey += " or " ;

         whereKey += "(" + arrFields[i] + " like '%" + key + "%' )" ;
    }

    if (arrFields.length > 1)
        whereKey = "(" + whereKey + ")" ;

    return whereKey ;
}


var ids = ""
function batch_switch(title,fldname,table,fldid)
{
    ids = getSelectedId() ;
    if (ids == "")
	    return ;
    dialog("switchpicker",title,"../include/switch_picker.html?table=" + table + "&fldid=" + fldid + "&fldname=" + fldname + "&ids=" + ids ) ;
}

function batch_switch_submit(table,fldid,fldname,fldvalue,ids)
{
   var url = getAjaxUrl("db","setvalue") ;
   var data = {table:table,fldid:fldid,fldname:fldname,fldvalue:fldvalue,id:ids} ;
   $.ajax({
       type: "POST",
       dataType:"json",
       url: url,
       data:data,
       success: function(result){
            dialogClose("switchpicker");
            if (result.status)
                dataList.reload();
            else
                myAlert(result.msg);
       }
   });
}

function removeRows(ids)
{
	ids = ids.toString();
	var str = replaceAll(ids,",",",.row-") ;
	//str = replaceAll(ids,"'","")
	str = ".row-" + str ;
	//alert(str);
	$(str).fadeOut();
}

var id = "" ;
function data_delete(_id)
{
   id = getSelectedId(_id) ;
   if (id == "")
		return ;
	if (confirm(langs.text_delete_confirm))
		dataList.del(id) ;
}