=== QPlayer悬浮音乐播放器 ===
Contributors: Jrohy
Donate link: https://32mb.space/usr/themes/Mirages/img/wx-tb.jpg
Tags: player, music, netease
Requires at least: 3.0.1
Tested up to: 4.6.1
Stable tag: 1.3.4.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

这是一款简洁小巧的底部悬浮HTML5音乐播放器，支持添加网易云音乐

This is a mini HTML5 Music Player plugin, it support netease music

Language: Chinese

== Installation ==

1. Upload `QPlayer` to the `/wp-content/plugins/` directory 上传QPlayer文件夹到'/wp-content/plugins/'目录
2. Activate the plugin through the 'Plugins' menu in WordPress 在WordPress后台激活插件，到设置页面进行设置

== Frequently Asked Questions ==

= 支持自定义音乐添加吗 =

按照播放器基本法是滋瓷的


== Screenshots ==

1. https://32mb.space/usr/uploads/2016/08/858331127.png


== Changelog ==
= 1.3.4.2 =
* 修复歌曲链接为空时不会自动跳过的bug
* 规范列表ul为数字表示

= 1.3.4.1 =
* 网易云音乐单曲解析不再支持国外服务器(国外ip)，遂完善提示信息
* 更换默认歌曲源

= 1.3.4 =
* 新增 歌曲快进快退功能
* 完善 随机播放(可记住随机播放状态了)
* 修正 随机播放按钮提示
* 修正 开启随机播放后改变歌曲导致播放器无法使用

= 1.3.3 =
* 添加首次运行使用帮助
* 更换更美观的通知样式
* 修复 播放列表错位
* 修复 ie和edge部分兼容问题
* 修正 默认歌曲链接

= 1.3.2 =
* 升级jquery稳定版本
* 删除少用的jquery-ui.js以精简代码

= 1.3.1 =
* 添加随机播放功能. 按钮位置嘛， 自己慢慢找下
* 恢复自定义主色调功能

= 1.3 =
* 添加自定义CSS和JS功能

= 1.2.1 =
* 优化切换动画
* 将所有Jquery动画改为CSS动画, 减少卡顿

= 1.2 =
* 添加网易云音乐解析

= 1.1.2 =
* 修复显示溢出bug
* 溢出时自动启用跑马灯

= 1.1 =
* 修复点击下一首会回跳歌曲等bug
* 添加了封面旋转、歌曲列表滚动条，限制了歌曲列表高度
* 现在可以自定义播放器主色调颜色了

== 说明 ==

为了让播放不会暂停，建议配合PJAX来使用
https://32mb.space/archives/7.html
http://www.ihewro.com/archives/354/