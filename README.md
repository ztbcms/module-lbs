# 位置服务 LBS
对接腾讯地图，通过地址获取坐标、通过地址获取坐标、通过地址获取坐标

## 腾讯地图

```php
use app\lbs\service\TencentMapService;
$service = new TencentMapService();//腾讯地图服务类
```
# 通过地址获取坐标

```php
$res = $service->geocoder_address($address);
# 参数: $address 地址（注：地址中请包含城市名称，否则会影响解析效果）
```

返回值：
```json
     {
         code: 200
         data: {
             address: "广东省广州市海珠区"
             city: "广州市"
             district: "海珠区"
             lat: "23.08331"
             lng: "113.3172"
             province: "广东省"
             street: ""
         }
         msg: ""
         status: true
         url: ""
     }
```

# 通过坐标获取地址
```php
$res = $service->geocoder_location($location);
# 参数:@param string $location 坐标值 例如23.08331,113.3172
```

返回值：
```json
    {
        code: 200
        data: {
            address: "广东省广州市海珠区敦丰路"
            city: "广州市"
            district: "海珠区"
            lat: "23.08331"
            lng: "113.3172"
            province: "广东省"
            street: "敦丰路"
        }
        msg: ""
        status: true
        url: ""
    }
  ```
# 通过IP获取地址

```php
$res = $service->geocoder_ip($ip);
# 参数:@param string $location 坐标值 例如61.135.17.68
```
返回值：
```json
{
    "status": true,
    "code": 200,
    "data": {
        "lat": 23.08331,
        "lng": 113.3172,
        "nation": "中国",
        "province": "广东省",
        "city": "广州市",
        "district": "海珠区",
        "create_time": "2020-12-01 16:02:37",
        "ip": "116.22.208.68",
        "address": "中国广东省广州市海珠区"
    },
    "msg": "",
    "url": ""
}
```

## 附近搜索(geohash 算法)基于 mysql 实现

### 相关链接：

- geohash php版实现 https://github.com/CloudSide/geohash
- geohash 示例 http://www.geohash.cn/
- 腾讯坐标拾取器 https://lbs.qq.com/tool/getpoint/index.html

### 使用方法
```php
use app\lbs\Service\LbsGeohashService;
$service = new LbsGeohashService();
// 添加位置对象
$service->geoAdd($target_type, $target_id, $latitude, $longitude);

# *参数
# * @param $target_type 类型，例如ad
# * @param $target_id 名称，例如上海半岛酒店-水疗中心
# * @param $longitude 纬度
# * @param $latitude 经度

// 删除的位置对象
$service->geoRemove($target_type, $target_id);

# *参数
# * @param $target_type 类型，例如ad
# * @param $target_id 名称，例如上海半岛酒店-水疗中心

// 以给定的经纬度为中心，返回目标集合中与中心的距离不超过给定最大距离的所有位置对象
// 建议对附近搜索的结果进行缓存
$lists = $service->geoRadius($target_type, $latitude, $longitude, $radius);

# *参数
# * @param $target_type string 类型
# * @param $latitude string|float 纬度
# * @param $longitude string|float 经度
# * @param $radius int 半径 单位：米
```

### 参考阅读

- https://www.jianshu.com/p/4d47a8a69c55
- https://segmentfault.com/a/1190000022734787
- https://segmentfault.com/a/1190000017279755

