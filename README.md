# 接口化简易在线图像识别平台
<font color=#999AAA >随着深度卷积神经网络的发展和更多强大的计算构架的出现，使得图像识别精确度和能力上快速提升。图像识别技术的使用也越来越广泛，在指纹识别、人脸识别、车牌识别的应用大大方便了我们的生活，可是这类应用大多数是不具备二次开发的本地应用。因此，开发一套具备二次开发功能力在线图像识别系统就有一定的意义。不仅可以把图像识别技术分享给众多开发者使用，还可以促进系统学习提高识别精度。
<hr style=" border:solid; width:100px; height:1px;" color=#000000 size=1">

@[TOC](文章目录)

</font>

<hr style=" border:solid; width:100px; height:1px;" color=#000000 size=1">

# 介绍

<font color=#999AAA >本系统是一款基于B/S架构开发的WEB系统，系统提供了图像识别的API，包括识别文字，识别人脸，识别二维码等功能。开发者可以轻松的将本系统具备的功能应用在其系统上，在免去开发，维护等复杂过程的同时，可以便捷的应用图像识别API。</font>

<hr style=" border:solid; width:100px; height:1px;" color=#000000 size=1">


# 一、模块设计


<font color=#999AAA >该系统主要分为三大模块系统介绍模块、用户管理模块、后台管理模块
![模块设计图](https://img-blog.csdnimg.cn/2020090814513420.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L3hpYW9fYmluX3NoZW4=,size_16,color_FFFFFF,t_70#pic_center)



# 二、用例子设计
## 1.用例图
![用例图](https://img-blog.csdnimg.cn/20200908145022544.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L3hpYW9fYmluX3NoZW4=,size_16,color_FFFFFF,t_70#pic_center)
# 二、数据库设计
## 1.irp_user 表的设计
| 字段名 | 数据类型 | 大小 | 主键 | 备注和说明 |
|:----------:|:-------:|:-----------:|:-----------:|:-----------:|
| 标识（uid） | int | 11 | 是|自增列，不为空 |
| 昵称（name） | 	varchar | 255 | 	-- | 	--|
| 邮箱(email) | 	varchar	 | 255	 | --	 | 用户登陆识别的|
| 密码（pwd） | 	varchar | 	255 | 	--	 | --|
| 状态（status） | 	int	 | 11 | 	--	 | 1：激活 0：禁用|
| 登录时间（login_time） | 	datetime | 	--	 | -- | 	最近登陆时间|
| 更新时间（update_time）	 | datetime	 | --	 | -- | 	--|
| 注册时间（time）	 | datetime | 	-- | 	--	 | --
| 开放ID（openid） | 	varchar	 | 255	 | -- | 	第三方登陆用的|
| 登录信息（login_info）	 | varchar	 | 255 | 	--	 | Json格式数据|
| 登录次数（login_count） | 	int | 	255 | 	-- | 	--|
| 头像（avatar）	 | datetime | 	255	 | --	 | 头像地址|
| 积分（integral） | 	int | 	11 | 	-- | 	--|
| 位置（place） | 	varchar	 | 255	 | --	 | 用户地址信息|
| 手机号（phone） | 	varchar | 	255 | 	-- | 	--|
| 应用（application） | 	varchar	 | 255 | 	--	 | --|
| 行业（business） | 	varchar	 | 255	 | -- | 	--|


<font color=#999AAA >提示：其他表设计详细看数据库接口设计文档

# 三、接口设计


<font color=#999AAA >一般用户登陆接口：

```c
URL	：{ROOT}/login
传输协议	：	https	请求方式	：	post
接口说明：普通用户登陆验证用的
参数：email,password,code
返回值： result->是否成功（1成功，0失败）,msg->提醒信息

```
<font color=#999AAA >一般用户登陆接口：

```c
URL	：{ROOT}/admin/user_list
传输协议	：	https	请求方式	：	post
接口说明	：获取所有用户信息用的
参数说明	： 参数名	         描述
	   pageNumber	  请求第几页的数据(非空)
	    pageSize	  每一页有多少条数据(非空)
	   sortOrder	  正序还是倒序(非空)
	    sortName	  排序的字段
	   searchText	  搜索的关键字
返回值	：total->总的有几条数据，data->当前页面的所有记录，last_page->最后一页

```
<font color=#999AAA >提示：其他表设计详细看数据库接口设计文档


<hr style=" border:solid; width:100px; height:1px;" color=#000000 size=1">

# 四、实现效果
## 1.登录页面
![登录页面](https://img-blog.csdnimg.cn/20200908151517239.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L3hpYW9fYmluX3NoZW4=,size_16,color_FFFFFF,t_70#pic_center)

## 2.头像裁剪
![头像裁剪](https://img-blog.csdnimg.cn/20200908151557840.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L3hpYW9fYmluX3NoZW4=,size_16,color_FFFFFF,t_70#pic_center)

## 3.人脸标记接口
 ![人脸标记](https://img-blog.csdnimg.cn/20200908151628994.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L3hpYW9fYmluX3NoZW4=,size_16,color_FFFFFF,t_70#pic_center)
## 4.后台图表统计
![在这里插入图片描述](https://img-blog.csdnimg.cn/20200908151727106.png?x-oss-process=image/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L3hpYW9fYmluX3NoZW4=,size_16,color_FFFFFF,t_70#pic_center)

# 五、总结
<font color=#999AAA >本系统简单实现WEB接口化服务功能与简单的图像识别能力，包括ORC文字识别，二维码识别，人脸标记，颜色识别，特征值提取等能力，供大家学习参考！
