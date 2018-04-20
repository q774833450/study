<link rel="stylesheet" href="assets/admin/css/compiled/user-list.css" type="text/css" media="screen" />
<!-- main container -->
<div class="content">

    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>角色列表</h3>
                <div class="span10 pull-right">
                    <a href="<?php echo yii\helpers\Url::to(['rbac/createrole']) ?>" class="btn-flat success pull-right">
                        <span>&#43;</span>
                        添加新角色
                    </a>
                </div>
            </div>

            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span3 sortable">
                            <span class="line"></span>角色名
                        </th>
                        <th class="span3 sortable">
                            <span class="line"></span>类型
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>形容
                        </th>
                        <th class="span3 sortable">
                            <span class="line"></span>规则名
                        </th>
                        <th class="span3 sortable">
                            <span class="line"></span>数据
                        </th>
                        <th class="span3 sortable align-right">
                            <span class="line"></span>操作
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row -->
                    <?php

                    foreach($dataProvider as $data): ?>
                        <tr class="first">
                            <td>
                                <?php echo isset($data->name) ? $data->name : '未填写'; ?>
                            </td>
                            <td>
                                <?php echo isset($data->type) ? $data->type : '未填写'; ?>
                            </td>
                            <td>
                                <?php echo isset($data->description) ? $data->description : '未填写'; ?>
                            </td>
                            <td>
                                <?php echo isset($data->rule_name) ? $data->rule_name : '未填写'; ?>
                            </td>
                            <td>
                                <?php echo isset($data->data) ? $data->data : '未填写'; ?>
                            </td>
                            <td class="align-right">
                                <a href="<?php echo yii\helpers\Url::to(['rbac/assignitem', 'name' => $data->name]); ?>">分配权限</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
<!--            <div class="pagination pull-right">-->
<!--                --><?php //echo yii\widgets\LinkPager::widget([
//                    'pagination' => $pager,
//                    'prevPageLabel' => '&#8249;',
//                    'nextPageLabel' => '&#8250;',
//                ]); ?>
<!--            </div>-->
            <!-- end users table -->
        </div>
    </div>
</div>
<!-- end main container -->
