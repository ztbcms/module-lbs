<?php
/**
 * Created by PhpStorm.
 * User: tan
 * Date: 2020-09-08
 * Time: 09:16.
 */

namespace app\lbs\service;

use app\common\service\BaseService;
use app\lbs\model\LbsConfigTencentModel;

class LbsConfigTencentService extends BaseService
{
    /**
     * 添加、编辑配置地图API秘钥
     *
     * @param $user_data
     *
     * @return array|bool
     */
    function addOrEditConfigTencent($data)
    {
        if(empty($data['key'])) return self::createReturn(false, null, 'key不能为空');
        $lbsConfigTencentModel = new LbsConfigTencentModel();
        if (!empty($data['id'])) {
            // 编辑
            $res = $lbsConfigTencentModel->where('id', $data['id'])->save($data);
            if ($res) {
                return self::createReturn(true, null, '更新成功');
            }
        } else {
            $res = $lbsConfigTencentModel->insert($data);
            if ($res) {
                return self::createReturn(true, null, '添加成功');
            }
        }

        return self::createReturn(true, null, '操作失败成功');
    }

    /**
     * 删除配置地图API秘钥
     *
     * @param $id
     *
     * @return array
     */
    function deleteConfigTencent($id)
    {
        if (empty($id)) {
            return self::createReturn(false, null, '请指定需要删除的配置');
        }
        $LbsConfigTencentModel = new LbsConfigTencentModel();
        $res = $LbsConfigTencentModel->where('id', $id)->delete();
        if ($res) {
            return self::createReturn(true, null, '删除成功');
        } else {
            return self::createReturn(false, null, '删除失败');
        }
    }
}