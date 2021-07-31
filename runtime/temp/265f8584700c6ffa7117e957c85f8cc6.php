<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:83:"D:\phpstudy_pro\WWW\zinuojin\public/../application/admin\view\member\goods\add.html";i:1627375849;s:71:"D:\phpstudy_pro\WWW\zinuojin\application\admin\view\layout\default.html";i:1617358420;s:68:"D:\phpstudy_pro\WWW\zinuojin\application\admin\view\common\meta.html";i:1617358420;s:70:"D:\phpstudy_pro\WWW\zinuojin\application\admin\view\common\script.html";i:1617358420;}*/ ?>
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
    <div class="form-group">
        <label for="c-title" class="control-label col-xs-12 col-sm-2"><?php echo __('Title'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-title" data-rule="required" class="form-control" name="row[title]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('会员权益'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="checkbox">
                <?php if(is_array($power) || $power instanceof \think\Collection || $power instanceof \think\Paginator): if( count($power)==0 ) : echo "" ;else: foreach($power as $key=>$vo): ?>
                <label for="power_id-<?php echo $key; ?>">
                    <input id="power_id-<?php echo $key; ?>" name="row[power_id][]" type="checkbox" value="<?php echo $vo['id']; ?>" />
                    <?php echo $vo['title']; ?>
                </label>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="c-content" class="control-label col-xs-12 col-sm-2"><?php echo __('会员商品描述'); ?>:</label>
        <div class="col-sm-8" >
            <textarea id="c-content" style="width:100%; height:200px;"  data-rule="required" placeholder="最多可输入200字" name="row[describe]" type="text" value=""></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="c-price" class="control-label col-xs-12 col-sm-2"><?php echo __('现价'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-price" data-rule="required" class="form-control" onKeyUp="amount(this)" onBlur="overFormat(this)" name="row[price]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="c-original_price" class="control-label col-xs-12 col-sm-2"><?php echo __('原价'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-original_price" data-rule="required" class="form-control" onKeyUp="amount(this)" onBlur="overFormat(this)" name="row[original_price]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="c-duration" class="control-label col-xs-12 col-sm-2"><?php echo __('时限'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-duration" data-rule="required" placeholder="单位：日" class="form-control"  oninput = "value=value.replace(/[^\d]/g,'')" name="row[duration]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_radios('row[status]', ['normal'=>__('启用'), 'hidden'=>__('禁用')]); ?>
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
<!-- 实例化编辑器 -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
