# kiwi-core

## 功能

#### 多环境

- role

指明当前app的角色是什么

用途: 来区分不同行为, 如加载不同的路由

程序中通过EnvChecker判断是否为某角色下, 来实现不同的行为

eg: isAdmin, isWeb

详见环境说明

- profile

指明当前app的环境是什么, 和.env下的APP_ENV相同

用途: 获取不同的config文件, 是否加载某些组件(debugbar)

详见环境说明

- application

指明当前是哪个应用

目前仅仅在获取config文件时使用, 也就是不同application仅仅是配置不同, 行为的不同通过role区分

eg: admin, ant, www, ava等

当profile为local时, 因为不使用config容器,所以application无所谓

#### 多站点

通过配置kiwi.sites, 可以使用多站点功能

- 分为 主站点 和 附属站点
- 不同站点使用不同的表, 或者不同的数据库
- 后台通过左上角的"当前站点"进行切换, 菜单会随之变化, 进行不同站点的数据访问和修改
- 不支持 每个附属站点拥有不同菜单
- 不支持 每个附属站点分别分表或分库. 如site2对tdk,config进行分表, 而site3仅仅对tdk进行分表

> 目前后台切换站点后页面不会自动刷新, 需要手动f5一下. (因为使用pjax技术, Admin::disablePjax后看网站说有些bug, 未经验证)

#### 后台通过配置可以简化掉用户系统和权限管理

- 用户
- 权限
- 后台菜单

#### 配置管理

key-value的数据库存储, 同时指明value的类型, 实现get的转换

#### 展示项配置管理

- 元素: title, subtitle, image, link, attribute
- 单个展示项: 通过name指定, 也通过name获取单个项
- 组展示项: 通过parent指定, 也通过parent获取一组项
- 一般用户轮播图, 组展示项
- 单个展示项也可以通过 [配置管理](#配置管理) 来实现

#### 后台ckeditor
如果要使用full版本的ckeditor, 请官网下载拷贝到public目录中

#### 后台导入

批量导入数据到数据库

通过配置 kiwi.admin.importer 来实现导入工具的回调

#### 图片路径变换

ImageLinkFormat

#### 本地文件缓存封装

- Service
- Repository

#### 后台文件上传

route:
- 
- 

#### 反射封装

MemberAccessor

## 环境说明
启动后会去名为config的容器中获取配置
- application.properties
- application_{profile}.properties
- {application}_{profile}.properties

后面的会覆盖前面的配置

#### role

|name|desc|
|---|---|
|web|前台|
|admin|后台|

#### profile

同时也是.env文件中的APP_ENV的值

|name|desc|
|---|---|
|local|本地开发|
|local-test|本地测试,启动docker测试|
|test|测试|
|production|正式|

#### config最佳实践
- application

不包含APP_NAME, APP_ENV, DOMAIN, SITE, db和redis等第三方服务配置

- application-{profile}

包含APP_ENV, 第三方服务的配置

- {application}

包含APP_NAME, DOMAIN(route和完整url拼写的需求), SITE(多站点的需求)

- {application}-{profile}

特殊需求

## 安装

#### 配置后台菜单
```php
[
    "title" => "Cms",
    "icon" => "fa-paw",
    "children" => [
        [
            "title" => "Element",
            "icon" => "fa-object-group",
            "uri" => "/elements",
        ],
        [
            "title" => "Config",
            "icon" => "fa-cogs",
            "uri" => "/configs",
        ],
    ],
];
```

## 配置文件

#### kiwi

|name|desc|sample|
|---|---|---|
|site|当前站点名称,''为主站点|coupon2|
|sites|多站点配置||
|sites.name|所有附属站点|["coupon2"=>"ava", "coupon3"=>"bbs"]|
|sites.table|拥有附属站点的model|[\Kiwi\Core\Model\Config::class]|
|sites.database|||

## 最佳实践
## 例子
## 数据库
## 文件清单
## 设计




## 扩展模块
#### kiwi-core

核心模块, 开发网站, 开发app都可以依赖于它

#### kiwi-web

网站模块, 开发带有pc和mobile的网站可以依赖于它

#### kiwi-article

文章模块, 开发文章系统(频道,标签)可以依赖于它

#### kiwi-ant

爬虫模块, 带有stage概念的爬虫可以依赖于它

#### example

- coupon: core, web, article, ant
- game-name: core, web, article
- coin: core, web
- app: core, (api 还未开发)

#### config
- 想把外部 admin.php 所有部分都在Provider中动态配置，发现不行。AdminProvider启动就已经使用了一些配置，我们没有办法比它更早介入代码。
    - Kernel::sendRequestThroughRouter -> Kernel::bootstrap
    - Application::bootstrapWith([..., LoadConfiguration, ..., RegisterProviders, BootProviders, ]) 每个BootStrap 逐个调用 bootstrap
    - RegisterProviders::bootstrap -> Application::registerConfiguredProviders
    - Application::registerConfiguredProviders 通过ProviderRepository间接逐个调用 Application::register(string $provider)
    - Application::register 创建Provider object，调用provider->register()
    - BootProviders::bootstrap -> Application::boot， 逐个boot每个provider
    - composer update时生成bootstrap/cache/provider.php，决定加载顺序
    - when() 是被延迟加载使用的
    - 所以KiwiProvider是没有机会在AdminProvider register前执行任何代码的，注册事件也是在事件发生后注册的，接收不到
    - 所以使用外部admin.php最小化的优化方案，如下
- 外部admin.php必须提供的部分
    - directory AdminProvider 加载route.php的时候需要用到
- kiwi.upload 由FileService使用，FileService的使用场景
    - ROLE=api
    - admin ckeditor的图片上传
    - admin image和file控件，间接通过 MyUploadFile调用
- admin.upload 由encore和dcat使用，用于grid->image()和form->image()的链接拼接
- 在Provider中把kiwi.upload的内容复制到admin.upload
- encore的配置文件删除掉的部分
    - route 由AdminRoute配置
    - directory 有外部admin.php提供
    - auth 由AdminAuth配置
    - upload 有kiwi.upload提供
    - database 只需要menu_model，有AdminMenu提供
    - operation_log，check_route_permission，check_menu_roles，menu_bind_permission 不需要
- dcat的配置文件删除掉的部分
    - route 由AdminRoute配置
    - directory 有外部admin.php提供
    - auth,permission 由AdminAuth配置
    - upload 有kiwi.upload提供
    - database,menu 只需要menu_model，有AdminMenu提供
    - operation_log，check_route_permission，check_menu_roles，menu_bind_permission 不需要

#### TODO
- kiwi-api: 至少带有resource, login, ApiController
- Dcat FileForm
- Dcat import Action
- Dcat bootstrap的init
- 列出 encore 修改成 dcat 后，代码需要修改哪些（filter->where,Model::DefaultTimeFormat,extends Form, AbstractTool）

## FAQ
#### Dcat，在provider中动态设置的config无效，还是取的admin.php的配置

起因是发现 admin.database.menu_model 不生效，在kiwiProvider和provider.booted里 都是动态设置的值（在bootstrap/cache/services.php中查看所有provider），但是到了controller里就成了老值，甚至在地一个middleware AddQueuedCookiesToResponse 中也是老值

encore没有这种情况，只有dcat有

在router的runRouteWithinStack函数中打印middleware发现在AddQueuedCookiesToResponse之前还有一个dcat的application:admin这么一个middleware（其实php artisan route:list也能看到：中间件是Applicaiton:admin, admin）

顺着查找，发现dcat的Application可以实现多后台，在读取route.php时添加了这个middleware，所以在route.php中的路由会执行这个middleware，在kiwi模块中注册的路由没有这个middleware

不同的后台有不同的配置文件，这个Application会根据app_name读取不同的配置

启动时读取默认的“admin”的配置，boot->registerRoute->switch->withConfig，所以在kiwiProvider动态配置前，他已经缓存了admin的配置

request时在middleware中会，switch->withConfig，把缓存的配置拿出来，即老配置

解决办法：重写Applicaiton的loadRoutesFrom，不再添加Application的middleware，在register时覆盖dcat的Applicaiton。启动时还是会缓存配置，不过request时不再使用

#### import按钮render时会报找不到dcat.admin.dcat-api.action的路由

因为重写了Applicaiton的loadRoutesFrom，删除了middleware，domain，as。所以找不到了

解决办法：不要删除as

#### 刚刚切换成dcat时，render view时会去查看encore的类

缓存问题。解决方法：删除storage下的所有cache（cache，views，framework，。。。）

#### 上传文件时上传成功，却404，MyUploadField::upload中Storage::exists总返回存在

使用的是MyImage控件

原代码```$this->getStorage()->exists($path)```

修改后的代码 ```$this->storage->exists($path)```

```$this->getStorage()```，应该是dcat使用的，encore中却没有这个函数，而且Image的ImageField trait中实现了```__call() {return $this;}```

#### 上传文件时上传成功，oss没有，导致404

不知道为什么，写了一个aliyun OssSdk 的测试程序，成功上传一张图片后，这边也成功了。。。

#### 删除form中的图片时前端报错，发现Dcat.lang为null

需要把dcat的resource/lang拷过去，它比encore多好多项