	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="//api.map.baidu.com/api?type=webgl&v=1.0&ak=xjALWQ1fAHE5xWKueQu0w8iP"></script>
    <script type="text/javascript" src="//api.map.baidu.com/api?v=2.0&ak=xjALWQ1fAHE5xWKueQu0w8iP"></script>
	<?php if (CDNTYPE) {?>
	<link  rel="stylesheet" href="//<?=CDNLINK?>/1.2/static/css/bootstrap.min.css">
	<script type="text/javascript" src="//<?=CDNLINK?>/1.2/livechat/langs/<?=$LangType?>/lang.js?ver=20251216"></script>
	<script type="text/javascript" src="//<?=CDNLINK?>/1.2/static/js/jquery.js"></script>
	<script type="text/javascript" src="//<?=CDNLINK?>/1.2/static/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="//<?=CDNLINK?>/1.2/static/js/swfobject.js"></script>
	<script type="text/javascript" src="//<?=CDNLINK?>/1.2/static/js/layer/layer.min.js"></script>
	<script type="text/javascript" src="//<?=CDNLINK?>/1.2/livechat/assets/js/site.js?ver=2015022601"></script>
	<script type="text/javascript" src="//<?=CDNLINK?>/1.2/static/js/jquery.validate.js"></script>
	<script type="text/javascript" src="//<?=CDNLINK?>/1.2/static/js/common.js"></script>
    <script type="text/javascript" src="//<?=CDNLINK?>/1.2/static/js/axios.min.js"></script>
	<link  rel="stylesheet" href="//<?=CDNLINK?>/1.2/livechat/assets/css/common.css"   />

    <!--[if lte IE 6]>
    <link rel="stylesheet" type="text/css" href="//cdn.78kefu.com/1.2/livechat/assets/css/ie6.css">
    <![endif]-->
    
    <link rel="stylesheet" href="/static/js/layui/css/layui.mobile.css">
    <link rel="stylesheet" href="//<?=CDNLINK?>/1.2/livechat/assets/css/kjctn.css"   />
    <script src="//<?=CDNLINK?>/1.2/static/js/layui/layui.js"></script>
    <script src="//<?=CDNLINK?>/1.2/static/js/baguetteBox/js/highlight.min.js" async></script>
    <script type="text/javascript" src="//<?=CDNLINK?>/1.2/livechat/assets/js/md5.js"></script>
	<script type="text/javascript" src="//<?=CDNLINK?>/1.2/livechat/assets/js/socket.js?ver=150927"></script>
	<script type="text/javascript" src="//<?=CDNLINK?>/1.2/livechat/assets/js/livechat_m.js?ver=20240727"></script>
	<script type="text/javascript" src="//<?=CDNLINK?>/1.2/livechat/assets/js/chat.js?ver=20230329"></script>
	<script type="text/javascript" src="//<?=CDNLINK?>/1.2/public/static/js/msg_reader.js?ver=20230220"></script>
    <script src="//<?=CDNLINK?>/1.2/public/js/fingerprint.js"></script>
    <script src="//<?=CDNLINK?>/1.2/public/js/html5ImgCompress.min.js"></script>
    <script src="//<?=CDNLINK?>/1.2/public/js/recorder.wav.min.js?ver=20230218"></script>
    <script src="<?=$rootPath1 ?>/socket.io/socket.io.js"></script>
    <script type='text/javascript' src='//<?=CDNLINK?>/1.2/public/js/common.js' charset='utf-8'></script>
    <script type='text/javascript' src='//<?=CDNLINK?>/1.2/public/js/client/client.js' charset='utf-8'></script>
	<?php }else{ ?>
	<link  rel="stylesheet" href="/static/css/bootstrap.min.css">
	<script type="text/javascript" src="/livechat/langs/<?=$LangType?>/lang.js?ver=20251216"></script>
	<script type="text/javascript" src="/static/js/jquery.js"></script>
	<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/static/js/swfobject.js"></script>
	<script type="text/javascript" src="/static/js/layer/layer.min.js"></script>
	<script type="text/javascript" src="assets/js/site.js?ver=20251216"></script>
	<script type="text/javascript" src="/static/js/jquery.validate.js"></script>
	<script type="text/javascript" src="/static/js/common.js"></script>
    <script type="text/javascript" src="/static/js/axios.min.js"></script>
	<link  rel="stylesheet" href="assets/css/common.css"   />

    <!--[if lte IE 6]>
    <link rel="stylesheet" type="text/css" href="assets/css/ie6.css">
    <![endif]-->
    
    <link rel="stylesheet" href="/static/js/layui/css/layui.mobile.css">
    <link rel="stylesheet" href="assets/css/kjctn.css"   />
    <script src="/static/js/layui/layui.js"></script>
    <script src="/static/js/baguetteBox/js/highlight.min.js" async></script>
    <script type="text/javascript" src="assets/js/md5.js"></script>
	<script type="text/javascript" src="assets/js/socket.js?ver=150927"></script>
	<script type="text/javascript" src="assets/js/livechat_m.js?ver=20251216"></script>
	<script type="text/javascript" src="assets/js/chat.js?ver=20251216"></script>
	<script type="text/javascript" src="<?=$rootPath1 ?>/static/js/msg_reader.js?ver=20251216"></script>
    <script src="<?=$rootPath1 ?>/js/fingerprint.js"></script>
    <script src="<?=$rootPath1 ?>/js/html5ImgCompress.min.js"></script>
    <script src="<?=$rootPath1 ?>/js/recorder.wav.min.js?ver=20230218"></script>
    <script src="<?=$rootPath1 ?>/socket.io/socket.io.js"></script>
    <script type='text/javascript' src='<?=$rootPath1 ?>/js/common.js?ver=20251216' charset='utf-8'></script>
    <script type='text/javascript' src='<?=$rootPath1 ?>/js/client/client.js?ver=20251216' charset='utf-8'></script>
    <?php } ?> 
    <title><?=get_lang('page_title') ?></title>