<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:87:"D:\phpstudy_pro\WWW\zinuojin\public/../application/admin\view\article\special\edit.html";i:1627626080;s:71:"D:\phpstudy_pro\WWW\zinuojin\application\admin\view\layout\default.html";i:1617358420;s:68:"D:\phpstudy_pro\WWW\zinuojin\application\admin\view\common\meta.html";i:1617358420;s:70:"D:\phpstudy_pro\WWW\zinuojin\application\admin\view\common\script.html";i:1617358420;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">
<meta name="referrer" content="never">
<meta name="robots" content="noindex, nofollow">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<?php if(\think\Config::get('fastadmin.adminskin')): ?>
<link href="/assets/css/skins/<?php echo \think\Config::get('fastadmin.adminskin'); ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">
<?php endif; ?>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>

    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !\think\Config::get('fastadmin.multiplenav') && \think\Config::get('fastadmin.breadcrumb')): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <?php if($auth->check('dashboard')): ?>
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                    <?php endif; ?>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <!--<div class="alert alert-warning-light">

    </div>-->
    <div class="form-group">
        <label for="c-pid" class="control-label col-xs-12 col-sm-2"><?php echo __('专栏分类'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select id="c-pid" data-rule="required" class="form-control selectpicker" name="row[type_id]">
                <?php if(is_array($parentList) || $parentList instanceof \think\Collection || $parentList instanceof \think\Paginator): if( count($parentList)==0 ) : echo "" ;else: foreach($parentList as $key=>$vo): ?>
                <option data-type="<?php echo $vo['id']; ?>" value="<?php echo $vo['id']; ?>" <?php if(in_array(($key), is_array($row['type_id'])?$row['type_id']:explode(',',$row['type_id']))): ?>selected<?php endif; ?>><?php echo $vo['names']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
    <div class="form-group">
        <label for="c-local" class="control-label col-xs-12 col-sm-2"><?php echo __('专栏封面'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-local" data-rule="" class="form-control" size="50" name="row[cover]" type="text" value="<?php echo $row['cover']; ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-local" class="btn btn-primary plupload" data-input-id="c-local" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-local"><i class="fa fa-upload"></i>  <?php echo __("上传封面"); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-local"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-local"></ul>
        </div>
    </div>
    <div class="form-group">
        <label for="c-thumb" class="control-label col-xs-12 col-sm-2">专栏轮播:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-thumb" class="form-control" size="50" name="row[banner]" type="text" value="<?php echo $row['banner']; ?>" />
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-imagethumb" class="btn btn-danger plupload" data-input-id="c-thumb" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/webp" data-multiple="true" data-preview-id="p-thumb"><i class="fa fa-upload"></i>上传轮播</button></span>
                </div>
                <span class="msg-box n-right"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-thumb"></ul>
        </div>
    </div>
    <div class="form-group">
        <label for="c-name" class="control-label col-xs-12 col-sm-2"><?php echo __('专栏标题'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-name" data-rule="required" class="form-control" name="row[title]" type="text" value="<?php echo $row['title']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-content" class="control-label col-xs-12 col-sm-2"><?php echo __('专栏简介'); ?>:</label>
        <div class="col-sm-8" >
            <textarea id="c-content" style="width:100%; height:200px;"  data-rule="required" placeholder="最多可输入200字" name="row[synopsis]" type="text" value=""><?php echo $row['synopsis']; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="c-duration" class="control-label col-xs-12 col-sm-2"><?php echo __('专栏期数'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-duration" data-rule="required" placeholder="请填写专栏预计发布期数" class="form-control"  oninput = "value=value.replace(/[^\d]/g,'')" name="row[all_periods]" type="text" value="<?php echo $row['all_periods']; ?>">
        </div>
    </div>
    <!-- <div class="form-group">
         <label for="weigh" class="control-label col-xs-12 col-sm-2"><?php echo __('Weigh'); ?>:</label>
         <div class="col-xs-12 col-sm-8">
             <input type="text" class="form-control" id="weigh" name="row[weigh]" value="0" data-rule="required" />
         </div>
     </div>-->
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('会员是否免费'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_radios('row[is_charge]', [ '1'=>__('会员免费'),'2'=>__('全部免费'),'3'=>_('全部收费')],$row['is_charge']); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="c-price" class="control-label col-xs-12 col-sm-2"><?php echo __('价格'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-price" data-rule="required" class="form-control" onKeyUp="amount(this)" onBlur="overFormat(this)" name="row[price]" type="text" value="<?php echo $row['price']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_radios('row[status]', ['normal'=>__('Normal'), 'hidden'=>__('Hidden')],$row['status']); ?>
        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>
<!-- 加载编辑器的容器 -->
<!-- 加载编辑器的容器 -->
<!-- 配置文件 -->
<script type="text/javascript" src="/assets/js/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/assets/js/ueditor/ueditor.all.js"></script>
<script type="text/javascript">
    /**
     * 实时动态强制更改用户录入
     *
     **/
    function amount(th,event) {
        var event = event || window.event;
        var code = event.keyCode;
        if(navigator.userAgent.indexOf("Firefox")>-1){
            code = event.which;
        }
        if(code == 37 || code ==39) return;
        var regStrs = [
            ['^0(\\d+)$', '$1'], //禁止录入整数部分两位以上，但首位为0
            ['[^\\d\\.]+$', ''], //禁止录入任何非数字和点
            ['\\.(\\d?)\\.+', '.$1'], //禁止录入两个以上的点
            ['^(\\d+\\.\\d{2}).+', '$1'], //禁止录入小数点后两位以上
            ['^(\\.\\d+)','$1']//禁止输入情况下小数点出现在首位
        ];
        for (i = 0; i < regStrs.length; i++) {
            var reg = new RegExp(regStrs[i][0]);
            th.value = th.value.replace(reg, regStrs[i][1]);

        }
    }

    /**
     * 录入完成后，输入模式失去焦点后对录入进行判断并强制更改，并对小数点进行0补全
     * s
     **/
    function overFormat(th) {
        var v = th.value;
        if (v === '') {
            v = '0.00';
        } else if (v === '0') {
            v = '0.00';
        } else if (v === '0.') {
            v = '0.00';
        } else if (/^0+\d+\.?\d*.*$/.test(v)) {
            v = v.replace(/^0+(\d+\.?\d*).*$/, '$1');
            v = inp.getRightPriceFormat(v).val;
        } else if (/^0\.\d$/.test(v)) {
            v = v + '0';
        } else if (!/^\d+\.\d{2}$/.test(v)) {
            if (/^\d+\.\d{2}.+/.test(v)) {
                v = v.replace(/^(\d+\.\d{2}).*$/, '$1');
            } else if (/^\d+$/.test(v)) {
                v = v + '.00';
            } else if (/^\d+\.$/.test(v)) {
                v = v + '00';
            } else if (/^\d+\.\d$/.test(v)) {
                v = v + '0';
            } else if (/^[^\d]+\d+\.?\d*$/.test(v)) {
                v = v.replace(/^[^\d]+(\d+\.?\d*)$/, '$1');
            } else if (/\d+/.test(v)) {
                v = v.replace(/^[^\d]*(\d+\.?\d*).*$/, '$1');
                ty = false;
            } else if (/^0+\d+\.?\d*$/.test(v)) {
                v = v.replace(/^0+(\d+\.?\d*)$/, '$1');
                ty = false;
            } else {
                v = '0.00';
            }
        }
        th.value = v;
    }
</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
