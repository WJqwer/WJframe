<?php include "../app/admin/view/common/header.php"?>
        <!--右侧主体区域部分 start-->
        <div class="col-xs-12 col-sm-9 col-lg-10">
            <!-- TAB NAVIGATION -->
            <ul class="nav nav-tabs" role="tablist">

                <li class="active"><a href="#tab1">修改密码</a></li>
            </ul>
            <form action="" method="POST" class="form-horizontal" role="form">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">修改密码</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">用户名</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" placeholder=""
                                       value="<?php echo $_SESSION['admin_username'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">旧密码</label>
                            <div class="col-sm-10">
                                <input type="password" name="oldpassword" class="form-control" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">新密码</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" placeholder="" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">确认新密码</label>
                            <div class="col-sm-10">
                                <input type="password" name="pwd" class="form-control" placeholder="" value="">
                            </div>
                        </div>
                        <input type="hidden" class="form-control" name="admin_id" placeholder=""
                               value="<?php echo $_SESSION["admin_id"] ?>">


                    </div>
                </div>
                <button class="btn btn-primary">提交数据</button>
            </form>
        </div>
<?php include "../app/admin/view/common/footer.php"?>
