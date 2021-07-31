<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:89:"D:\phpstudy_pro\WWW\zinuojin\public/../application/admin\view\article\special\detail.html";i:1627625871;s:71:"D:\phpstudy_pro\WWW\zinuojin\application\admin\view\layout\default.html";i:1617358420;s:68:"D:\phpstudy_pro\WWW\zinuojin\application\admin\view\common\meta.html";i:1617358420;s:70:"D:\phpstudy_pro\WWW\zinuojin\application\admin\view\common\script.html";i:1617358420;}*/ ?>
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
                                <form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">
    <?php echo token(); ?>
    <div class="form-group">
        <label for="c-username" class="control-label col-xs-12 col-sm-2"><?php echo __('专栏标题'); ?>:</label>
        <div class="col-xs-12 col-sm-4">
            <input id="c-username" data-rule="required" class="form-control" name="row[title]" type="text" value="<?php echo htmlentities($row['title']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-nickname" class="control-label col-xs-12 col-sm-2"><?php echo __('专栏分类'); ?>:</label>
        <div class="col-xs-12 col-sm-4">
            <input id="c-nickname" data-rule="required" class="form-control" name="row[names]" type="text" value="<?php echo htmlentities($row['names']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-mobile" class="control-label col-xs-12 col-sm-2"><?php echo __('专栏简介'); ?>:</label>
        <div class="col-xs-12 col-sm-4">
            <input id="c-mobile" data-rule="" class="form-control" name="row[synopsis]" type="text" value="<?php echo htmlentities($row['synopsis']); ?>">
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
    <!--<div class="form-group">
        <label for="c-banner" class="control-label col-xs-12 col-sm-2"><?php echo __('轮播'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-banner" data-rule="" class="form-control" size="50" name="row[banner]" type="text" value="<?php echo $row['banner']; ?>">
                <div class="input-group-addon no-border no-padding">
                    <img src="<?php echo $row['banner']; ?>">
                </div>
                <span class="msg-box n-right" for="c-cover"></span>
            </div>
            <ul class="row list-inline faupload-preview" id="p-banner"></ul>
        </div>
    </div>-->
    <div class="form-group">
        <label for="c-price" class="control-label col-xs-12 col-sm-2"><?php echo __('专栏价格'); ?>:</label>
        <div class="col-xs-12 col-sm-4">
            <input id="c-price" data-rule="required" class="form-control" name="row[price]" type="number" value="<?php echo $row['price']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-all_periods" class="control-label col-xs-12 col-sm-2"><?php echo __('专预计期数'); ?>:</label>
        <div class="col-xs-12 col-sm-4">
            <input id="c-all_periods" data-rule="required" class="form-control" name="row[all_periods]" type="number" value="<?php echo $row['all_periods']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-periods" class="control-label col-xs-12 col-sm-2"><?php echo __('专预已发布期数'); ?>:</label>
        <div class="col-xs-12 col-sm-4">
            <input id="c-periods" data-rule="required" class="form-control" name="row[periods]" type="number" value="<?php echo $row['periods']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('收费设置'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_radios('row[is_charge]', ['1'=>__('会员免费'), '2'=>__('全部免费'),'3'=>'全部收费'], $row['is_charge']); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="c-buy_num" class="control-label col-xs-12 col-sm-2"><?php echo __('解锁人数'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-buy_num" data-rule="" class="form-control" name="row[buy_num]" type="text" value="<?php echo htmlentities($row['buy_num']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-share_num" class="control-label col-xs-12 col-sm-2"><?php echo __('分享人数'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-share_num" data-rule="" class="form-control" name="row[share_num]" type="text" value="<?php echo htmlentities($row['buy_num']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-create_time" class="control-label col-xs-12 col-sm-2"><?php echo __('创建时间'); ?>:</label>
        <div class="col-xs-12 col-sm-4">
            <input id="c-create_time" data-rule="" class="form-control" name="row[create_time]" type="text" value="<?php echo date('Y-m-d H:i:s',$row['create_time']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-update_time" class="control-label col-xs-12 col-sm-2"><?php echo __('更新时间'); ?>:</label>
        <div class="col-xs-12 col-sm-4">
            <input id="c-update_time" data-rule="" class="form-control" name="row[update_time]" type="text" value="<?php echo date('Y-m-d H:i:s',$row['update_time']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="content" class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php echo build_radios('row[status]', ['normal'=>__('Normal'), 'hidden'=>__('Hidden')], $row['status']); ?>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
