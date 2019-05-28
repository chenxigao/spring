<?php

namespace App\Handlers;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler {
    public function translate($text)
    {
        //实例化 Http 客户端
        $http = new Client;

        //初始化配置信息
        $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $appid = config('services.baidu_translate.appid');
        $key = config('services.baidu_translate.key');
        $salt = time();

        //如果没有配置百度翻译，自动使用兼容的拼音翻译
        if (empty($appid) || empty($key)) {
            return $this->pinyin($text);
        }

        //根据文档生成 sign
        //http://api.fanyi.baidu.com/api/trans/product/apidoc
        //appid+q+salt+密匙的 MD5值
        $sign = md5($appid . $text . $salt . $key);

        //构建请求参数
        $query = http_build_query([
                'q'     => $text,
                'from'  => 'zh',
                'to'    => 'en',
                'appid' => $appid,
                'salt'  => $salt,
                'sign'  => $sign,
        ]);

        //发送HTTP GET请求
        $response = $http->get($api.$query);

        $result = json_decode($response->getBody(),true);

        /**获取结果如果清秋成功，结果如下：
        array:3 [▼
            "from" => "zh"
            "to" => "en"
            "trans_result" => array:1 [▼
                0 => array:2 [▼
                    "src" => "XSS 安全漏洞"
                    "dst" => "XSS security vulnerability"
                ]
            ]
        ]
         **/

        //尝试获取翻译结果
        if (isset($result['trans_result'][0]['dst'])){
            return str_slug($result['trans_result'][0]['dst']);
        }else{
            //如果百度没有结果，使用拼音作为后备计划
            return $this->pinyin($text);
        }
        
    }

    public function pinyin($text)
    {
        //拼音翻译
        return str_slug(app(Pinyin::class()->permalink($text)));
    }

}