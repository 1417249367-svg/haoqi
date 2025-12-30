
<html>
<head>
    <title></title>

	<script type="text/javascript" src="/static/js/jquery.js"></script>

</head>
<body style="overflow:hidden;">
<div>
  <a href="https://pinqiu.tv" target="_blank"><img src="assets/img/aside_vister.jpg" class="image"></a>
</div>

</body>
</html>
<script type="text/javascript">
  var imgDom = $(".image");//获取图片
  var winDom = $(window);//获取窗口
  $(document).ready(function(){
	  imgDom.css({"width":"100%","height":"auto"});//给图片赋计算后的宽高
  })
  //使用resize（）
  winDom.resize(function(){
    var winwHeight = winDom.height();//获取窗口高度
    var winwWidth = winDom.width();//获取窗口宽度
 
    var imgHeight = winwHeight;//图片的高度是窗口高度的一半
    var imgWidth = winwWidth;///图片的宽度根据图片的原始宽高比值和窗口高度计算出宽度
 
    //imgDom.attr("height",imgHeight).attr("width",imgWidth);
    imgDom.css({"width":"100%","height":"auto"});//给图片赋计算后的宽高
  });
</script>