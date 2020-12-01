<?php
/**
 * User: tan
 */

namespace app\lbs\service;

use app\common\service\BaseService;
use app\lbs\model\LbsConfigModel;

class LbsConfigService extends BaseService
{
    /**
     * 添加、编辑配置地图API秘钥
     *
     * @param $user_data
     *
     * @return array|bool
     */
    function addOrEditConfig($data)
    {
        if(empty($data['name'])) return self::createReturn(false, null, '配置项名称不能为空');
        if(empty($data['key'])) return self::createReturn(false, null, '配置项Key不能为空');
        $LbsConfigModel = new LbsConfigModel();
        if (!empty($data['id'])) {
            // 编辑
            $res = $LbsConfigModel->where('id', $data['id'])->save($data);
            if ($res) {
                return self::createReturn(true, null, '更新成功');
            }
        } else {
            $res = $LbsConfigModel->insert($data);
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
    function deleteConfig($id)
    {
        if (empty($id)) {
            return self::createReturn(false, null, '请指定需要删除的配置');
        }
        $LbsConfigModel = new LbsConfigModel();
        $res = $LbsConfigModel->where('id', $id)->delete();
        if ($res) {
            return self::createReturn(true, null, '删除成功');
        } else {
            return self::createReturn(false, null, '删除失败');
        }
    }

    /**
     * 获取配置信息
     * @param $key
     */
    static function getConfigByKey($key)
    {
        $where = null;
        if ($key) $where['key'] = $key;
        $LbsConfigModel = new LbsConfigModel();
        return $LbsConfigModel->where($where)->value('value') ?: 0;
    }
}