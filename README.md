Trotri
======

当前版本：beta-1.0.0，仅支持PHP5.3及以上版本，包含两部分：TFC框架(Trotri Foundation Classes缩写)、Trotri基于TFC开发的CMS系统。
___
<br>

##TFC - Trotri Foundation Classes
###整洁、快速、专业的PHP框架
TFC功能非常丰富，包括：DB、MVC、路由、缓存、日志、插件、多语言、加解密、自动验证、身份验证、角色认证、图片水印、缩略图、验证码、程序引导、业务平台等。<br>
请点击右边 “Download ZIP” 按钮下载并解压。<br>
代码存放地址：“根目录/libraries/tfc”<br>
API文档存放地址：“根目录/docs/TFC-Api/index.html”<br>
包图类图存放地址：“根目录/docs/TFC-Api/graph_class.html”
___

##Trotri
###基于TFC开发的CMS系统
Trotri功能包括：自动生成代码、用户组、用户权限、文档（支持动态表单）、菜单、广告、文件批量上传、专题、多语言、支持插件、基于组件开发等。<br>
请点击右边 “Download ZIP” 按钮下载，下载后解压安装即可，直接用浏览器访问 “根目录/webroot/install.php” 文件进行安装。

####安装步骤：
1、系统要求：PHP5.3或以上版本、PDO支持。<br/>
2、下载并解压后，直接用浏览器访问 “根目录/webroot/install.php” 文件进行安装。<br/>
3、如果安装出错，请阅读 “根目录/webroot/docs/Install-Readme.txt” 文档。

####Linux环境下安装注意点：
Linux对目录权限要求严格，为了安装正确，先将下面几个目录权限设置为：可读可写可执行（chmod 777 目录名）<br>
1、根目录/cfg/db        - 数据库配置：安装时填写的数据库配置存放在该目录。<br>
2、根目录/cfg/key       - 密钥配置：安装时随机生成的加密密钥、签名密钥存放在该目录。<br>
3、根目录/log           - 日志目录：存放系统打印的Warning日志、SQL语句等日志。<br>
4、根目录/data/runtime  - 临时文件：存放用户权限数据、表结构、生成的代码等。<br>
5、根目录/data/u        - 上传目录：用户上传图片存放目录。<br>
___

<br/>
* Trotri技术交流群：178497611
* [新浪微博：@Trotri](http://weibo.com/u/3849507848 "Trotri官方微博") 
* [官方网站：待上线](http://www.trotri.com/ "官方网站：http://www.trotri.com/")  --- ---

###
        亲，若您有任何Bug反馈、功能建议、技术分享，请马上发邮件到trotri@yeah.net，感激涕零！
        注：若您给我们提供Bug反馈、功能建议、技术分享，就代表您授权我们在网站首页展示您的建议。

宋欢
trotri@yeah.net
