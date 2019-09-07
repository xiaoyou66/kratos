(function() {
    tinymce.create('tinymce.plugins.success', {
        init : function(ed, url) {
            ed.addButton('success', {
                title : '绿色背景栏',
                image : url+'/images/success.png',
                onclick : function() {
                     ed.selection.setContent('[success]' + ed.selection.getContent() + '[/success]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('success', tinymce.plugins.success);
    tinymce.create('tinymce.plugins.info', {
        init : function(ed, url) {
            ed.addButton('info', {
                title : '蓝色背景栏',
                image : url+'/images/info.png',
                onclick : function() {
                     ed.selection.setContent('[info]' + ed.selection.getContent() + '[/info]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('info', tinymce.plugins.info);
    tinymce.create('tinymce.plugins.danger', {
        init : function(ed, url) {
            ed.addButton('danger', {
                title : '红色背景栏',
                image : url+'/images/danger.png',
                onclick : function() {
                     ed.selection.setContent('[danger]' + ed.selection.getContent() + '[/danger]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('danger', tinymce.plugins.danger);     
    tinymce.create('tinymce.plugins.successbox', {
        init : function(ed, url) {
            ed.addButton('successbox', {
                title : '绿色面板',
                image : url+'/images/successbox.png',
                onclick : function() {
                     ed.selection.setContent('[successbox title="标题内容"]' + ed.selection.getContent() + '[/successbox]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('successbox', tinymce.plugins.successbox);
    tinymce.create('tinymce.plugins.infoboxs', {
        init : function(ed, url) {
            ed.addButton('infoboxs', {
                title : '蓝色面板',
                image : url+'/images/infobox.png',
                onclick : function() {
                     ed.selection.setContent('[infobox title="标题内容"]' + ed.selection.getContent() + '[/infobox]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('infoboxs', tinymce.plugins.infoboxs);
    tinymce.create('tinymce.plugins.dangerbox', {
        init : function(ed, url) {
            ed.addButton('dangerbox', {
                title : '红色面板',
                image : url+'/images/dangerbox.png',
                onclick : function() {
                     ed.selection.setContent('[dangerbox title="标题内容"]' + ed.selection.getContent() + '[/dangerbox]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('dangerbox', tinymce.plugins.dangerbox);        
    tinymce.create('tinymce.plugins.title', {
        init : function(ed, url) {
            ed.addButton('title', {
                title : '内容标题',
                image : url+'/images/title.png',
                onclick : function() {
                     ed.selection.setContent('[title]' + ed.selection.getContent() + '[/title]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('title', tinymce.plugins.title);

    tinymce.create('tinymce.plugins.highlight', {
        init : function(ed, url) {
            ed.addButton('highlight', {
                title : '代码美化',
                image : url+'/images/highlight.png',
                onclick : function() {
                     ed.selection.setContent('[highlight lanaguage="语言"]<pre><br>' + ed.selection.getContent() + '</pre>[/highlight]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('highlight', tinymce.plugins.highlight);

    tinymce.create('tinymce.plugins.block', {
        init : function(ed, url) {
            ed.addButton('block', {
                title : '代码块',
                image : url+'/images/codeblock.png',
                onclick : function() {
                    ed.selection.setContent('[block]<pre><br>' + ed.selection.getContent() + '</pre>[/block]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('block', tinymce.plugins.block);



    tinymce.create('tinymce.plugins.accordion', {
        init : function(ed, url) {
            ed.addButton('accordion', {
                title : '展开收缩',
                image : url+'/images/accordion.png',
                onclick : function() {
                     ed.selection.setContent('[collapse title="标题内容"]' + ed.selection.getContent() + '[/collapse]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('accordion', tinymce.plugins.accordion);
    tinymce.create('tinymce.plugins.hide', {
        init : function(ed, url) {
            ed.addButton('hide', {
                title : '回复可见',
                image : url+'/images/hide.png',
                onclick : function() {
                     ed.selection.setContent('[hide reply_to_this="true"]' + ed.selection.getContent() + '[/hide]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('hide', tinymce.plugins.hide);

    tinymce.create('tinymce.plugins.striped', {
        init : function(ed, url) {
            ed.addButton('striped', {
                title : '进度条',
                image : url+'/images/striped.png',
                onclick : function() {
                     ed.selection.setContent('[striped]' + ed.selection.getContent() + '[/striped]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('striped', tinymce.plugins.striped);
    tinymce.create('tinymce.plugins.ypbtn', {
        init : function(ed, url) {
            ed.addButton('ypbtn', {
                title : '云盘下载',
                image : url+'/images/ypbtn.png',
                onclick : function() {
                     ed.selection.setContent('[ypbtn]' + ed.selection.getContent() + '[/ypbtn]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('ypbtn', tinymce.plugins.ypbtn);
    tinymce.create('tinymce.plugins.music', {
        init : function(ed, url) {
            ed.addButton('music', {
                title : '网易云音乐',
                image : url+'/images/music.png',
                onclick : function() {
                     ed.selection.setContent('[music autoplay="0"]' + ed.selection.getContent() + '[/music]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('music', tinymce.plugins.music);
    tinymce.create('tinymce.plugins.wxmusic', {
        init : function(ed, url) {
            ed.addButton('wxmusic', {
                title : '本地音乐播放器',
                image : url+'/images/weixinmusic.png',
                onclick : function() {
                    ed.selection.setContent('[wxmusic url="地址" author="作者" title="标题"]' + ed.selection.getContent() + '[/wxmusic]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('wxmusic', tinymce.plugins.wxmusic);
    tinymce.create('tinymce.plugins.bilibili', {
        init : function(ed, url) {
 
            ed.addButton('bilibili', {
                title : '哔哩哔哩',
                image : url+'/images/bilibili.png',
                onclick : function() {
                     ed.selection.setContent('[bilibili cid="" page="1"]' + ed.selection.getContent() + '[/bilibili]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('bilibili', tinymce.plugins.bilibili);







})();