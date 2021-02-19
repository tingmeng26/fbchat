<?php
$ary_submenu = array(
	'event' => array(
        'Fossil玩家列表' => $manage_path . 'event/index.php',
        'IELTS玩家列表' => $manage_path . 'ielts/index.php',
        'IELTS2玩家列表' => $manage_path . 'ielts2/index.php',
        'HA3玩家列表' => $manage_path . 'ha3/index.php',
	),
    'admin' => array(
        '帳號管理' => $manage_path . 'admin/index.php',
        '操作歷程記錄' => $manage_path . 'adminlog/index.php'
	),
);
?>            <!-- BEGIN Sidebar -->
            <div id="sidebar" class="navbar-collapse collapse">
                <!-- BEGIN Navlist -->
                <ul class="nav nav-list">
                    <li>
                        <a href="../home/index.php">
                            <i class="icon-home"></i>
                            <span>首頁</span>
                        </a>
                    </li>
                    <?php coderAdmin::drawMenu($ary_submenu);?>

                </ul>
                <!-- END Navlist -->

                <!-- BEGIN Sidebar Collapse Button -->
                <div id="sidebar-collapse" class="visible-lg">
                    <i class="icon-double-angle-left"></i>
                </div>
                <!-- END Sidebar Collapse Button -->
            </div>
            <!-- END Sidebar -->
