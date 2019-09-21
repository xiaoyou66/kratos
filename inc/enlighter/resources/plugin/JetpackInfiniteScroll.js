/*!
 ---
 name: Enlighter.Jetpack.InfiniteScroll
 description: Plugin to enable Syntax Highlighting on Jetpack InifiteScroll Pages

 license: MIT-Style X11 License
 version: 1.0

 authors:
 - Andi Dittrich

 requires:
 - Enlighter/2.12
 ...
 */

// scope
jQuery(function(jq){
    // enlighterJS available ?
    if (typeof EnlighterJS == "undefined" || typeof EnlighterJS_Config == "undefined"){
        return;
    };

    // config objects
    var i =  Object.clone(EnlighterJS_Config);
    i.renderer = 'Inline';
    i.grouping = false;

    var b =  Object.clone(EnlighterJS_Config);
    b.renderer = 'Block';

    // helper to fetch all new elements
    var getNewElements = (function(s){
        // get all selected elements
        var e = document.getElements(s) || [];

        // filter new elements
        e = e.filter(function(el){
            // only visible elements are "new"
            return (el.getStyle('display') != 'none');
        });

        return e;
    });

    // re-initialize
    var _init = (function(){
        if (i.selector.inline){
            EnlighterJS.Util.Helper(getNewElements(i.selector.inline), i);
        }
        if (b.selector.block){
            EnlighterJS.Util.Helper(getNewElements(i.selector.block), b);
        }
    });

    // content update event
    jq(document.body).on('post-load', function(){
        _init.apply(window);
    });
});


