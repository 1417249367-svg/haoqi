/**

 @Name：layim mobile 2.2.0
 @Author：贤心
 @Site：http://layim.layui.com
 @License：LGPL
    
 */
 
layui.define(['laytpl', 'upload', 'layer-mobile', 'zepto'], function(exports){
  
  var v = '2.2.0';
  var $ = layui.zepto;
  var laytpl = layui.laytpl;
  var layer = layui['layer-mobile'];
  var device = layui.device();
  
  var SHOW = 'layui-show', THIS = 'layim-this', MAX_ITEM = 100;

  //回调
  var call = {};
  
  //对外API
  var LAYIM = function(){
    this.v = v;
    touch($('body'), '*[layim-event]', function(e){
      var othis = $(this), methid = othis.attr('layim-event');
      events[methid] ? events[methid].call(this, othis, e) : '';
    });
  };
  
  //避免tochmove触发touchend
  var touch = function(obj, child, fn){
    var move, type = typeof child === 'function', end = function(e){
      var othis = $(this);
      if(othis.data('lock')){
        return;
      }
      move || fn.call(this, e);
      move = false;
      othis.data('lock', 'true');
      setTimeout(function(){
        othis.removeAttr('data-lock');
      }, othis.data('locktime') || 0);
    };

    if(type){
      fn = child;
    }

    obj = typeof obj === 'string' ? $(obj) : obj;

    if(!isTouch){
      if(type){
       obj.on('click', end);
      } else {
        obj.on('click', child, end);
      }
      return;
    }

    if(type){
      obj.on('touchmove', function(){
        move = true;
      }).on('touchend', end);
    } else {
      obj.on('touchmove', child, function(){
        move = true;
      }).on('touchend', child, end);
    }
  };
  
  //是否支持Touch
  var isTouch = /Android|iPhone|SymbianOS|Windows Phone|iPad|iPod/.test(navigator.userAgent);
  
  //底部弹出
  layer.popBottom = function(options){
    layer.close(layer.popBottom.index);
    layer.popBottom.index = layer.open($.extend({
      type: 1
      ,content: options.content || ''
      ,shade: false
      ,className: 'layim-layer'
    }, options));
  };
  
  //基础配置
  LAYIM.prototype.config = function(options){
    options = options || {};
    options = $.extend({
      title: '好奇鸟客服'
      ,isgroup: 0
      ,isNewFriend: !0
      ,voice: 'default.mp3'
      ,chatTitleColor: '#36373C'
    }, options);
    init(options);
  };
  
  //监听事件
  LAYIM.prototype.on = function(events, callback){
    if(typeof callback === 'function'){
      call[events] ? call[events].push(callback) : call[events] = [callback];
    }
    return this;
  };
  
  //打开一个自定义的会话界面
  LAYIM.prototype.chat = function(data){
    if(!window.JSON || !window.JSON.parse) return;
	//console.log(JSON.stringify(data));
    return popchat(data, -1), this;
  };
  
  //打开一个自定义面板
  LAYIM.prototype.panel = function(options){
    return popPanel(options);
  };

  //获取所有缓存数据
  LAYIM.prototype.cache = function(){
    return cache;
  };

  LAYIM.prototype.sendMessage1 = function(data){
    return sendMessage1(data), this;
  };
  //接受消息
  LAYIM.prototype.getMessage = function(data){
    return getMessage(data), this;
  };
  
  LAYIM.prototype.sysMessage = function(data){
    return sysMessage(data), this;
  };
  
  LAYIM.prototype.getchatRo = function(data){
    return getchatRo(data), this;
  };
  
//  LAYIM.prototype.getchatHistory = function(data){
//    return getchatHistory(data), this;
//  };
  
  LAYIM.prototype.getRate = function(data){
    return getRate(), this;
  };
  
  LAYIM.prototype.Retractmessage = function(data){
	return Retractmessage(data), this;
  };
  
  LAYIM.prototype.replacemessage = function(data){
	return replacemessage(data), this;
  };
  
  LAYIM.prototype.Retractallmessage = function(data){
	return Retractallmessage(data), this;
  };
  //添加好友/群
  LAYIM.prototype.addList = function(data){
    return addList(data), this;
  };
  
  //删除好友/群
  LAYIM.prototype.removeList = function(data){
    return removeList(data), this;
  };
  
  //设置好友在线/离线状态
  LAYIM.prototype.setFriendStatus = function(id, type){
    var list = $('.layim-friend'+ id);
    list[type === 'online' ? 'removeClass' : 'addClass']('layim-list-gray');
  };
  
  //设置当前会话状态
  LAYIM.prototype.setChatStatus = function(str){
    var thatChat = thisChat(), status = thatChat.elem.find('.layim-chat-status');
    return status.html(str), this;
  };
  
  //标记新动态
  LAYIM.prototype.showNew = function(alias, show){
    showNew(alias, show);
  };
  
  //解析聊天内容
  LAYIM.prototype.content = function(content){
    return layui.data.content(content);
  };
  
  //列表内容模板
  var listTpl = function(options){
    var nodata = {
      friend: "该分组下暂无好友"
      ,group: "暂无群组"
      ,history: "暂无任何消息"
    };

    options = options || {};
    
    //如果是历史记录，则读取排序好的数据
    if(options.type === 'history'){
      options.item = options.item || 'd.sortHistory';
	  //console.log(JSON.stringify(options.item));
    }
	if(options.type === 'history'){
    return ['{{# var length = 0; layui.each('+ options.item +', function(i, data){ length++; }}'
      ,'<li layim-event="chat" data-type="'+ options.type +'" data-index="'+ (options.index ? '{{'+ options.index +'}}' : (options.type === 'history' ? '{{data.type}}' : options.type) +'{{data.id}}') +'" class="layim-'+ (options.type === 'history' ? '{{data.type}}' : options.type) +'{{data.id}} {{ data.status === "offline" ? "layim-list-gray" : "" }}"><div><img src="{{data.lv_chater_ro_to_type == 1 ? "assets/img/default.png" : get_download_url1(data.avatar)}}"></div><span>{{data.lv_chater_ro_to_type == 1 ? data.groupname : data.name}}</span><p>{{ data.remark||data.sign||"" }}</p><span class="layim-msg-status">new</span></li>'
    ,'{{# }); if(length === 0){ }}'
      ,'<li class="layim-null">'+ (nodata[options.type] || "暂无数据") +'</li>'
    ,'{{# } }}'].join('');
	}else{
    return ['{{# var length = 0; layui.each('+ options.item +', function(i, data){ length++; }}'
      ,'<li layim-event="chatRo" data-type="'+ options.type +'" data-index="'+ (options.index ? '{{'+ options.index +'}}' : (options.type === 'history' ? '{{data.type}}' : options.type) +'{{data.id}}') +'" class="layim-'+ (options.type === 'history' ? '{{data.type}}' : options.type) +'{{data.id}} {{ data.status === "offline" ? "layim-list-gray" : "" }}"><div><img src="{{data.avatar}}"></div><span>{{ data.username||data.groupname||data.name||"佚名" }}</span><p>{{ data.remark||data.sign||"" }}</p><span class="layim-msg-status">new</span></li>'
    ,'{{# }); if(length === 0){ }}'
      ,'<li class="layim-null">'+ (nodata[options.type] || "暂无数据") +'</li>'
    ,'{{# } }}'].join('');
	}
  };
  
  //公共面板
  var comTpl = function(tpl, anim, back){
    return ['<div class="layim-panel'+ (anim ? ' layui-m-anim-left' : '') +'">'
      ,'<div class="layim-title" style="background-color: {{d.base.chatTitleColor}};">'
        ,'<p>'
          ,(back ? '<i class="layui-icon layim-chat-back" layim-event="back">&#xe603;</i>' : '') 
          ,'{{ d.title || d.base.title }}<span class="layim-chat-status"></span><span id="robotlogo" style="display:none;"><img src="/livechat/assets/img/robot1.png" align="middle" class="photo" /></span>'
          ,'{{# if(d.data){ }}'
            ,'{{# if(d.data.type === "group"){ }}'
              ,'<i class="layui-icon layim-chat-detail" layim-event="detail">&#xe613;</i>'
            ,'{{# } }}'
          ,'{{# } }}'
        ,'</p>'
      ,'</div>'
      ,'<div class="layui-unselect layim-content">'
        ,tpl
      ,'</div>'
    ,'</div>'].join('');
  };
  
  //主界面模版
  var elemTpl = ['<div class="layui-layim">'
//    ,'<div class="layim-tab-content layui-show">'
//      ,'<ul class="layim-list-friend">'
//        ,'<ul class="layui-layim-list layui-show layim-list-history">'
//        ,listTpl({
//          type: 'history'
//        })
//        ,'</ul>'
//      ,'</ul>'
//    ,'</div>'
    ,'<div class="layim-tab-content layui-show">'
//      ,'<ul class="layim-list-top">'
//        ,'{{# if(d.base.isNewFriend){ }}'
//        ,'<li layim-event="newFriend"><i class="layui-icon">&#xe654;</i>新的朋友<i class="layim-new" id="LAY_layimNewFriend"></i></li>'
//        ,'{{# } if(d.base.isgroup){ }}'
//        ,'<li layim-event="group"><i class="layui-icon">&#xe613;</i>群聊<i class="layim-new" id="LAY_layimNewGroup"></i></li>'
//        ,'{{# } }}'
//      ,'</ul>'
      ,'<ul class="layim-list-friend">'
        ,'{{# layui.each(d.friend, function(index, item){ var spread = d.local["spread"+index]; }}'
        ,'<li>'
//          ,'<h5 layim-event="spread" lay-type="{{ spread }}"><i class="layui-icon">{{# if(spread === "true"){ }}&#xe61a;{{# } else {  }}&#xe602;{{# } }}</i><span>{{ item.groupname||"未命名分组"+index }}</span><em>(<cite class="layim-count"> {{ (item.list||[]).length }}</cite>)</em></h5>'
          ,'<ul class="layui-layim-list layui-show">'
            ,listTpl({
              type: "friend"
              ,item: "item.list"
              ,index: "index"
            })
          ,'</ul>'
        ,'</li>'
        ,'{{# }); if(d.friend.length === 0){ }}'
        ,'<li><ul class="layui-layim-list layui-show"><li class="layim-null">暂无联系人</li></ul>'
      ,'{{# } }}'
      ,'</ul>'
    ,'</div>'
//    ,'<div class="layim-tab-content">'
//      ,'<ul class="layim-list-top">'
//        ,'{{# layui.each(d.base.moreList, function(index, item){ }}'
//        ,'<li layim-event="moreList" lay-filter="{{ item.alias }}">'
//          ,'<i class="layui-icon {{item.iconClass||\"\"}}">{{item.iconUnicode||""}}</i>{{item.title}}<i class="layim-new" id="LAY_layimNew{{ item.alias }}"></i>'
//        ,'</li>'
//        ,'{{# }); if(!d.base.copyright){ }}'
//        ,'<li layim-event="about"><i class="layui-icon">&#xe60b;</i>关于<i class="layim-new" id="LAY_layimNewAbout"></i></li>'
//        ,'{{# } }}'
//      ,'</ul>'
//    ,'</div>'
  ,'</div>'
  ,'<ul class="layui-unselect layui-layim-tab">'
//    ,'<li title="消息" layim-event="tab" lay-type="message" class="layim-this"><i class="layui-icon">&#xe611;</i><span>消息</span><i class="layim-new" id="LAY_layimNewMsg"></i></li>'
    ,'<li title="客服" layim-event="tab" lay-type="friend" class="layim-this"><i class="layui-icon">&#xe612;</i><span>客服</span><i class="layim-new" id="LAY_layimNewList"></i></li>'
//    ,'<li title="更多" layim-event="tab" lay-type="more"><i class="layui-icon">&#xe670;</i><span>更多</span><i class="layim-new" id="LAY_layimNewMore"></i></li>'
  ,'</ul>'].join('');
  
  var elemHistoryTpl = ['<div class="layui-layim">'
    ,'<div class="layim-tab-content layui-show">'
      ,'<ul class="layim-list-friend">'
        ,'<ul class="layui-layim-list layui-show layim-list-history">'
        ,listTpl({
          type: 'history'
        })
        ,'</ul>'
      ,'</ul>'
    ,'</div>'
	
//    ,'<div class="layim-tab-content layui-show">'
////      ,'<ul class="layim-list-top">'
////        ,'{{# if(d.base.isNewFriend){ }}'
////        ,'<li layim-event="newFriend"><i class="layui-icon">&#xe654;</i>新的朋友<i class="layim-new" id="LAY_layimNewFriend"></i></li>'
////        ,'{{# } if(d.base.isgroup){ }}'
////        ,'<li layim-event="group"><i class="layui-icon">&#xe613;</i>群聊<i class="layim-new" id="LAY_layimNewGroup"></i></li>'
////        ,'{{# } }}'
////      ,'</ul>'
//      ,'<ul class="layim-list-friend">'
//        ,'{{# layui.each(d.friend, function(index, item){ var spread = d.local["spread"+index]; }}'
//        ,'<li>'
////          ,'<h5 layim-event="spread" lay-type="{{ spread }}"><i class="layui-icon">{{# if(spread === "true"){ }}&#xe61a;{{# } else {  }}&#xe602;{{# } }}</i><span>{{ item.groupname||"未命名分组"+index }}</span><em>(<cite class="layim-count"> {{ (item.list||[]).length }}</cite>)</em></h5>'
//          ,'<ul class="layui-layim-list layui-show">'
//            ,listTpl({
//              type: "friend"
//              ,item: "item.list"
//              ,index: "index"
//            })
//          ,'</ul>'
//        ,'</li>'
//        ,'{{# }); if(d.friend.length === 0){ }}'
//        ,'<li><ul class="layui-layim-list layui-show"><li class="layim-null">暂无联系人</li></ul>'
//      ,'{{# } }}'
//      ,'</ul>'
//    ,'</div>'
//    ,'<div class="layim-tab-content">'
//      ,'<ul class="layim-list-top">'
//        ,'{{# layui.each(d.base.moreList, function(index, item){ }}'
//        ,'<li layim-event="moreList" lay-filter="{{ item.alias }}">'
//          ,'<i class="layui-icon {{item.iconClass||\"\"}}">{{item.iconUnicode||""}}</i>{{item.title}}<i class="layim-new" id="LAY_layimNew{{ item.alias }}"></i>'
//        ,'</li>'
//        ,'{{# }); if(!d.base.copyright){ }}'
//        ,'<li layim-event="about"><i class="layui-icon">&#xe60b;</i>关于<i class="layim-new" id="LAY_layimNewAbout"></i></li>'
//        ,'{{# } }}'
//      ,'</ul>'
//    ,'</div>'
  ,'</div>'].join('');
//  ,'<ul class="layui-unselect layui-layim-tab">'
//    ,'<li title="消息" layim-event="tab" lay-type="message" class="layim-this"><i class="layui-icon">&#xe611;</i><span>消息</span><i class="layim-new" id="LAY_layimNewMsg"></i></li>'
//    ,'<li title="客服" layim-event="tab" lay-type="friend" class="layim-this"><i class="layui-icon">&#xe612;</i><span>客服</span><i class="layim-new" id="LAY_layimNewList"></i></li>'
//    ,'<li title="更多" layim-event="tab" lay-type="more"><i class="layui-icon">&#xe670;</i><span>更多</span><i class="layim-new" id="LAY_layimNewMore"></i></li>'
//  ,'</ul>'].join('');
  
  //聊天主模板
  var elemChatTpl = ['<div class="layim-chat layim-chat-{{d.data.type}}">'
    ,'<div class="layim-chat-main">'
      ,'<ul></ul>'
    ,'</div>'
    ,'<div class="layim-chat-footer">'
      ,'<div class="layim-chat-send"><input type="text" autocomplete="off"><button class="layim-send layui-disabled" layim-event="send">'+langs.chat_send+'</button></div>'
      ,'<div class="layim-chat-tool" data-json="{{encodeURIComponent(JSON.stringify(d.data))}}">'
		,'<span class="layui-icon layim-tool-rec" title="语音消息" layim-event="recOpen">&#xe688;</span>'
        ,'<span class="layui-icon layim-tool-face" title="选择表情" layim-event="face">&#xe60c;</span>'
        ,'{{# if(d.base && d.base.uploadImage){ }}'
		//,(device.android && device.weixin ? '<span class="layui-icon layim-tool-image" title="上传图片" layim-event="image" data-btn="upfilebtnHide">&#xe60d;<input type="file" name="file" multiple accept="image/*"></span><span class="layui-icon layim-tool-image" title="上传视频" layim-event="image" data-btn="upvideobtnHide">&#xe660;<input type="file" name="file" multiple accept="video/*"></span>' : '<span class="layui-icon layim-tool-image" title="上传图片" layim-event="image" data-btn="upfilebtnHide">&#xe60d;<input type="file" name="file" multiple accept="image/*"></span>')
		,'<span class="layui-icon layim-tool-image" title="上传图片" layim-event="image" data-btn="upfilebtnHide">&#xe60d;<input type="file" name="file" multiple accept="image/*"></span><span class="layui-icon layim-tool-image" title="上传视频" layim-event="image" data-btn="upvideobtnHide">&#xe660;<input type="file" name="file" multiple accept="video/*"></span>'
		,'{{# } }}'
		 ,'<span class="layui-icon layim-tool-location" title="位置" layim-event="location">&#xe715;</span>'
		 ,'<span class="layui-icon layim-tool-addmenu" title="" layim-event="addmenu">&#xe619;</span>'
        ,'<input type="button" id="upfilebtnHide" style="display: none;"><input type="button" id="upvideobtnHide" style="display: none;"><input type="button" id="upfilesbtnHide" style="display: none;">'
         ,'{{# layui.each(d.base.tool, function(index, item){ }}'
        ,'<span class="layui-icon  {{item.iconClass||\"\"}} layim-tool-{{item.alias}}" title="{{item.title}}" layim-event="extend" lay-filter="{{ item.alias }}">{{item.iconUnicode||""}}</span>'
         ,'{{# }); }}'
      ,'</div>'
    ,'</div>'
  ,'</div>'].join('');
  
  //补齐数位
  var digit = function(num){
    return num < 10 ? '0' + (num|0) : num;
  };
  
  //转换时间
  layui.data.date = function(timestamp){
    var d = new Date(timestamp||new Date());
    return digit(d.getMonth() + 1) + '-' + digit(d.getDate())
    + ' ' + digit(d.getHours()) + ':' + digit(d.getMinutes());
  };
  
  //转换内容
  layui.data.content = function(content){
    //支持的html标签
    var html = function(end){
      return new RegExp('\\n*\\['+ (end||'') +'(pre|div|p|table|thead|th|tbody|tr|td|ul|li|ol|li|dl|dt|dd|h2|h3|h4|h5)([\\s\\S]*?)\\]\\n*', 'g');
    };
    content = (content||'').replace(/&(?!#?[a-zA-Z0-9]+;)/g, '&amp;')
    .replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/'/g, '&#39;').replace(/"/g, '&quot;') //XSS
    .replace(/@(\S+)(\s+?|$)/g, '@<a href="javascript:;">$1</a>$2') //转义@
    
    .replace(/face\[([^\s\[\]]+?)\]/g, function(face){  //转义表情
      var alt = face.replace(/^face/g, '');
      return '<img alt="'+ alt +'" title="'+ alt +'" src="' + faces[alt] + '">';
    })
    .replace(/img\[([^\s]+?)\]/g, function(img){  //转义图片
      return '<img class="layui-layim-photos" src="' + img.replace(/(^img\[)|(\]$)/g, '') + '">';
    })
    .replace(/file\([\s\S]+?\)\[[\s\S]*?\]/g, function(str){ //转义文件
      var href = (str.match(/file\(([\s\S]+?)\)\[/)||[])[1];
      var text = (str.match(/\)\[([\s\S]*?)\]/)||[])[1];
      if(!href) return str;
      return '<a class="layui-layim-file" href="'+ href +'" download target="_blank"><i class="layui-icon">&#xe61e;</i><cite>'+ (text||href) +'</cite></a>';
    })
    .replace(/audio\[([^\s]+?)\]/g, function(audio){  //转义音频
      return '<div class="layui-unselect layui-layim-audio" layim-event="playAudio" data-src="' + audio.replace(/(^audio\[)|(\]$)/g, '') + '"><i class="layui-icon">&#xe652;</i><p>音频消息</p></div>';
    })
    .replace(/video\[([^\s]+?)\]/g, function(video){  //转义音频
      return '<div class="layui-unselect layui-layim-video" layim-event="playVideo" data-src="' + video.replace(/(^video\[)|(\]$)/g, '') + '"><i class="layui-icon">&#xe652;</i></div>';
    })
    
    .replace(/a\([\s\S]+?\)\[[\s\S]*?\]/g, function(str){ //转义链接
      var href = (str.match(/a\(([\s\S]+?)\)\[/)||[])[1];
      var text = (str.match(/\)\[([\s\S]*?)\]/)||[])[1];
      if(!href) return str;
      return '<a href="'+ href +'" target="_blank">'+ (text||href) +'</a>';
    }).replace(html(), '\<$1 $2\>').replace(html('/'), '\</$1\>') //转移HTML代码
    .replace(/\n/g, '<br>') //转义换行 
    return content;
  };
  
  var elemChatMain = ['<li'
        ,'{{# if(d.msg_id){ }}'
        ,' id="message{{ d.msg_id }}"'
         ,'{{# }; }}'
    ,' class="layim-chat-li{{ d.mine ? " layim-chat-mine" : "" }}">'
    ,'<div class="layim-chat-user"><img src="{{ d.mine ? d.avatar||"assets/img/face.png" :(d.avatar ? get_download_url1(d.avatar) : "assets/img/default.png") }}" alt="{{ d.uid || d.id }}"><cite>'
      ,'{{ d.username||"佚名" }}'
    ,'</cite></div>'
	,'<div class="layim-chat-text{{ PastImgEx1(d.content||"&nbsp;",1) ? "" : " layim-chat-copy-text" }}">{{ PastImgEx(d.content||"&nbsp;",1) }}</div>'
	,'{{# if(d.mine){ }}'
	,'<div class="clearfix"><img id="IsReceipt{{ d.msg_id }}" style="float:right;{{ d.isreceipt ? "display:block;" : "display:none;" }}" src="/livechat/assets/img/icon-success.png"></div>'
	 ,'{{# }; }}'
  ,'</li>'].join('');
  
  //Ajax
  var post = function(options, callback, tips){
    options = options || {};
    return $.ajax({
      url: options.url
      ,type: options.type || 'get'
      ,data: options.data
      ,dataType: options.dataType || 'json'
      ,cache: false
      ,success: function(res){
        res.code == 0 
          ? callback && callback(res.data||{})
        : layer.msg(res.msg || ((tips||'Error') + ': LAYIM_NOT_GET_DATA'), {
          time: 5000
        });
      },error: function(err, msg){
        window.console && console.log && console.error('LAYIM_DATE_ERROR：' + msg);
      }
    });
  };
  //处理初始化信息
  var cache = {message: {}, chat: []}, init = function(options){
    var init = options.init || {}
     mine = init.mine || {}
    ,local = layui.data('layim-mobile')[mine.id] || {}
    ,obj = {
      base: options
      ,local: local
      ,mine: mine
      ,history: local.history || []
    }, create = function(data){
      var mine = data.mine || {};
      var local = layui.data('layim-mobile')[mine.id] || {}, obj = {
        base: options //基础配置信息
        ,local: local //本地数据
        ,mine:  mine //我的用户信息
        ,friend: data.friend || [] //联系人信息
        ,group: data.group || [] //群组信息
        ,history: local.history || [] //历史会话信息
      };
      obj.sortHistory = sort(obj.history, 'historyTime');
      cache = $.extend(cache, obj);
	  //console.log(JSON.stringify(obj));
      popim(laytpl(comTpl(elemTpl)).render(obj));
      layui.each(call.ready, function(index, item){
        item && item(obj);
      });
    }, create2 = function(data){
      var mine = data.mine || {};
      //var local = cache.local || {}, obj = {
      var local = layui.data('layim-mobile')[mine.id] || {}, obj = {
        base: options //基础配置信息
        ,local: local //本地数据
        ,mine:  mine //我的用户信息
        ,friend: data.friend || [] //联系人信息
        ,group: data.group || [] //群组信息
        ,history: local.history || [] //历史会话信息
      };
      obj.sortHistory = sort(obj.history, 'historyTime');
      cache = $.extend(cache, obj);
	  //console.log(JSON.stringify(obj.history));
      popim(laytpl(comTpl(elemHistoryTpl)).render(obj));
      layui.each(call.ready, function(index, item){
        item && item(obj);
      });
    }, create1 = function(data){
      var mine = data.mine || {};
      var local = layui.data('layim-mobile')[mine.id] || {}, obj = {
        base: options //基础配置信息
        ,local: local //本地数据
        ,mine:  mine //我的用户信息
        ,friend: data.friend || [] //联系人信息
        ,group: data.group || [] //群组信息
        ,history: local.history || [] //历史会话信息
      };
      obj.sortHistory = sort(obj.history, 'historyTime');
      cache = $.extend(cache, obj);
	  //console.log(chater.loginname+'|'+typeid);
      //popim(laytpl(comTpl(elemTpl)).render(obj));
	  if(chater.loginname||typeid){
		var popchat_id=chater.username;
		if(!popchat_id) popchat_id='unknown';
		var data = {
		id: popchat_id
		,name: popchat_id
		,type: 'kefu' //friend、group等字符，如果是group，则创建的是群聊
		,avatar: 'assets/img/default.png'
		}
		popchat(data, true);
	  }
      layui.each(call.ready, function(index, item){
        item && item(obj);
      });
    };
    cache = $.extend(cache, obj);
    if(options.brief){
      return layui.each(call.ready, function(index, item){
        item && item(obj);
      });
    };
    if(ischathistory) create2(init);
	else create1(init);
	//init.url ? post(init, create, 'INIT') : create(init);
  };
  
  var getchatRo = function(data){
	  //console.log(JSON.stringify(data));
	switch (parseInt(data.objtype))
	{
		case 0:
			post(data, create, 'INIT');
			break; 
		case 1:
			create1(init);
			break; 
		case 2:
			create2(init);
			break ;
	} 
	
  };
  
//  var getchatHistory = function(data){
//	  console.log(JSON.stringify(data));
//    post(data, create2, 'INIT');
//  };
  
  var getRate = function(){
      var content = '';
      for(var i=0;i<5;i++){
         content += '<li>★</li>';
      }
      content = '<ul class="layui-layim-stars">'+ content +'</ul>';
      layer.popBottom({
        content: content
        ,success: function(elem){
          var list = $(elem).find('.layui-layim-stars').children('li');
          touch(list, function(){
			$('li').css('color', '#ADADAD');
			var index = $(this).index();

			for(var i = 1; i <= index+1; i++) {
				$('li:nth-child(' + i + ')').css('color', '#F0AD4E');
			}
			if (isPostRate)
			{
				myAlert(langs.lv_rate_error);
				events.rateHide();
				return false ;
			}
			var param = {chatId:chatId,rate:(index+1)};
			var url = getAjaxUrl("livechat_kf","PostRate") ;
			$.getJSON(url,param, function(result){
//				myAlert(langs.lv_rate_success);
//				layer.msg(langs.lv_rate_success);
				isPostRate = true ;
				events.rateHide();
			}); 
            return false;
          });
        }
      });
  };
    
  var getMenu = function(){
      var content = '<ul class="layui-layim-stars"><span class="layui-icon layim-tool-audio" title="语音通话" layim-event="startaudio">&#xe6fc;</span><span class="layui-icon layim-tool-video" title="视频通话" layim-event="startvideo">&#xe6ed;</span><span class="layui-icon layim-tool-image" title="发送文件" layim-event="image" data-btn="upfilesbtnHide">&#xe61d;<input type="file" name="file" multiple accept="*/*"></span><span class="layui-icon layim-tool-face" title="评价" layim-event="rate">&#xe67b;</span><span class="layui-icon layim-tool-transfer" title="" layim-event="transfer"></span></ul>';
      layer.popBottom({
        content: content
        ,success: function(elem){
			isgetMenu = true ;
			setBtn();
//          var list = $(elem).find('.layui-layim-stars').children('span');
//          touch(list, function(){
//			events.addmenuHide();
//            return false;
//          });
        }
      });
  };
	
  var Retractmessage = function(data){
    var thatChat = thisChat(), chatMain = thatChat.elem.find('.layim-chat-main');
    var file_container = chatMain.find('#message' + data.content); 
	file_container.removeClass("layim-chat-li").addClass("layim-chat-system");
	file_container.html('<span>'+ langs.Retract_success3 +'</span>');
	deleteChatlog(data);
  };
    
  var replacemessage = function(data){
	  //alert(JSON.stringify(data));
    var thatChat = thisChat(), chatMain = thatChat.elem.find('.layim-chat-main');
    var file_container = chatMain.find('#message' + data.msg_id); 
	$(".layim-chat-text",file_container).html(PastImgEx(data.content,1));
	replaceChatlog(data);
  };
  
  var Retractallmessage = function(data){
    var thatChat = thisChat(), chatMain = thatChat.elem.find('.layim-chat-main'), ul = thatChat.elem.find('.layim-chat-main ul');
//    var file_container = chatMain.find('#message' + data.content); 
//	file_container.removeClass("layim-chat-li").addClass("layim-chat-system");
	ul.html('<li class="layim-chat-system"><span>'+ langs.Retract_success5 +'</span></li>');
	deleteallChatlog(data);
  };
  //显示好友列表面板
  var layimMain, popim = function(content){
    return layer.open({
     type: 1
      ,shade: false
      ,shadeClose: false
      ,anim: -1
      ,content: content
      ,success: function(elem){
        layimMain = $(elem);
        fixIosScroll(layimMain.find('.layui-layim'));
        if(cache.base.tabIndex){
          events.tab($('.layui-layim-tab>li').eq(cache.base.tabIndex));
        }
      }
    });
  };
  
  //弹出公共面板
  var popPanel = function(options, anim){
    options = options || {};
    var data = $.extend({}, cache, {
      title: options.title||''
      ,data: options.data
    });
    return layer.open({
      type: 1
      ,shade: false
      ,shadeClose: false
      ,anim: -1
      ,content: laytpl(comTpl(options.tpl, anim === -1 ? false : true, mobileback)).render(data)
      ,success: function(elem){
        var othis = $(elem);
        othis.prev().find('.layim-panel').addClass('layui-m-anim-lout');
        options.success && options.success(elem);
        options.isChat || fixIosScroll(othis.find('.layim-content'));
		//if(isweixin) $('.layim-tool-location','.layim-chat-footer').show();
//		if(meetingurl.voiceVideoType){
//			$('.layim-tool-audio','.layim-chat-footer').hide();
//			$('.layim-tool-video','.layim-chat-footer').hide();
//		}
//		if(!ChatGPTTransferType){
//			$('.layim-tool-transfer','.layim-chat-footer').hide();
//		}
//		if(cookieHCID5){
//			 var transfer_image='<svg t="1676443186165" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2945" width="24" height="24"><path d="M233.984 531.456c6.656 0 11.776-5.12 11.776-11.776L245.76 302.592c0-3.072-1.536-6.144-3.584-8.704 51.712-97.792 155.648-160.256 268.8-160.256s217.088 62.464 268.8 160.768c-2.048 2.048-3.584 5.12-3.584 8.192l0 217.088c0 6.656 5.12 11.776 11.776 11.776 67.584 0 122.368-53.76 122.368-120.32 0-41.984-22.528-81.408-59.392-102.912-51.2-140.288-187.904-234.496-340.48-234.496S221.696 167.936 169.472 308.224C133.12 330.24 110.592 369.152 110.592 411.136 111.104 477.696 166.4 531.456 233.984 531.456z" p-id="2946"></path><path d="M755.712 633.856c-4.608-2.048-9.728-1.536-13.312 2.048-62.976 57.856-144.896 89.6-231.424 89.6-86.016 0-168.448-31.744-231.424-89.088-3.584-3.072-8.704-4.096-13.312-2.048-123.904 62.464-192.512 170.496-192.512 304.128 0 6.656 5.12 11.776 11.776 11.776l853.504 0c6.656 0 11.776-5.12 11.776-11.776C950.272 804.352 881.152 696.32 755.712 633.856zM885.248 892.416 141.824 892.416c13.824-90.624 76.288-156.672 129.536-187.904 71.68 51.712 147.456 74.752 244.224 74.752 84.48 0 178.176-31.744 240.64-81.408C825.856 738.304 878.592 819.2 885.248 892.416z" p-id="2947"></path><path d="M510.976 182.784c-138.752 0-251.904 110.592-251.904 246.784s113.152 247.296 251.904 247.296 251.392-111.104 251.392-247.296C762.368 293.376 649.728 182.784 510.976 182.784zM699.392 429.056c0 101.888-84.48 184.32-188.416 184.32s-188.416-82.944-188.416-184.32c0-99.84 86.528-184.32 188.416-184.32C614.4 244.736 699.392 327.168 699.392 429.056z" p-id="2948"></path></svg>';
//			 var transfer_title=langs.chart_artificial;
//			 $('#robotlogo').show();
//		}else{
//			var transfer_image='<svg t="1676443980835" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="10514" width="24" height="24"><path d="M923.8 767.1h-42.7V665.4c-8.7 8-17.5 16-26.2 23.5-29.5 25.7-54.3 44.2-73.1 53.2-12.2 5.9-24.7 11.8-41.4 19.7-65.5 31.1-95.4 45.7-130.8 64.6l-249.2 133c-19.7 10.5-41.7 15.9-64.1 15.9-20.4 0-40.6-4.5-59-13.3-35.6-16.9-62-49.7-72.5-89.8l-5.2-19.8c-5.5-21-16.7-55.6-33.7-103.4-34.7-76.6-63.5-132.6-86.2-167.5l-8.1-12.4c-6-9.2-4-21.6 4.7-28.4l36.2-28.5c27.3-21.5 43.2-53.3 44.2-87.9v-3.7c1.7-144 103.1-284.4 241.4-334.5C420.6 63.5 504.7 51 610.9 48.5 813.5 48.5 983.4 206.3 990 401c2.7 79.1-20.8 156.4-66.3 220.9v145.2z m23.6-364.5C941.5 231.3 790.9 91.4 611.6 91.3c-101.8 2.5-181.6 14.3-239 35.1-115 41.6-201.9 155.4-212.2 274.3 1.6 0 3.4 0.1 5.2 0.1 18 0.4 51.2 1.3 81.1 1.3 28.1 0.6 27.9 42.7-0.6 42.7-36-0.6-63-0.9-80.9-0.9h-7.4c-5.7 40.1-26.5 76.4-58.9 101.9L78 562.3c22.5 35.3 49.6 87.8 81.6 157.7 33.1 0.1 60.2-3.8 81.2-11.5 23-8.4 43.6-23.2 61.8-44.6 18.1-21.2 50.2 5 33 27-21.4 27.3-48.4 46.7-80.5 57.8-23.2 8-49.6 12.5-79.3 13.7 12 34.9 20.4 61.2 25.1 79.2l5.2 19.8c7.4 28.1 25.5 50.7 49.5 62.1 12.7 6.1 26.7 9.2 40.7 9.2 15.4 0 30.6-3.7 44-10.9l249.2-133c36.3-19.3 66.6-34.1 132.6-65.5 16.7-7.9 29.1-13.8 41.2-19.6 26.6-12.8 78.3-57.7 122.8-102.4 42-57.8 63.7-127.4 61.3-198.7z m-108 485.9L608.1 989.7c-10.8 4.7-23.4-0.2-28.1-11-4.7-10.8 0.2-23.4 11-28.1l230.1-100.7c-1-5.2-1.5-10.7-1.5-16.2 0-47.1 38.2-85.3 85.3-85.3s85.3 38.2 85.3 85.3c0 47.1-38.2 85.3-85.3 85.3-26.3 0.1-49.8-11.8-65.5-30.5z m65.5-12.1c23.6 0 42.7-19.1 42.7-42.7S928.5 791 904.9 791s-42.7 19.1-42.7 42.7 19.1 42.7 42.7 42.7zM599.4 598.9c-105.2 0-190.5-85.3-190.5-190.5s85.3-190.5 190.5-190.5 190.5 85.3 190.5 190.5-85.3 190.5-190.5 190.5z m0-42.7c81.7 0 147.9-66.2 147.9-147.9S681 260.5 599.4 260.5s-147.9 66.2-147.9 147.9 66.2 147.8 147.9 147.8z m0-105.4c-23.5 0-42.5-19-42.5-42.5s19-42.5 42.5-42.5 42.5 19 42.5 42.5c-0.1 23.5-19.1 42.5-42.5 42.5z m0-42.7c-0.1 0-0.2 0.1-0.2 0.2s0.1 0.2 0.2 0.2 0.2-0.1 0.2-0.2c-0.1-0.1-0.1-0.2-0.2-0.2z" fill="" p-id="10515"></path></svg>';
//			var transfer_title=langs.chart_robot;
//			$('#robotlogo').hide();
//		}
//		$('.layim-tool-transfer','.layim-chat-footer').attr("title",transfer_title);
//		$('.layim-tool-transfer','.layim-chat-footer').html(transfer_image);

        //查看大图
//        othis.on('touchstart', '.thumbpic', function(){
////          var src = this.src;
////		  alert(src);
////          //layerpic.close(popchat.photosIndex);
////          layer.photos({
////            photos: {
////              data: [{
////                "alt": "大图模式",
////                "src": src
////              }]
////            }
////            ,full:true
////			,anim: 5
////            ,success: function(index){
////				alert('ok');
////               //popchat.photosIndex = index;
////            }
////          });
//		  
//		  layerpic.photos({
//			//类选择器  选择图片的父容器	  
//			photos: '.layim-chat-main ul'
//			,full:true
//			,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
//		  });
//		  
//        });
		
      }
      ,end: options.end
    });
  }
  
  //显示聊天面板
  var layimChat, layimMin, To = {}, popchat = function(data, anim, back){
    data = data || {};
	//console.log(JSON.stringify(data));

    if(!data.id){
      return layer.msg('非法用户');
    }
    
    layer.close(popchat.index);

    return popchat.index = popPanel({
      tpl: elemChatTpl
      ,data: data
      ,title: data.name
      ,isChat: !0
      ,success: function(elem){
        layimChat = $(elem);

        hotkeySend();
        viewChatlog();
        
        delete cache.message[data.type + data.id]; //剔除缓存消息
        //showNew('Msg');
        
        //聊天窗口的切换监听
        var thatChat = thisChat(), chatMain = thatChat.elem.find('.layim-chat-main');
        layui.each(call.chatChange, function(index, item){
          item && item(thatChat);
        });
		
		//alert($('.layim-chat-main').html());
        
		fixIosScroll(chatMain);
        
        //输入框获取焦点
        thatChat.textarea.on('focus', function(){
          setTimeout(function(){
            chatMain.scrollTop(chatMain[0].scrollHeight + 1000);
          }, 500);
        });
		
		if(device.ios){
			//var is_wx=is_weixin();
			if(device.weixin){
				thatChat.textarea.on('blur', function(){
					window.parent.postMessage({
							  cmd: 'scrolltop',
							  params: ''
							}, '*');
				});
			}
		}
		chatMain.css("bottom","125px");
		$('.layim-chat-footer').css("bottom","40px");
		
      }
      ,end: function(){
        layimChat = null;
        sendMessage.time = 0;
      }
    }, anim);

  };
  
  //修复IOS设备在边界引发无法滚动的问题
  var fixIosScroll = function(othis){
    if(device.ios){
      othis.on('touchmove', function(e){
        var top = othis.scrollTop();
        if(top <= 0){ 
          othis.scrollTop(1);
          e.preventDefault(e);
        }
        if(this.scrollHeight - top - othis.height() <= 0){
          othis.scrollTop(othis.scrollTop() - 1);
          e.preventDefault(e);
        }
      });
    }
  };
  
  //同步置灰状态
  var syncGray = function(data){
    $('.layim-'+data.type+data.id).each(function(){
      if($(this).hasClass('layim-list-gray')){
        layui.layim.setFriendStatus(data.id, 'offline'); 
      }
    });
  };
  
  //获取当前聊天面板
  var thisChat = function(){
    if(!layimChat) return {};
    var cont = layimChat.find('.layim-chat');
    var to = JSON.parse(decodeURIComponent(cont.find('.layim-chat-tool').data('json')));
    return {
      elem: cont
      ,data: to
      ,textarea: cont.find('input')
    };
  };
  
  //将对象按子对象的某个key排序
  var sort = function(data, key, asc){
    var arr = []
    ,compare = function (obj1, obj2) { 
      var value1 = obj1[key]; 
      var value2 = obj2[key]; 
      if (value2 < value1) { 
        return -1; 
      } else if (value2 > value1) { 
        return 1; 
      } else { 
        return 0; 
      } 
    };
    layui.each(data, function(index, item){
      arr.push(item);
    });
    arr.sort(compare);
    if(asc) arr.reverse();
    return arr;
  };
  
  //记录历史会话
  var setHistory = function(data){
//console.log(JSON.stringify(data));
    var local = layui.data('layim-mobile')[cache.mine.id] || {};
    var obj = {}, history = local.history || {};
    var is = history[data.type + data.id];
    
	if(parseInt(data.isAppend)==2) return ;
	if(data.objtype) return ;
    if(data.system==true) return;

    //data.myid=cache.mine.id;
	data.historyTime = new Date().getTime();
	data.content = decodeUserText(data.content);
    data.sign = data.content;
//    data.typeid = typeid;
//	data.lv_chater_ro_to_type = chater.lv_chater_ro_to_type;
    history[data.type + data.id] = data;
  
    local.history = history;
	
	//console.log('mineid:'+JSON.stringify(cache.mine.id));
    
    layui.data('layim-mobile', {
      key: cache.mine.id
      ,value: local
    });
    
    if(!layimMain) return;
    var historyElem = layimMain.find('.layim-list-history');
    var msgItem = historyElem.find('.layim-'+ data.type + data.id)
    ,msgNums = (cache.message[data.type+data.id]||[]).length //未读消息数
    ,showMsg = function(){
      msgItem = historyElem.find('.layim-'+ data.type + data.id);
      msgItem.find('p').html(data.content);
      if(msgNums > 0){
        msgItem.find('.layim-msg-status').html(msgNums).addClass(SHOW);
      }
    };

    if(msgItem.length > 0){
      showMsg();
      historyElem.prepend(msgItem.clone());
      msgItem.remove();
    } else {
      obj[data.type + data.id] = data;
      var historyList = laytpl(listTpl({
        type: 'history'
        ,item: 'd.data'
      })).render({data: obj});
      historyElem.prepend(historyList);
      showMsg();
      historyElem.find('.layim-null').remove();
    }

    //showNew('Msg');
  };
  
  //标注底部导航新动态徽章
  var showNew = function(alias, show){
    if(!show){
      var show;
      layui.each(cache.message, function(){
        show = true;
        return false;
      });
    }
    $('#LAY_layimNew'+alias)[show ? 'addClass' : 'removeClass'](SHOW);
  };
  
  //发送消息
  var sendMessage = function(){
    var data = {
      username: cache.mine ? cache.mine.username : '访客'
      ,avatar: cache.mine ? cache.mine.avatar : (layui.cache.dir+'css/pc/layim/skin/logo.jpg')
      ,id: cache.mine ? cache.mine.id : null
      ,mine: true
    };
    var thatChat = thisChat(), ul = thatChat.elem.find('.layim-chat-main ul');
    var To = thatChat.data, maxLength = cache.base.maxLength || 3000;
    var time =  new Date().getTime(), textarea = thatChat.textarea;
	//console.log(JSON.stringify(cache.mine));
    data.msg_id = guid32();
    data.content = textarea.val();
	
//	if (!isConnected){
//      return layer.msg('您处于离线状态,不能发送消息!');
//    }
    
    if(data.content === '') return;

    if(data.content.length > maxLength){
      return layer.msg('内容最长不能超过'+ maxLength +'个字符')
    }
    
    if(time - (sendMessage.time||0) > 60*1000){
      ul.append('<li class="layim-chat-system"><span>'+ layui.data.date() +'</span></li>');
      sendMessage.time = time;
    }
	data.content = inputUText(data.content);
    ul.append(laytpl(elemChatMain).render(data));
	
	setTimeout(function(){
	  events.photos($('#message'+data.msg_id,ul));
	}, 500);
//	setTimeout(function(){
//			baguetteBox.run('.layim-chat-main ul');
//			if (typeof oldIE === 'undefined' && Object.keys) {
//				hljs.initHighlighting();
//			}
//			 }, 500);
    
    var param = {
      mine: data
      ,to: To
    }, message = {
	  msg_id: param.mine.msg_id
      ,username: param.mine.username
      ,avatar: param.mine.avatar
      ,id: To.id
      ,type: To.type
      ,content: param.mine.content
      ,timestamp: time
      ,mine: true
    };
    pushChatlog(message);
	
	m_sendMsg(message);
    
    layui.each(call.sendMessage, function(index, item){
      item && item(param);
    });
    
    To.content = data.content;
    setHistory(To);
    chatMain_scrollTop();

    textarea.val('');
    
    textarea.next().addClass('layui-disabled');
  };
  
  //发送消息
  var sendMessage1 = function(content){
    var data = {
      username: cache.mine ? cache.mine.username : '访客'
      ,avatar: cache.mine ? cache.mine.avatar : (layui.cache.dir+'css/pc/layim/skin/logo.jpg')
      ,id: cache.mine ? cache.mine.id : null
      ,mine: true
    };
    var thatChat = thisChat(), ul = thatChat.elem.find('.layim-chat-main ul');
    var To = thatChat.data, maxLength = cache.base.maxLength || 3000;
    var time =  new Date().getTime(), textarea = thatChat.textarea;
	//alert(JSON.stringify(thatChat));
    data.msg_id = guid32();
    data.content = content;
	
//	if (!isConnected){
//      return layer.msg('您处于离线状态,不能发送消息!');
//    }
    
    if(data.content === '') return;

    if(data.content.length > maxLength){
      return layer.msg('内容最长不能超过'+ maxLength +'个字符')
    }
    
    if(time - (sendMessage.time||0) > 60*1000){
      ul.append('<li class="layim-chat-system"><span>'+ layui.data.date() +'</span></li>');
      sendMessage.time = time;
    }
	data.content = inputUText(data.content);
    ul.append(laytpl(elemChatMain).render(data));
	
	setTimeout(function(){
	  events.photos($('#message'+data.msg_id,ul));
	}, 500);
    
    var param = {
      mine: data
      ,to: To
    }, message = {
	  msg_id: param.mine.msg_id
      ,username: param.mine.username
      ,avatar: param.mine.avatar
      ,id: To.id
      ,type: To.type
      ,content: param.mine.content
      ,timestamp: time
      ,mine: true
    };
    pushChatlog(message);
	
	m_sendMsg(message);
    
    layui.each(call.sendMessage, function(index, item){
      item && item(param);
    });
    
    To.content = data.content;
    setHistory(To);
    chatMain_scrollTop();
  };
  
  //消息声音提醒
  var voice = function() {
    var audio = document.createElement("audio");
    audio.src = layui.cache.dir+'css/modules/layim/voice/'+ cache.base.voice;
    audio.play();
  };
  
  //接受消息
  var messageNew = {}, getMessage = function(data){
    data = data || {};
    
    var group = {}, thatChat = thisChat(), thisData = thatChat.data || {}
    ,isThisData = thisData.id == data.id && thisData.type == data.type; //是否当前打开联系人的消息
    
    data.timestamp = data.timestamp || new Date().getTime();
    data.system || pushChatlog(data);
    //console.log(data)
    messageNew = JSON.parse(JSON.stringify(data));
    
	if(cache.base.voice){
      voice();
    }

    if((!layimChat && data.content) || !isThisData){
      if(cache.message[data.type + data.id]){
        cache.message[data.type + data.id].push(data)
      } else {
        cache.message[data.type + data.id] = [data];
      }
    }

    //记录聊天面板队列
    var group = {};
    if(data.type === 'friend'){
      var friend;
      layui.each(cache.friend, function(index1, item1){
        layui.each(item1.list, function(index, item){
          if(item.id == data.id){
            data.type = 'friend';
            data.name = item.username;
            return friend = true;
          }
        });
        if(friend) return true;
      });
      if(!friend){
        data.temporary = true; //临时会话
      }
    } else if(data.type === 'group'){
      layui.each(cache.group, function(index, item){
        if(item.id == data.id){
          data.type = 'group';
          data.name = data.groupname = item.groupname;
          group.avatar = item.avatar;
          return true;
        }
      });
    } else {
      data.name = data.name || data.username || data.groupname;
    }
    var newData = $.extend({}, data, {
      avatar: group.avatar || data.avatar
    });
    if(data.type === 'group'){
      delete newData.username;
    }
    //console.log('df:'+thisData.id +'|'+ data.id +'|'+ thisData.type +'|'+ data.type) ;
    setHistory(newData);
    
    if(!layimChat || !isThisData) return;

    var cont = layimChat.find('.layim-chat')
    ,ul = cont.find('.layim-chat-main ul');
    //系统消息
    if(data.system){
      ul.append('<li class="layim-chat-system"><span>'+ data.content +'</span></li>');
    } else if(data.content.replace(/\s/g, '') !== ''){
      if(data.timestamp - (sendMessage.time||0) > 60*1000){
        ul.append('<li class="layim-chat-system"><span>'+ layui.data.date(data.timestamp) +'</span></li>');
        sendMessage.time = data.timestamp;
      }
	  if($('#message'+data.msg_id,ul).length > 0) return ;
      ul.append(laytpl(elemChatMain).render(data));
	  
	  setTimeout(function(){
		events.photos($('#message'+data.msg_id,ul));
	  }, 500);
    }
    chatMain_scrollTop();
  };
  
  var sysMessage = function(data){
	data = data || {};

    var cont = layimChat.find('.layim-chat')
    ,ul = cont.find('.layim-chat-main ul');
    //系统消息
    if(data.system){
		if($('.msg-0',ul).length == 0) ul.html('<li class="layim-chat-system msg-0"><span>'+ data.content +'</span></li>');
		else $('.msg-0',ul).eq(0).html('<span>'+ data.content +'</span>');
    }
  };
  
  //存储最近MAX_ITEM条聊天记录到本地
  var pushChatlog = function(message){
	  //alert(message.type);
	if(message.objtype) return ;
    var local = layui.data('layim-mobile')[cache.mine.id] || {};
    var chatlog = local.chatlog || {};
	var messageid=message.id;
//	if(invite.chaterMode) var messageid=message.id;
//	else var messageid=cache.mine.id;
    if(chatlog[message.type + messageid]){
      chatlog[message.type + messageid].push(message);
      if(chatlog[message.type + messageid].length > MAX_ITEM){
        chatlog[message.type + messageid].shift();
      }
    } else {
      chatlog[message.type + messageid] = [message];
    }
	//alert(cache.mine.id);
    local.chatlog = chatlog;
    layui.data('layim-mobile', {
      key: cache.mine.id
      ,value: local
    });
  };
  
  var deleteChatlog = function(data){
	var thatChat = thisChat();
    var local = layui.data('layim-mobile')[cache.mine.id] || {};
    var chatlog = local.chatlog || {};
	var messageid=data.uid;
//	if(invite.chaterMode) var messageid=data.uid;
//	else var messageid=cache.mine.id;
    layui.each(chatlog[thatChat.data.type + messageid], function(index, item){
      if(data.content == item.msg_id){
		   chatlog[thatChat.data.type + messageid].splice(index,1);
	  }
    });
	local.chatlog = chatlog;
    layui.data('layim-mobile', {
      key: cache.mine.id
      ,value: local
    });
  };
  
  var replaceChatlog = function(message){
	var thatChat = thisChat();
    var local = layui.data('layim-mobile')[cache.mine.id] || {};
    var chatlog = local.chatlog || {};
	var messageid=message.id;
//	if(invite.chaterMode) var messageid=message.id;
//	else var messageid=cache.mine.id;
    layui.each(chatlog[message.type + messageid], function(index, item){
      if(message.msg_id == item.msg_id){
		   chatlog[message.type + messageid].splice(index,1,message);
	  }
    });
	local.chatlog = chatlog;
	//alert(JSON.stringify(local.chatlog));
    layui.data('layim-mobile', {
      key: cache.mine.id
      ,value: local
    });
  };
  
  var deleteallChatlog = function(data){
	var thatChat = thisChat();
    var local = layui.data('layim-mobile')[cache.mine.id] || {};
    var chatlog = local.chatlog || {};
	var messageid=data.uid;
//	if(invite.chaterMode) var messageid=data.uid;
//	else var messageid=cache.mine.id;
	chatlog[thatChat.data.type + messageid] = [];
	local.chatlog = chatlog;
    layui.data('layim-mobile', {
      key: cache.mine.id
      ,value: local
    });
  };
  //渲染本地最新聊天记录到相应面板
  var viewChatlog = function(){
    var local = layui.data('layim-mobile')[cache.mine.id] || {};
    var thatChat = thisChat(), chatlog = local.chatlog || {};
    var ul = thatChat.elem.find('.layim-chat-main ul');
	var messageid=thatChat.data.id;
//	if(invite.chaterMode) var messageid=thatChat.data.id;
//	else var messageid=cache.mine.id;
    layui.each(chatlog[thatChat.data.type + messageid], function(index, item){
      if(new Date().getTime() > item.timestamp && item.timestamp - (sendMessage.time||0) > 60*1000){
        ul.append('<li class="layim-chat-system"><span>'+ layui.data.date(item.timestamp) +'</span></li>');
        sendMessage.time = item.timestamp;
      }
      ul.append(laytpl(elemChatMain).render(item));
	  events.photos($('#message'+item.msg_id,ul));
	  isChatlog=1;
    });
	
//	setTimeout(function(){
//			baguetteBox.run('.layim-chat-main ul');
//			if (typeof oldIE === 'undefined' && Object.keys) {
//				hljs.initHighlighting();
//			}
//			 }, 500);
    chatListMore();
  };
  
  //添加好友或群
  var addList = function(data){
    var obj = {}, has, listElem = layimMain.find('.layim-list-'+ data.type);
    
    if(cache[data.type]){
      if(data.type === 'friend'){
        layui.each(cache.friend, function(index, item){
          if(data.groupid == item.id){
            //检查好友是否已经在列表中
            layui.each(cache.friend[index].list, function(idx, itm){
              if(itm.id == data.id){
                return has = true
              }
            });
            if(has) return layer.msg('好友 ['+ (data.username||'') +'] 已经存在列表中',{anim: 6});
            cache.friend[index].list = cache.friend[index].list || [];
            obj[cache.friend[index].list.length] = data;
            data.groupIndex = index;
            cache.friend[index].list.push(data); //在cache的friend里面也增加好友
            return true;
          }
        });
      } else if(data.type === 'group'){
        //检查群组是否已经在列表中
        layui.each(cache.group, function(idx, itm){
          if(itm.id == data.id){
            return has = true
          }
        });
        if(has) return layer.msg('您已是 ['+ (data.groupname||'') +'] 的群成员',{anim: 6});
        obj[cache.group.length] = data;
        cache.group.push(data);
      }
    }
    
    if(has) return;

    var list = laytpl(listTpl({
      type: data.type
      ,item: 'd.data'
      ,index: data.type === 'friend' ? 'data.groupIndex' : null
    })).render({data: obj});

    if(data.type === 'friend'){
      var li = listElem.children('li').eq(data.groupIndex);
      li.find('.layui-layim-list').append(list);
      li.find('.layim-count').html(cache.friend[data.groupIndex].list.length); //刷新好友数量
      //如果初始没有好友
      if(li.find('.layim-null')[0]){
        li.find('.layim-null').remove();
      }
    } else if(data.type === 'group'){
      listElem.append(list);
      //如果初始没有群组
      if(listElem.find('.layim-null')[0]){
        listElem.find('.layim-null').remove();
      }
    }
  };
  
  //移出好友或群
  var removeList = function(data){
    var listElem = layimMain.find('.layim-list-'+ data.type);
    var obj = {};
    if(cache[data.type]){
      if(data.type === 'friend'){
        layui.each(cache.friend, function(index1, item1){
          layui.each(item1.list, function(index, item){
            if(data.id == item.id){
              var li = listElem.children('li').eq(index1);
              var list = li.find('.layui-layim-list').children('li');
              li.find('.layui-layim-list').children('li').eq(index).remove();
              cache.friend[index1].list.splice(index, 1); //从cache的friend里面也删除掉好友
              li.find('.layim-count').html(cache.friend[index1].list.length); //刷新好友数量  
              //如果一个好友都没了
              if(cache.friend[index1].list.length === 0){
                li.find('.layui-layim-list').html('<li class="layim-null">该分组下已无好友了</li>');
              }
              return true;
            }
          });
        });
      } else if(data.type === 'group'){
        layui.each(cache.group, function(index, item){
          if(data.id == item.id){
            listElem.children('li').eq(index).remove();
            cache.group.splice(index, 1); //从cache的group里面也删除掉数据
            //如果一个群组都没了
            if(cache.group.length === 0){
              listElem.html('<li class="layim-null">暂无群组</li>');
            }
            return true;
          }
        });
      }
    }
  };
  
  //查看更多记录
  var chatListMore = function(){
    var thatChat = thisChat(), chatMain = thatChat.elem.find('.layim-chat-main');
    var ul = chatMain.find('ul'), li = ul.children('.layim-chat-li'); 
    
    //if(li.length >= MAX_ITEM){
      var first = li.eq(0);
      first.prev().remove();
      if(!ul.prev().hasClass('layim-chat-system')){
        ul.before('<div class="layim-chat-system"><span layim-event="chatLog">查看更多记录</span></div>');
      }
      first.remove();
    //}
    chatMain.scrollTop(chatMain[0].scrollHeight + 1000);
  };
  
  var chatMain_scrollTop = function(){
    var thatChat = thisChat(), chatMain = thatChat.elem.find('.layim-chat-main');
    var ul = chatMain.find('ul'), li = ul.children('.layim-chat-li'); 
    
//    //if(li.length >= MAX_ITEM){
//      var first = li.eq(0);
//      first.prev().remove();
//      if(!ul.prev().hasClass('layim-chat-system')){
//        ul.before('<div class="layim-chat-system"><span layim-event="chatLog">查看更多记录</span></div>');
//      }
//      first.remove();
//    //}
    chatMain.scrollTop(chatMain[0].scrollHeight + 1000);
  };
  
  //快捷键发送
  var hotkeySend = function(){
    var thatChat = thisChat(), textarea = thatChat.textarea;
    var btn = textarea.next();
    textarea.off('keyup').on('keyup', function(e){
      var keyCode = e.keyCode;
      if(keyCode === 13){
        e.preventDefault();
        sendMessage();
      }
      btn[textarea.val() === '' ? 'addClass' : 'removeClass']('layui-disabled');
    });
  };
  
  //表情库
  var faces = function(){
    var alt = ["{f@Expression/default/0.gif}", "{f@Expression/default/1.gif}", "{f@Expression/default/2.gif}", "{f@Expression/default/3.gif}", "{f@Expression/default/4.gif}", "{f@Expression/default/5.gif}", "{f@Expression/default/6.gif}", "{f@Expression/default/7.gif}", "{f@Expression/default/8.gif}", "{f@Expression/default/9.gif}", "{f@Expression/default/10.gif}", "{f@Expression/default/11.gif}", "{f@Expression/default/12.gif}", "{f@Expression/default/13.gif}", "{f@Expression/default/14.gif}", "{f@Expression/default/15.gif}", "{f@Expression/default/16.gif}", "{f@Expression/default/17.gif}", "{f@Expression/default/18.gif}", "{f@Expression/default/19.gif}", "{f@Expression/default/20.gif}", "{f@Expression/default/21.gif}", "{f@Expression/default/22.gif}", "{f@Expression/default/23.gif}", "{f@Expression/default/24.gif}", "{f@Expression/default/25.gif}", "{f@Expression/default/26.gif}", "{f@Expression/default/27.gif}", "{f@Expression/default/28.gif}", "{f@Expression/default/29.gif}", "{f@Expression/default/30.gif}", "{f@Expression/default/31.gif}", "{f@Expression/default/32.gif}", "{f@Expression/default/33.gif}", "{f@Expression/default/34.gif}", "{f@Expression/default/35.gif}", "{f@Expression/default/36.gif}", "{f@Expression/default/37.gif}", "{f@Expression/default/38.gif}", "{f@Expression/default/39.gif}", "{f@Expression/default/40.gif}", "{f@Expression/default/41.gif}", "{f@Expression/default/42.gif}", "{f@Expression/default/43.gif}", "{f@Expression/default/44.gif}", "{f@Expression/default/45.gif}", "{f@Expression/default/46.gif}", "{f@Expression/default/47.gif}", "{f@Expression/default/48.gif}", "{f@Expression/default/49.gif}", "{f@Expression/default/50.gif}", "{f@Expression/default/51.gif}", "{f@Expression/default/52.gif}", "{f@Expression/default/53.gif}", "{f@Expression/default/54.gif}", "{f@Expression/default/55.gif}", "{f@Expression/default/56.gif}", "{f@Expression/default/57.gif}", "{f@Expression/default/58.gif}", "{f@Expression/default/59.gif}", "{f@Expression/default/60.gif}", "{f@Expression/default/61.gif}", "{f@Expression/default/62.gif}", "{f@Expression/default/63.gif}", "{f@Expression/default/64.gif}", "{f@Expression/default/65.gif}", "{f@Expression/default/66.gif}", "{f@Expression/default/67.gif}", "{f@Expression/default/68.gif}", "{f@Expression/default/69.gif}", "{f@Expression/default/70.gif}", "{f@Expression/default/71.gif}", ], arr = {};
    layui.each(alt, function(index, item){
      arr[item] = layui.cache.dir + 'Data/Expression/default/'+ index + '.gif';
    });
    return arr;
  }();
  
  
  var stope = layui.stope; //组件事件冒泡
  
  //在焦点处插入内容
  var focusInsert = function(obj, str, nofocus){
    var result, val = obj.value;
    nofocus || obj.focus();
    if(document.selection){ //ie
      result = document.selection.createRange(); 
      document.selection.empty(); 
      result.text = str; 
    } else {
      result = [val.substring(0, obj.selectionStart), str, val.substr(obj.selectionEnd)];
      nofocus || obj.focus();
      obj.value = result.join('');
    }
  };
  
  //事件
  var anim = 'layui-anim-upbit',rec,recBlob, events = { 
    //弹出聊天面板
    chat: function(othis){
      var local = layui.data('layim-mobile')[cache.mine.id] || {};
      var type = othis.data('type'), index = othis.data('index');
      var list = othis.attr('data-list') || othis.index(), data = {};
      if(type === 'friend'){
        data = cache[type][index].list[list];
      } else if(type === 'group'){
        data = cache[type][list];
      } else if(type === 'history'){
        data = (local.history || {})[index] || {};
      }
      data.name = data.name || data.username || data.groupname;
      if(type !== 'history'){
        data.type = type;
      }
      popchat(data, true);
      $('.layim-'+ data.type + data.id).find('.layim-msg-status').removeClass(SHOW);
    }
    //弹出聊天面板
    ,chatRo: function(othis){
      var local = layui.data('layim-mobile')[cache.mine.id] || {};
      var type = othis.data('type'), index = othis.data('index');
      var list = othis.attr('data-list') || othis.index(), data = {};
      if(type === 'friend'){
        data = cache[type][index].list[list];
      } else if(type === 'group'){
        data = cache[type][list];
      } else if(type === 'history'){
        data = (local.history || {})[index] || {};
      }
      data.name = data.name || data.username || data.groupname;
      if(type !== 'history'){
        data.type = type;
      }
	  //console.log(JSON.stringify(data));
	  if(type === 'history'){
		if(parseInt(data.lv_chater_ro_to_type)==1) ConnectChat1(data.pid);
		else{
			 chater.loginname=data.id;
			 connectChat();
		}
	  }else ConnectChat1(data.id);
	  //popchat(data, true);
	  $('.layim-'+ data.type + data.id).find('.layim-msg-status').removeClass(SHOW);
    }
    //展开联系人分组
    ,spread: function(othis){
      var type = othis.attr('lay-type');
      var spread = type === 'true' ? 'false' : 'true';
      var local = layui.data('layim-mobile')[cache.mine.id] || {};
      othis.next()[type === 'true' ? 'removeClass' : 'addClass'](SHOW);
      local['spread' + othis.parent().index()] = spread;
      layui.data('layim-mobile', {
        key: cache.mine.id
        ,value: local
      });
      othis.attr('lay-type', spread);
      othis.find('.layui-icon').html(spread === 'true' ? '&#xe61a;' : '&#xe602;');
    }
    
    //底部导航切换
    ,tab: function(othis){
      var index = othis.index(), main = '.layim-tab-content';
      othis.addClass(THIS).siblings().removeClass(THIS);
      layimMain.find(main).eq(index).addClass(SHOW).siblings(main).removeClass(SHOW);
    }
    
    //返回到上一个面板
    ,back: function(othis){
	  if((ischatlog==1)||ischathistory){
		  $('#robotlogo').hide();
		  if(ischatlog==1) ischatlog=0;
		  var layero = othis.parents('.layui-m-layer').eq(0)
		  ,index = layero.attr('index')
		  ,PANEL = '.layim-panel';
		  setTimeout(function(){
			layer.close(index);
		  }, 300);
		  othis.parents(PANEL).eq(0).removeClass('layui-m-anim-left').addClass('layui-m-anim-rout');
		  layero.prev().find(PANEL).eq(0).removeClass('layui-m-anim-lout').addClass('layui-m-anim-right');
		  layui.each(call.back, function(index, item){
			setTimeout(function(){
			  item && item();
			}, 200);
		  });  
	  }else{
//		  if(rejectType){
//			  postRate(); 
//		  }else{
			  window.parent.postMessage({
						cmd: 'end',
						params: ''
					  }, '*');
			  var layero = othis.parents('.layui-m-layer').eq(0)
			  ,index = layero.attr('index')
			  ,PANEL = '.layim-panel';
			  setTimeout(function(){
				layer.close(index);
			  }, 300);
			  othis.parents(PANEL).eq(0).removeClass('layui-m-anim-left').addClass('layui-m-anim-rout');
			  layero.prev().find(PANEL).eq(0).removeClass('layui-m-anim-lout').addClass('layui-m-anim-right');
			  layui.each(call.back, function(index, item){
				setTimeout(function(){
				  item && item();
				}, 200);
			  });
//		  }
	  }
    }
    
    //发送聊天内容
    ,send: function(){
      sendMessage();
    }
    ,recOpen: function(othis, e){
//	  thatChat = thisChat();
//	  var msg = "{x@"+langs.callMeeting_alert11+langs.callMeeting_alert6+"}";
//	  sendMessage1(msg);
//	  location.href = get_meeting_url(0,meetingurl.point) ;
	  rec=null;
	  recBlob=null;
	  rec=Recorder({
		  type:"wav",sampleRate:16000,bitRate:16
		  ,onProcess:function(buffers,powerLevel,bufferDuration,bufferSampleRate){

		  }
	  });
	  events.addmenuHide();
	  console.log("正在打开录音，请求麦克风权限...");

	  rec.open(function(){
		  console.log("已打开录音，可以点击开始了");
		  events.recStart();
	  },function(msg,isUserNotAllow){
		  console.log((isUserNotAllow?"UserNotAllow，":"")+"无法录音:"+msg);
		  layer.msg('语音发送失败');
	  });	
    } ,recClose: function(){
	  if(rec){
		  rec.close();
		  console.log("已关闭");
	  }else{
		  console.log("未打开录音");
	  }
    } ,recStart: function(){
        if(rec&&Recorder.IsOpen()){
            recBlob=null;
            rec.start();
            //layui.use(['jquery', 'layer'], function () {
                var layer = layui.layer;
                layer.msg("请说话...", {
                    icon: 16
                    , shade: 0.01
                    , skin: 'layui-layer-lan'
                    , time: 0
                    , btn: ["发送", "取消"]
                    , yes: function (index, layero) {
                        //按钮【按钮一】的回调
                        rec.stop(function(blob,duration){
                            console.log(blob,(window.URL||webkitURL).createObjectURL(blob),"时长:"+duration+"ms");
                            recBlob=blob;

                            var fd = new FormData();
                            var wavName = encodeURIComponent('audio_recording_' + new Date().getTime() + '.wav');
                            recBlob.name = wavName
                            console.log(recBlob)
                            fd.append('wavName', wavName);
                            fd.append('file', recBlob);
                            var xhr = new XMLHttpRequest();
                            xhr.onreadystatechange = function () {
                                if (xhr.readyState == 4 && xhr.status == 200) {
									var data = JSON.parse(xhr.responseText);
									var msg = "{d@" + data.filepath + "|"+data.filesize+"|"+parseInt(duration/1000)+"|}" ;
									sendMessage1(msg);
                                }
                            };
                            xhr.open('POST', cache.base['uploadImage'].url);
                            xhr.send(fd);
                        });
                        events.recClose();
                        layer.close(index);
                    }
                    , btn2: function (index, layero) {
                        events.recClose();
                        layer.close(index);
                    }
                });

            //});
            console.log("已开始录音...");
        }else{
            layer.msg("语音发送失败")
        }
    }
    ,startaudio: function(othis, e){
	  thatChat = thisChat();
	  var msg = "{x@"+langs.callMeeting_alert11+langs.callMeeting_alert6+"}";
	  //focusInsert(thatChat.textarea[0], msg);
	  sendMessage1(msg);
	  events.addmenuHide();
	  location.href = get_meeting_url(0,meetingurl.point) ;	
	  //window.open(get_meeting_url(0,meetingurl.point)) ;
    }
    ,startvideo: function(othis, e){
	  thatChat = thisChat();
	  var msg = "{y@"+langs.callMeeting_alert11+langs.callMeeting_alert5+"}";
	  //focusInsert(thatChat.textarea[0], msg);
	  sendMessage1(msg);
	  events.addmenuHide();
	  location.href = get_meeting_url(1,meetingurl.point) ;	
	  //window.open(get_meeting_url(1,meetingurl.point)) ;
    }
    //表情
    ,face: function(othis, e){
      var content = '', thatChat = thisChat(), input = thatChat.textarea;
      layui.each(faces, function(key, item){
         content += '<li title="'+ key +'"><img src="'+ item +'"></li>';
      });
      content = '<ul class="layui-layim-face">'+ content +'</ul>';
	  events.addmenuHide();
      layer.popBottom({
        content: content
        ,success: function(elem){
          var list = $(elem).find('.layui-layim-face').children('li')
          touch(list, function(){
            focusInsert(input[0], this.title + ' ', true);
            input.next()[input.val() === '' ? 'addClass' : 'removeClass']('layui-disabled');
            return false;
          });
        }
      });
      var doc = $(document);
      if(isTouch){
        touch(doc, function(){
          events.faceHide();
        })
        //doc.off('touchend', events.faceHide).on('touchend', events.faceHide);
      } else {
        doc.off('click', events.faceHide).on('click', events.faceHide);
      }
      stope(e);
    } ,faceHide: function(){
      layer.close(layer.popBottom.index);
      $(document).off('touchend', events.faceHide)
      .off('click', events.faceHide);
    }
	
    //评价
    ,rate: function(othis, e){
	  events.addmenuHide();
	  getRate();
//	  if (isPostRate)
//	  {
//		  //myAlert(langs.lv_rate_error);
//		  return false ;
//	  }
//      var content = '', thatChat = thisChat(), input = thatChat.textarea;
//      for(var i=0;i<5;i++){
//         content += '<li>★</li>';
//      }
//      content = '<ul class="layui-layim-stars">'+ content +'</ul>';
//      layer.popBottom({
//        content: content
//        ,success: function(elem){
//          var list = $(elem).find('.layui-layim-stars').children('li');
////		  var isClicked = false;
////		  var beforeClickedIndex = -1;
////		  var clickNum = 0; //点击同一颗星次数
//          touch(list, function(){
//			$('li').css('color', '#ADADAD');
////			isClicked = true;
//			var index = $(this).index();
//
//			for(var i = 1; i <= index+1; i++) {
//				$('li:nth-child(' + i + ')').css('color', '#F0AD4E');
//			}
////			if(index == beforeClickedIndex) { //两次点击同一颗星星 该星星颜色变化
////				clickNum++;
////				if(clickNum % 2 == 1) {
////					$('li:nth-child(' + (index + 1) + ')').css('color', '#ADADAD');
////				} else {
////					$('li:nth-child(' + (index + 1) + ')').css('color', '#F0AD4E');
////				}
////
////			} else {
////				clickNum = 0;
////				beforeClickedIndex = index;
////			}
////            sendRate(index+1,layer.popBottom.index);
//			var param = {chatId:chatId,rate:(index+1)};
//			var url = getAjaxUrl("livechat_kf","PostRate") ;
//			//document.write(url+JSON.stringify(param));
//			$.getJSON(url,param, function(result){
////				if (isConnected){
////					sendMsg(langs.lv_rate_msg.replace("{Rate}",param.rate)  ,false) ;
////				}
////				myAlert(langs.lv_rate_success);
////				layer.msg(langs.lv_rate_success);
//				isPostRate = true ;
//				events.rateHide();
//			}); 
//            return false;
//          });
//        }
//      });
//      var doc = thatChat.elem.find('.layui-layim-stars').children('li');
//      if(isTouch){
//        touch(doc, function(){
//          events.rateHide();
//        })
//        doc.off('touchend', events.rateHide).on('touchend', events.rateHide);
//      } else {
//        doc.off('click', events.rateHide).on('click', events.rateHide);
//      }
      stope(e);
    } ,rateHide: function(){
      layer.close(layer.popBottom.index);
	  if(isPostClose){
		  window.parent.postMessage({
					cmd: 'end',
					params: ''
				  }, '*');
	  }
//      $(document).off('touchend', events.rateHide)
//      .off('click', events.rateHide);
    }
	
    //更多菜单
    ,addmenu: function(othis, e){
	  if(isgetMenu){
		 events.addmenuHide();
	  }else{
		 var addmenu_image='&#xe61a;';
		 $('.layim-tool-addmenu','.layim-chat-footer').html(addmenu_image);
		 getMenu();
	  }
      stope(e);
    } ,addmenuHide: function(){
	  isgetMenu=false;
	  var addmenu_image='&#xe619;';
	  $('.layim-tool-addmenu','.layim-chat-footer').html(addmenu_image);
      layer.close(layer.popBottom.index);
//      $(document).off('touchend', events.rateHide)
//      .off('click', events.rateHide);
    }
	
    //定位
    ,location: function(othis, e){
	  thatChat = thisChat();
	  get_location();
	  events.addmenuHide();
//	  parent.wx.getLocation({
//		  type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
//		  success: function (res) {
//			  var bdLocation = txMap_to_bdMap(res.latitude,res.longitude);
//			  var speed = res.speed; // 速度，以米/每秒计
//			  var accuracy = res.accuracy; // 位置精度
//
//			  var msg = "{c@x="+bdLocation.lng+":y="+bdLocation.lat+"}" ;
//			  sendMessage1(msg);
//		  }
//	  });
	  
//	  parent.wx.getLocation({
//		  type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
//		  success: function (res) {
//			  var location = bdMap_to_txMap(latitude,longitude);
//			  "getLocation:ok" == res.errMsg && $.ajax({
//				  url: "http://api.map.baidu.com/reverse_geocoding/v3/?",
//				  type: "get",
//				  data: {
//					  coordtype: "wgs84ll",
//					  location: res.latitude + "," + res.longitude,
//					  ak: '2roxACt4rvWCgAeBkC1DebZmUs0kTEKv',  //百度ak值
//					  //callback: "aaaa", //可自定义回调方法名
//					  output: "json",
//					  pois: 1
//				  },
//				  dataType: "jsonp",
//				  success: function(e) {
//					  //alert(e.result)  //返回的值
//					  var latitude = e.result.location.lat; // 纬度，浮点数，范围为90 ~ -90
//					  var longitude = e.result.location.lng; // 经度，浮点数，范围为180 ~ -180。
//					  var msg = "{c@x="+longitude+":y="+latitude+"}" ;
//					  sendMessage1(msg);
//				  }
//			  })
//		  }
//	  });

      stope(e);
    }

    
    //图片或一般文件
    ,image: function(othis){
      var type = othis.data('type') || 'images', api = {
        images: 'uploadImage'
        ,file: 'uploadFile'
      }
      ,thatChat = thisChat(), conf = cache.base[api[type]] || {};
      //alert(othis.find('input')[0].attr('name'));
      //执行上传
	  if(othis.data('btn')!='upfilesbtnHide') events.addmenuHide();
	  var upload_info_obj={
        url: conf.url || ''
        ,method: conf.type
        ,elem: othis.find('input')[0]
		,auto: false
        ,bindAction: '#'+othis.data('btn')
        ,accept: type
		,multiple: true
		,choose: function(obj) {
			//将每次选择的文件追加到文件队列
			events.addmenuHide();
			var files = obj.pushFile();
			var index, file, indexArr = [],notSupport = false,k = 0;
			for(index in files) {
				indexArr.push(index);
			};
			for(var i = 0; i < indexArr.length; i++) {
				if(files[indexArr[i]].size > 200 * 1024&&get_filetype(files[indexArr[i]].name)=="img"&&(!(device.ios&&device.qq))) {
					if (!notSupport) {
					  (function(i) {
						new html5ImgCompress(files[indexArr[i]], {
						  before: function(file) {
						  },
						  done: function (file, base64) { // 这里是异步回调，done中i的顺序不能保证
							  var bl = convertBase64UrlToBlob(base64);
							  obj.resetFile(indexArr[i], bl, files[indexArr[i]].name);
							  k++;
							  //sendMessage1(k+'|'+indexArr.length);
							  if(k==indexArr.length) $('#'+othis.data('btn')).trigger("click");
						  },
						  fail: function(file) {
						  },
						  complete: function(file) {
						  },
						  notSupport: function(file) {
							notSupport = true;
						  }
						});
					  })(i);
					}
				} else {
					k++;
					if(k==indexArr.length) $('#'+othis.data('btn')).trigger("click");
				}
			}
		}
//		,beforeSend: function(obj){
//			layer.msg('正在fdg上传...', {
//			icon: 16,
//			shade: 0.01,
//			time: 0
//			})
////			//预读本地文件示例，不支持ie8
////			obj.preview(function(index, file, result){
////				$('#demo1').attr('src', result); //图片链接（base64）
////			});
//		}
        ,done: function(data){
			//alert(JSON.stringify(data));
          if(data.status != 0){
			//layer.close(layer.msg());
			switch (get_filetype(data.filepath)) {
			case "mp3":
			var msg = "{d@" + data.filepath + "|"+data.filesize+"|0|}" ;
			break;
			case "img":
			var msg = "{e@" + data.filepath + "|"+data.filesize+"|0|}" ;
			break;
			case "mpeg":
			var msg = "{i@" + data.filepath + "|"+data.filesize+"|0|FileRecv/MessageVideoPlay.png}" ;
			break;
			default:
			var msg = "{a@" + data.filepath + "}" ;
			break;
			}
            //focusInsert(thatChat.textarea[0], msg);
            sendMessage1(msg);
			var src = get_download_url1(data.filepath);
			saveAttach(data.filename,data.filesize,src,ATTACH_VISITER_SEND) ;
          } else {
            layer.msg(data.msg||'上传失败');
          }
        }
      }
      //layui.upload.reload(upload_info_obj);
	  var uploadInst = layui.upload.render(upload_info_obj);
    }
    ,transfer: function(othis, e){
	  var param = {point:1,myid:my.userid,youid:chater.loginname,lv_chater_ro_to_type:chater.lv_chater_ro_to_type,cookieHCID5:cookieHCID5};
	  var url = getAjaxUrl("livechat_kf","transfer1") ;
	  $.getJSON(url,param , function(result){
		  if (result.status)
		  {
			  cookieHCID5 = parseInt(result.msg);
			  if(cookieHCID5){
				   var transfer_image='<svg t="1676443186165" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2945" width="24" height="24"><path d="M233.984 531.456c6.656 0 11.776-5.12 11.776-11.776L245.76 302.592c0-3.072-1.536-6.144-3.584-8.704 51.712-97.792 155.648-160.256 268.8-160.256s217.088 62.464 268.8 160.768c-2.048 2.048-3.584 5.12-3.584 8.192l0 217.088c0 6.656 5.12 11.776 11.776 11.776 67.584 0 122.368-53.76 122.368-120.32 0-41.984-22.528-81.408-59.392-102.912-51.2-140.288-187.904-234.496-340.48-234.496S221.696 167.936 169.472 308.224C133.12 330.24 110.592 369.152 110.592 411.136 111.104 477.696 166.4 531.456 233.984 531.456z" p-id="2946"></path><path d="M755.712 633.856c-4.608-2.048-9.728-1.536-13.312 2.048-62.976 57.856-144.896 89.6-231.424 89.6-86.016 0-168.448-31.744-231.424-89.088-3.584-3.072-8.704-4.096-13.312-2.048-123.904 62.464-192.512 170.496-192.512 304.128 0 6.656 5.12 11.776 11.776 11.776l853.504 0c6.656 0 11.776-5.12 11.776-11.776C950.272 804.352 881.152 696.32 755.712 633.856zM885.248 892.416 141.824 892.416c13.824-90.624 76.288-156.672 129.536-187.904 71.68 51.712 147.456 74.752 244.224 74.752 84.48 0 178.176-31.744 240.64-81.408C825.856 738.304 878.592 819.2 885.248 892.416z" p-id="2947"></path><path d="M510.976 182.784c-138.752 0-251.904 110.592-251.904 246.784s113.152 247.296 251.904 247.296 251.392-111.104 251.392-247.296C762.368 293.376 649.728 182.784 510.976 182.784zM699.392 429.056c0 101.888-84.48 184.32-188.416 184.32s-188.416-82.944-188.416-184.32c0-99.84 86.528-184.32 188.416-184.32C614.4 244.736 699.392 327.168 699.392 429.056z" p-id="2948"></path></svg>';
				   var transfer_title=langs.chart_artificial;
				   var usertext=langs.msg_recv_chatgpt4;
				   $('#robotlogo').show();
			  }else{
				  var transfer_image='<svg t="1676443980835" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="10514" width="24" height="24"><path d="M923.8 767.1h-42.7V665.4c-8.7 8-17.5 16-26.2 23.5-29.5 25.7-54.3 44.2-73.1 53.2-12.2 5.9-24.7 11.8-41.4 19.7-65.5 31.1-95.4 45.7-130.8 64.6l-249.2 133c-19.7 10.5-41.7 15.9-64.1 15.9-20.4 0-40.6-4.5-59-13.3-35.6-16.9-62-49.7-72.5-89.8l-5.2-19.8c-5.5-21-16.7-55.6-33.7-103.4-34.7-76.6-63.5-132.6-86.2-167.5l-8.1-12.4c-6-9.2-4-21.6 4.7-28.4l36.2-28.5c27.3-21.5 43.2-53.3 44.2-87.9v-3.7c1.7-144 103.1-284.4 241.4-334.5C420.6 63.5 504.7 51 610.9 48.5 813.5 48.5 983.4 206.3 990 401c2.7 79.1-20.8 156.4-66.3 220.9v145.2z m23.6-364.5C941.5 231.3 790.9 91.4 611.6 91.3c-101.8 2.5-181.6 14.3-239 35.1-115 41.6-201.9 155.4-212.2 274.3 1.6 0 3.4 0.1 5.2 0.1 18 0.4 51.2 1.3 81.1 1.3 28.1 0.6 27.9 42.7-0.6 42.7-36-0.6-63-0.9-80.9-0.9h-7.4c-5.7 40.1-26.5 76.4-58.9 101.9L78 562.3c22.5 35.3 49.6 87.8 81.6 157.7 33.1 0.1 60.2-3.8 81.2-11.5 23-8.4 43.6-23.2 61.8-44.6 18.1-21.2 50.2 5 33 27-21.4 27.3-48.4 46.7-80.5 57.8-23.2 8-49.6 12.5-79.3 13.7 12 34.9 20.4 61.2 25.1 79.2l5.2 19.8c7.4 28.1 25.5 50.7 49.5 62.1 12.7 6.1 26.7 9.2 40.7 9.2 15.4 0 30.6-3.7 44-10.9l249.2-133c36.3-19.3 66.6-34.1 132.6-65.5 16.7-7.9 29.1-13.8 41.2-19.6 26.6-12.8 78.3-57.7 122.8-102.4 42-57.8 63.7-127.4 61.3-198.7z m-108 485.9L608.1 989.7c-10.8 4.7-23.4-0.2-28.1-11-4.7-10.8 0.2-23.4 11-28.1l230.1-100.7c-1-5.2-1.5-10.7-1.5-16.2 0-47.1 38.2-85.3 85.3-85.3s85.3 38.2 85.3 85.3c0 47.1-38.2 85.3-85.3 85.3-26.3 0.1-49.8-11.8-65.5-30.5z m65.5-12.1c23.6 0 42.7-19.1 42.7-42.7S928.5 791 904.9 791s-42.7 19.1-42.7 42.7 19.1 42.7 42.7 42.7zM599.4 598.9c-105.2 0-190.5-85.3-190.5-190.5s85.3-190.5 190.5-190.5 190.5 85.3 190.5 190.5-85.3 190.5-190.5 190.5z m0-42.7c81.7 0 147.9-66.2 147.9-147.9S681 260.5 599.4 260.5s-147.9 66.2-147.9 147.9 66.2 147.8 147.9 147.8z m0-105.4c-23.5 0-42.5-19-42.5-42.5s19-42.5 42.5-42.5 42.5 19 42.5 42.5c-0.1 23.5-19.1 42.5-42.5 42.5z m0-42.7c-0.1 0-0.2 0.1-0.2 0.2s0.1 0.2 0.2 0.2 0.2-0.1 0.2-0.2c-0.1-0.1-0.1-0.2-0.2-0.2z" fill="" p-id="10515"></path></svg>';
				  var transfer_title=langs.chart_robot;
				  var usertext=langs.msg_recv_chatgpt5;
				  $('#robotlogo').hide();
			  }
			  var obj = {
				system: true
				,id: chater.loginname
				,type: 'kefu'
				,content: usertext
			  }
			  getMessage(obj);
			  $('.layim-tool-transfer','.layim-chat-footer').attr("title",transfer_title);
			  $('.layim-tool-transfer','.layim-chat-footer').html(transfer_image);
			  events.addmenuHide();
		  }
	  });
    }
    //扩展工具栏
    ,extend: function(othis){
      var filter = othis.attr('lay-filter')
      ,thatChat = thisChat();
      
      layui.each(call['tool('+ filter +')'], function(index, item){
        item && item.call(othis, function(content){
          focusInsert(thatChat.textarea[0], content);
        }, sendMessage, thatChat);
      });
    }
    
    //弹出新的朋友面板
    ,newFriend: function(){
      layui.each(call.newFriend, function(index, item){
        item && item();
      });
    }
    
    //弹出群组面板
    ,group: function(){
      popPanel({
        title: '群聊'
        ,tpl: ['<div class="layui-layim-list layim-list-group">'
          ,listTpl({
            type: 'group'
            ,item: 'd.group'
          })
        ,'</div>'].join('')
        ,data: {}
      });
    }
    
    //查看群组成员
    ,detail: function(){
      var thatChat = thisChat();
      layui.each(call.detail, function(index, item){
        item && item(thatChat.data);
      });
    }
    
    //播放音频
    ,playAudio: function(othis){
      var audioData = othis.data('audio')
      ,audio = audioData || document.createElement('audio')
      ,pause = function(){
        audio.pause();
        othis.removeAttr('status');
        othis.find('i').html('&#xe652;');
      };
      if(othis.data('error')){
        return layer.msg('播放音频源异常');
      }
      if(!audio.play){
        return layer.msg('您的浏览器不支持audio');
      }
      if(othis.attr('status')){   
        pause();
      } else {
        audioData || (audio.src = othis.data('src'));
        audio.play();
        othis.attr('status', 'pause');
        othis.data('audio', audio);
        othis.find('i').html('&#xe651;');
        //播放结束
        audio.onended = function(){
          pause();
        };
        //播放异常
        audio.onerror = function(){
          layer.msg('播放音频源异常');
          othis.data('error', true);
          pause();
        };
      } 
    }
    
    //播放视频
    ,playVideo: function(othis){
      var videoData = othis.data('src')
      ,video = document.createElement('video');
      if(!video.play){
        return layer.msg('您的浏览器不支持video');
      }
      layer.close(events.playVideo.index);
      events.playVideo.index = layer.open({
        type: 1
        ,anim: false
        ,style: 'width: 100%; height: 50%;'
        ,content: '<div style="background-color: #000; height: 100%;"><video style="position: absolute; width: 100%; height: 100%;" src="'+ videoData +'" autoplay="autoplay"></video></div>'
      });
    }
	
    ,photos: function(othis,e){
	  //setTimeout(function(){
		  
			  $('.thumbpic',othis).each(function(){
				  //console.log($(this).attr("src"));
				  var doc = $(this);
				  if(isTouch){
					touch(doc, function(){
					  events.photosShow(doc);
					})
					//doc.off('touchend', events.faceHide).on('touchend', events.faceHide);
				  } else {
					doc.off('click', events.photosShow(doc)).on('click', events.photosShow(doc));
				  }
			  })
		  			  
//			  var doc = $('.thumbpic',othis);
//			  if(isTouch){
//				touch(doc, function(){
//				  events.photosShow(doc);
//				})
//				//doc.off('touchend', events.faceHide).on('touchend', events.faceHide);
//			  } else {
//				doc.off('click', events.photosShow(doc)).on('click', events.photosShow(doc));
//			  }
			  stope(e);
//			  var form = layui.form
//			  var layerpic = layui.layer;
//			  $('.thumbpic',othis).each(function(){
//				  $(this)
//				  .unbind()
//				  .click(function(){
//					  var src = $(this).attr("src");
//					  layerpic.photos({
//						photos: {
//						  data: [{
//							"alt": "大图模式",
//							"src": src
//						  }]
//						}
//						,full:true
//						,anim: 5
//					  });
//				  })							
//			  })
	  //}, 500);
    } ,photosShow: function(othis){
	  var form = layui.form;
	  var layerpic = layui.layer;
	  var src = othis.attr("src");
	  layerpic.photos({
		photos: {
		  data: [{
			"alt": "大图模式",
			"src": src
		  }]
		}
//		,full:true
//		,anim:5
//        ,area:'100%'
//		,offset: 't'
		,success: function() {
			var distance = 0;
			$(document).on('touchstart', ".layui-layer-photos", function(ev) {
				ev.preventDefault();
				// 获取初始两个手指的距离
				var touch1 = ev.originalEvent.touches[0];
				var touch2 = ev.originalEvent.touches[1];
				distance = Math.sqrt(Math.pow(touch2.clientX - touch1.clientX, 2) + Math.pow(touch2.clientY - touch1.clientY, 2));
				//alert("fg");
			});
			
			$(document).on('touchmove', ".layui-layer-photos", function(ev) {
				ev.preventDefault();
				// 获取移动后两个手指的距离
				var touch1 = ev.originalEvent.touches[0];
				var touch2 = ev.originalEvent.touches[1];
				var newDistance = Math.sqrt(Math.pow(touch2.clientX - touch1.clientX, 2) + Math.pow(touch2.clientY - touch1.clientY, 2));
				// 计算放大缩小比例
				var scale = newDistance / distance;
				//alert("fhsj");
				// 设置div元素的缩放样式
				$(".layui-layer-photos").css('transform', 'scale(' + scale + ')');
			});
			
			$(document).on('touchend', ".layui-layer-photos", function(ev) {
				ev.preventDefault();
				// 清除缩放样式
				$(".layui-layer-photos").css('transform', 'scale(1)');
			});
			//以鼠标位置为中心的图片滚动放大缩小
//			$(document).on("mousewheel", ".layui-layer-photos", function (ev) {
//				var oImg = this;
//				var ev = event || window.event;//返回WheelEvent
//				//ev.preventDefault();
//				var delta = ev.detail ? ev.detail > 0 : ev.wheelDelta < 0;
//				var ratioL = (ev.clientX - oImg.offsetLeft) / oImg.offsetWidth,
//				ratioT = (ev.clientY - oImg.offsetTop) / oImg.offsetHeight,
//				ratioDelta = !delta ? 1 + 0.1 : 1 - 0.1,
//				w = parseInt(oImg.offsetWidth * ratioDelta),
//				h = parseInt(oImg.offsetHeight * ratioDelta),
//				l = Math.round(ev.clientX - (w * ratioL)),
//				t = Math.round(ev.clientY - (h * ratioT));
//				//设置相册层宽高
//				$(".layui-layer-photos").css({ width: w, height: h, left: l, top: t });
//				//设置图片外div宽高
//				$("#layui-layer-photos").css({ width: w, height: h });
//				//设置图片宽高
//				$("#layui-layer-photos>img").css({ width: w, height: h });
//			});
		}
	  });
      othis.off('touchend', events.photosShow)
      .off('click', events.photosShow);
    }
    
    //聊天记录
    ,chatLog: function(othis){
      var thatChat = thisChat();
      layui.each(call.chatlog, function(index, item){
        item && item(thatChat.data, thatChat.elem.find('.layim-chat-main>ul'));
      });
    }
    
    //更多列表
    ,moreList: function(othis){
      var filter = othis.attr('lay-filter');
      layui.each(call.moreList, function(index, item){
        item && item({
          alias: filter
        });
      });
    }
    
    //关于
    ,about: function(){
      layer.open({
        content: '<p style="padding-bottom: 5px;">LayIM属于付费产品，欢迎通过官网获得授权，促进良性发展！</p><p>当前版本：layim mobile v'+ v + '</p><p>版权所有：<a href="http://layim.layui.com" target="_blank">layim.layui.com</a></p>'
        ,className: 'layim-about'
        ,shadeClose: false
        ,btn: '我知道了'
      });
    }
    
  };
  
  //暴露接口
  exports('layim-mobile', new LAYIM());

}).addcss(
  'modules/layim/mobile/layim.css?v=2.24'
  ,'skinlayim-mobilecss'
);