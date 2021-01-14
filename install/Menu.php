<?php

return[
   [
        //父菜单ID，NULL或者不写系统默认，0为顶级菜单
        "parentid" => 0,
        //地址，[模块/]控制器/方法
        "route" => "lbs/TencentMapConfigManage/index",
        //类型，1：权限认证+菜单，0：只作为菜单
        "type" => 0,
        //状态，1是显示，0不显示（需要参数的，建议不显示，例如编辑,删除等操作）
        "status" => 1,
        //名称
        "name" => "位置服务",
        //备注
        "remark" => "",
        //子菜单列表
        "child" =>[
           [
                "route" => "lbs/TencentMapConfigManage/index",
                "type" => 0,
                "status" => 1,
                "name" => "腾讯地图配置",
                "remark" => "",
                "child" =>[
                   [
                        "route" => "lbs/TencentMapConfigManage/getList",
                        "type" => 1,
                        "status" => 0,
                        "name" => "地图API秘钥列表",
                        "remark" => ""
                    ],
                   [
                        "route" => "lbs/TencentMapConfigManage/configTencentAdd",
                        "type" => 1,
                        "status" => 0,
                        "name" => "新增地图API秘钥",
                        "remark" => ""
                    ],
                   [
                        "route" => "lbs/TencentMapConfigManage/configTencentEdit",
                        "type" => 1,
                        "status" => 0,
                        "name" => "编辑地图API秘钥",
                        "remark" => ""
                    ],
                   [
                        "route" => "lbs/TencentMapConfigManage/getDetail",
                        "type" => 1,
                        "status" => 0,
                        "name" => "地图API秘钥详情",
                        "remark" => ""
                    ],
                   [
                        "route" => "lbs/TencentMapConfigManage/configTencentDelete",
                        "type" => 1,
                        "status" => 0,
                        "name" => "地图API秘钥删除",
                        "remark" => ""
                    ],
                   [
                        "route" => "lbs/TencentMapConfigManage/getKeyconfig",
                        "type" => 1,
                        "status" => 0,
                        "name" => "配置列表",
                        "remark" => ""
                    ],
                   [
                        "route" => "lbs/TencentMapConfigManage/configAdd",
                        "type" => 1,
                        "status" => 0,
                        "name" => "新增配置",
                        "remark" => ""
                    ],
                   [
                        "route" => "lbs/TencentMapConfigManage/configEdit",
                        "type" => 1,
                        "status" => 0,
                        "name" => "编辑配置",
                        "remark" => ""
                    ],
                   [
                        "route" => "lbs/TencentMapConfigManage/getConfigDetail",
                        "type" => 1,
                        "status" => 0,
                        "name" => "配置详情",
                        "remark" => ""
                    ],
                   [
                        "route" => "lbs/TencentMapConfigManage/configDelete",
                        "type" => 1,
                        "status" => 0,
                        "name" => "配置删除",
                        "remark" => ""
                    ],
                ],
            ],
           [
                "route" => "lbs/MapAdmin/demo",
                "type" => 0,
                "status" => 1,
                "name" => "示例",
                "remark" => "",
                "child" =>[
                   [
                        "route" => "lbs/MapAdmin/select_address_tencent",
                        "type" => 1,
                        "status" => 0,
                        "name" => "拾取器",
                        "remark" => ""
                    ],
                   [
                        "route" => "lbs/MapAdmin/select_address_tencentV2",
                        "type" => 1,
                        "status" => 0,
                        "name" => "地图拾点",
                        "remark" => ""
                    ],
                   [
                        "route" => "lbs/MapAdmin/geocoder_address_tencent",
                        "type" => 1,
                        "status" => 0,
                        "name" => "地址解析坐标",
                        "remark" => ""
                    ],
                   [
                        "route" => "lbs/MapAdmin/geocoder_location_tencent",
                        "type" => 1,
                        "status" => 0,
                        "name" => "坐标逆解析地址",
                        "remark" => ""
                    ],
                   [
                        "route" => "lbs/MapAdmin/geocoder_ip_tencent",
                        "type" => 1,
                        "status" => 0,
                        "name" => "IP解析地址",
                        "remark" => ""
                    ],
                ]

            ],
        ],
    ],
];
