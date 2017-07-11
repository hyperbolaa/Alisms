## 阿里短信
    支持阿里云的三种API短信方式，也许是目前最全的阿里云短信SDK！
    
#### 安装
    composer require  hyperbolaa/alisms dev-master
    
#### laravel 配置
     'providers' => [
         // ...
         Hyperbolaa\Alisms\AlismsServiceProvider::class,
     ]   

#### 生成配置文件
    运行 `php artisan vendor:publish` 命令，
    发布配置文件到你的项目中。
    
#### app代码使用
    $alisms = app('alisms.yun');
    //$alisms = app('alisms.api');
    //$alisms = app('alisms.note');
    $flag = $alisms->send('register','15588888888',['code'=>'456789']);//code 为模板中的变量名
    
    if($flag === true){
        //todo 发送成功处理
    }
 
    
#### 配置说明
    	'yun'=>[//阿里云短信
    		'access_key_id'        => 'xxxxxx',//
    		'access_key_secret'    => 'xxxxxx',//
    		'common_sign_name'     => '支付宝',//普通模板签名
    		'spread_sign_name'     => '支付宝',//推广模板签名
    		'template_code'        => [
    			'register' => 'SMS_35650882',//模板名让一个变量来替换
    		]
    	],
    
## 备注【阿里有两个短信API】
    
alisms.yun => [阿里云短信服务接口文档](https://help.aliyun.com/document_detail/44364.html?spm=5176.doc44368.6.567.0pKIZb)

alisms.api => [云市场短信接口文档](https://market.aliyun.com/products/57002003/cmapi011900.html?spm=5176.100239.blogcont59928.22.lumd22#sku=postpay)
     
alisms.note => [短信发送API接口文档](https://help.aliyun.com/document_detail/55451.html?spm=5176.doc56189.6.555.va0ALg)  
    
    
## 联系&打赏 ##

如果真心觉得项目帮助到你，为你节省了成本，欢迎鼓励一下。

如果有什么问题，可通过以下方式联系我。提供有偿技术服务。

也希望更多朋友可用提供代码支持。欢迎交流与打赏。

**加入QQ群**：60973229

**不错，我要鼓励一下**

![微信](http://onzbviqx3.bkt.clouddn.com/hyperbolaa_wechat.JPG?imageView2/2/w/200/h/300)
![支付宝](http://onzbviqx3.bkt.clouddn.com/hyperbolaa_alipay.JPG?imageView2/2/w/220/h/260)
 
  ## Related
  
  - [Ylpay](https://github.com/hyperbolaa/Ylpay)   基于laravel5的POS通支付
  - [Alipay](https://github.com/hyperbolaa/Alipay)  基于laravel5的支付宝支付
  - [Unionpay](https://github.com/hyperbolaa/Unionpay)  基于laravel5的银联支付
  - [Wechatpay](https://github.com/hyperbolaa/Wechatpay)  基于laravel5的微信支付
  
  
  