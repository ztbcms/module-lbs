# 位置服务 LBS

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
    "status": true,
    "code": 200,
    "data": {
        "return_status": 0,             // 状态码，0为正常,
        310请求参数信息有误，
        311Key格式错误,
        306请求有护持信息请检查字符串,
        110请求来源未被授权
        "return_msg":'query ok',        //状态说明
        "lat": 23.08331,                //纬度
        "lng": 113.3172,                //经度
        "address": "新港东路1088号",    //地址
        "formatted_addresses":"广州大道南海珠区政府(敦丰路北)"   //经过腾讯地图优化过的描述方式，更具人性化特点,有时为空
        "ad_info": "中国,广东省,广州市,海珠区"                 //地址部件
    },
    "msg": "",
    "url": "",
    "state": "success"
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
     "status": true,
     "code": 200,
     "data": {
         "return_status": 0,             // 状态码，0为正常,
         310请求参数信息有误，
         311Key格式错误,
         306请求有护持信息请检查字符串,
         110请求来源未被授权
         "return_msg":'query ok',        //状态说明
         "lat": 23.08331,                //纬度
         "lng": 113.3172,                //经度
         "address": "新港东路1088号",    //地址
         "formatted_addresses":"广州大道南海珠区政府(敦丰路北)"   //经过腾讯地图优化过的描述方式，更具人性化特点,有时为空
         "ad_info": "中国,广东省,广州市,海珠区"                 //地址部件
     },
     "msg": "",
     "url": "",
     "state": "success"
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
      "status": 0,
      "message": "query ok",
      "result": {
          "ip": "202.106.0.30",
          "location": {
          "lng": 116.407526,
          "lat": 39.90403
      },
      "ad_info": {
          "nation": "中国",
          "province": "",
          "city": "",
          "adcode": 110000
      }
  }
```

