<?php 
/* VPF 模板缓存文件 生成时间:2017-05-14 22:53:04 */ 
namespace Vpf\App\Cache;
use Vpf,Vpf\App;?>
<!DOCTYPE html><html lang="zh-cn"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"><meta name="keywords" content="virusv"><meta name="description" content=""><meta name="author" content="Virus.V"><link rel="shortcut icon" href="#" type="image/png"><title>景行教育 - 菜单管理</title><!--icheck--><link href="<?php echo(__THEME__); ?>/js/iCheck/skins/minimal/minimal.css" rel="stylesheet"><link href="<?php echo(__THEME__); ?>/js/iCheck/skins/square/square.css" rel="stylesheet"><link href="<?php echo(__THEME__); ?>/js/iCheck/skins/square/red.css" rel="stylesheet"><link href="<?php echo(__THEME__); ?>/js/iCheck/skins/square/blue.css" rel="stylesheet"><!--dashboard calendar--><link href="<?php echo(__THEME__); ?>/css/clndr.css" rel="stylesheet"><!--Morris Chart CSS --><link rel="stylesheet" href="<?php echo(__THEME__); ?>/js/morris-chart/morris.css"><!--common--><link href="<?php echo(__THEME__); ?>/css/style.css" rel="stylesheet"><link href="<?php echo(__THEME__); ?>/css/style-responsive.css" rel="stylesheet"><link href="<?php echo(__THEME__); ?>/gonghao/css/index.css" rel="stylesheet"><link rel="stylesheet" type="text/css" href="<?php echo(__THEME__); ?>/js/ios-switch/switchery.css" /><!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries --><!--[if lt IE 9]><script src="<?php echo(__THEME__); ?>/js/html5shiv.js"></script><script src="<?php echo(__THEME__); ?>/js/respond.min.js"></script><![endif]--></head><body class="sticky-header"><section><!-- left side start--><div class="left-side sticky-left-side"><!--logo and iconic logo start--><div class="logo"><a href="index.html"><img src="<?php echo(__THEME__); ?>/images/logo.png" alt=""></a></div><div class="logo-icon text-center"><a href="index.html"><img src="<?php echo(__THEME__); ?>/images/logo_icon.png" alt=""></a></div><!--logo and iconic logo end--><div class="left-side-inner"><!-- visible to small devices only --><div class="visible-xs hidden-sm hidden-md hidden-lg"><!-- <div class="media logged-user"><img alt="" src="<?php echo(__THEME__); ?>/images/photos/user-avatar.png" class="media-object"><div class="media-body"><h4><a href="#">John Doe</a></h4><span>"Hello There..."</span></div></div> --><h5 class="left-nav-title">账号操作</h5><ul class="nav nav-pills nav-stacked custom-nav"><!-- <li><a href="#"><i class="fa fa-user"></i><span>Profile</span></a></li><li><a href="#"><i class="fa fa-cog"></i><span>Settings</span></a></li> --><li><a href="#"><i class="fa fa-sign-out"></i><span>退出</span></a></li></ul></div><!--sidebar nav start--><ul class="nav nav-pills nav-stacked custom-nav"><?php if(is_array($_MENU)) : foreach($_MENU as $ctrl => $menu) : ?><?php if(empty($menu['subs'])) :  ?><li class="<?php if(CTRL_NAME == $ctrl) :  ?> active <?php endif; ?>"><a href="<?php echo($menu['url']); ?>"><i class="fa fa-<?php echo($menu['icon']); ?>"></i><span><?php echo($menu['title']); ?></span></a></li><?php else : ?><li class="menu-list <?php if(CTRL_NAME == $ctrl) :  ?> nav-active <?php endif; ?>"><a href=""><i class="fa fa-<?php echo($menu['icon']); ?>"></i><span><?php echo($menu['title']); ?></span></a><ul class="sub-menu-list"><?php if(is_array($menu['subs'])) : foreach($menu['subs'] as $sub_menu) : ?><li class="<?php if(CTRL_NAME == $ctrl && ACTN_NAME == $sub_menu[0]) :  ?> active <?php endif; ?>"><a href="<?php echo($sub_menu[2]); ?>"><?php echo($sub_menu[1]); ?></a></li><?php endforeach; endif; ?></ul></li><?php endif; ?><?php endforeach; endif; ?></ul><!--sidebar nav end--></div></div><!-- left side end--><!-- main content start--><div class="main-content" ><!-- header section start--><div class="header-section"><!--toggle button start--><a class="toggle-btn"><i class="fa fa-bars"></i></a><!--toggle button end--><!--search start--><form class="searchform" action="index.html" method="post"><input type="text" class="form-control" name="keyword" placeholder="Search here..." /></form><!--search end--><!--notification menu start --><div class="menu-right"><ul class="notification-menu"><li><a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><img src="<?php echo(__THEME__); ?>/images/photos/user-avatar.png" alt="" /><?php echo($_SESSION['username']); ?><span class="caret"></span></a><ul class="dropdown-menu dropdown-menu-usermenu pull-right"><li><a href="<?php echo(Vpf\U('Login/logout')); ?>"><i class="fa fa-sign-out"></i> 退出登录</a></li></ul></li></ul></div><!--notification menu end --></div><!-- header section end--><!-- page heading start--><div class="page-heading"><h3>                控制面板
            </h3><ul class="breadcrumb"><li><a href="">控制面板</a></li><li><a href="">公众号管理</a></li><li class="active"> 菜单管理 </li></ul></div><!-- page heading end--><!--body wrapper start--><div class="wrapper"><div class="row"><div class="col-md-4 "><div id="wechat-ui"><div class="wchat-menu"><ul><?php if(is_array($_RMENUS)) : foreach($_RMENUS as $rmkey => $rmenu) : ?><li class="menu-item"><span class="menu-title"><?php echo($rmenu['m_title']); ?></span><div class="sub-menu"><?php if(!empty($_SMENUS[$rmkey])) :  ?><ul><?php if(is_array($_SMENUS[$rmkey])) : foreach($_SMENUS[$rmkey] as $smenu) : ?><li><span><?php echo($smenu['m_title']); ?></span></li><?php endforeach; endif; ?></ul><?php endif; ?></div></li><?php endforeach; endif; ?></ul></div></div></div><div class="col-md-8"><!-- 菜单管理开始 --><div class="panel"><header class="panel-heading">                            修改菜单
                            <span class="tools pull-right"><a href="javascript:;" class="fa fa-chevron-down"></a></span></header><div class="panel-body" style="display: block;"><form role="form" id="" method="post" action="<?php echo($_URLS['add_menu']); ?>"><div class="form-group"><label for="selectMenuWhere">菜单位置选择</label><select class="form-control" id="selectMenuWhere" name="m_parent"><?php if(count($_RMENUS)<3) :  ?><option value="0">主菜单</option><?php endif; ?><?php if(is_array($_RMENUS)) : foreach($_RMENUS as $rmkey => $rmenu) : ?><?php if(empty($_SMENUS[$rmkey]) || count($_SMENUS[$rmkey])<5) :  ?><option value="<?php echo($rmkey); ?>"><?php echo($rmenu['m_title']); ?>的子菜单</option><?php endif; ?><?php endforeach; endif; ?></select></div><div class="form-group"><label for="inputMenuName">菜单名称</label><input type="text" class="form-control" id="inputMenuName" name="m_title" placeholder="请输入菜单名称"></div><div class="form-group"><label for="selectMenuAction">菜单动作</label><select class="form-control" id="selectMenuAction" name="m_type"><option value="VIEW">VIEW - 点击菜单跳转链接</option><option value="CLICK">CLICK - 点击菜单拉取消息</option><option value="scancode_push">scancode_push - 扫码推事件(客户端跳URL)</option><option value="scancode_waitmsg">scancode_waitmsg - 扫码推事件(客户端不跳URL)</option><option value="pic_sysphoto">pic_sysphoto - 弹出系统拍照发图</option><option value="pic_photo_or_album">pic_photo_or_album - 弹出拍照或者相册发图</option><option value="pic_weixin">pic_weixin - 弹出微信相册发图器</option><option value="location_select">location_select - 弹出地理位置选择器</option></select></div><div class="form-group"><label for="inputMenuAddtion">附加参数</label><input type="text" class="form-control" id="inputMenuAddtion" name="m_addition" placeholder="请输入参数"><p class="help-block">每个动作都带有个参数，比如“点击菜单跳转链接”的参数是要跳转的URL，“拉取消息”是事件的KEY值</p></div><div class="form-group"><label for="inputMenuIndex">位置编号</label><input type="text" class="form-control" id="inputMenuIndex" name="m_index" placeholder="请输入编号"><p class="help-block">菜单的排列顺序，数值越大越靠前</p></div><div class="checkbox"><label><input type="checkbox" class="js-switch" name="m_enable" value="1" checked></label><p class="help-block">启用本菜单</p></div><button type="submit" class="btn btn-primary">提交</button></form></div></div><!-- 菜单管理结束 --></div></div><div class="row"><div class="col-md-12"><div class="panel"><header class="panel-heading">                            菜单列表
                            <span class="tools pull-right"><a href="javascript:;" class="fa fa-chevron-down"></a></span></header><div class="panel-body" style="display: block;"><table class="table table-bordered"><thead><tr><th>标题</th><th>父菜单</th><th>排序</th><th>类型</th><th>参数</th><th>操作</th></tr></thead><tbody><?php if(is_array($_RMENUS)) : foreach($_RMENUS as $rmkey => $rmenu) : ?><tr><td><?php echo($rmenu['m_title']); ?></td><td>主菜单</td><td><?php echo($rmenu['m_index']); ?></td><td><?php echo($rmenu['m_type']); ?></td><td><?php echo($rmenu['m_addition']); ?></td><td><?php if(empty($_SMENUS[$rmkey])) :  ?><a class="btn btn-danger btn-xs" href="<?php echo(Vpf\U('THIS/delMenu','m_id='.$rmenu['m_id'])); ?>">删除</a>&nbsp;
                                        <?php endif; ?><button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#editMenuModal" data-menuid="<?php echo($rmenu['m_id']); ?>" data-menutitle="<?php echo($rmenu['m_title']); ?>">修改</button></td></tr><?php if(!empty($_SMENUS[$rmkey])) :  ?><?php if(is_array($_SMENUS[$rmkey])) : foreach($_SMENUS[$rmkey] as $smenu) : ?><tr class="active"><td><?php echo($smenu['m_title']); ?></td><td><?php echo($rmenu['m_title']); ?></td><td><?php echo($smenu['m_index']); ?></td><td><?php echo($smenu['m_type']); ?></td><td><?php echo($smenu['m_addition']); ?></td><td><a class="btn btn-danger btn-xs" href="<?php echo(Vpf\U('THIS/delMenu','m_id='.$smenu['m_id'])); ?>">删除</a>&nbsp;
                                            <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#editMenuModal" data-menuid="<?php echo($smenu['m_id']); ?>" data-menutitle="<?php echo($smenu['m_title']); ?>">修改</button></td></tr><?php endforeach; endif; ?><?php endif; ?><?php endforeach; endif; ?></tbody></table></div></div></div></div></div><!--body wrapper end--><!--footer section start--><footer>            2014 &copy; AdminEx by ThemeBucket
        </footer><!--footer section end--></div><!-- main content end--></section><div class="modal fade" id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="editModalLabel">修改<span id="namespace"></span></h4></div><form role="form" method="post" action="<?php echo($_URLS['edit_menu']); ?>"><input type="hidden" name="m_id" id="ehiddenMenuID"><div class="modal-body"><div class="form-group"><label for="eselectMenuWhere">菜单位置选择</label><select class="form-control" id="eselectMenuWhere" name="m_parent"><?php if(count($_RMENUS)<3) :  ?><option value="0">主菜单</option><?php endif; ?><?php if(is_array($_RMENUS)) : foreach($_RMENUS as $rmkey => $rmenu) : ?><?php if(empty($_SMENUS[$rmkey]) || count($_SMENUS[$rmkey])<5) :  ?><option value="<?php echo($rmkey); ?>"><?php echo($rmenu['m_title']); ?>的子菜单</option><?php endif; ?><?php endforeach; endif; ?></select></div><div class="form-group"><label for="einputMenuName">菜单名称</label><input type="text" class="form-control" id="einputMenuName" name="m_title" placeholder="请输入菜单名称"></div><div class="form-group"><label for="eselectMenuAction">菜单动作</label><select class="form-control" id="eselectMenuAction" name="m_type" ><option value="VIEW">VIEW - 点击菜单跳转链接</option><option value="CLICK">CLICK - 点击菜单拉取消息</option><option value="scancode_push">scancode_push - 扫码推事件(客户端跳URL)</option><option value="scancode_waitmsg">scancode_waitmsg - 扫码推事件(客户端不跳URL)</option><option value="pic_sysphoto">pic_sysphoto - 弹出系统拍照发图</option><option value="pic_photo_or_album">pic_photo_or_album - 弹出拍照或者相册发图</option><option value="pic_weixin">pic_weixin - 弹出微信相册发图器</option><option value="location_select">location_select - 弹出地理位置选择器</option></select></div><div class="form-group"><label for="einputMenuAddtion">附加参数</label><input type="text" class="form-control" id="einputMenuAddtion" name="m_addition" placeholder="请输入参数"><p class="help-block">每个动作都带有个参数，比如“点击菜单跳转链接”的参数是要跳转的URL，“拉取消息”是事件的KEY值</p></div><div class="form-group"><label for="einputMenuIndex">位置编号</label><input type="text" class="form-control" id="einputMenuIndex" name="m_index" placeholder="请输入编号"><p class="help-block">菜单的排列顺序，数值越大越靠前</p></div><div class="checkbox"><label><input type="checkbox" id="echeckboxEnable" class="js-switch" name="m_enable" value="1" checked></label><p class="help-block">启用本菜单</p></div></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">关闭</button><button type="submit" class="btn btn-primary">提交</button></div></form></div></div></div><!-- Placed js at the end of the document so the pages load faster --><script src="<?php echo(__THEME__); ?>/js/jquery-1.10.2.min.js"></script><script src="<?php echo(__THEME__); ?>/js/jquery-ui-1.9.2.custom.min.js"></script><script src="<?php echo(__THEME__); ?>/js/jquery-migrate-1.2.1.min.js"></script><script src="<?php echo(__THEME__); ?>/js/bootstrap.min.js"></script><script src="<?php echo(__THEME__); ?>/js/modernizr.min.js"></script><script src="<?php echo(__THEME__); ?>/js/jquery.nicescroll.js"></script><script src="<?php echo(__THEME__); ?>/js/ios-switch/switchery.js" ></script><!--common scripts for all pages--><script src="<?php echo(__THEME__); ?>/js/scripts.js"></script><script src="<?php echo(__THEME__); ?>/gonghao/js/index.js"></script></body></html>