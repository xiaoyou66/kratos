(function(){
    // fetch console object
    var _logError = function(msg){
        var prefix = 'Enlighter Error: ';
        if (console.error){
            console.error(prefix + msg);
        }else if (console.log){
            console.log(prefix + msg);
        }
    }

    // MooTools Check
    if (!window.addEvent){
        _logError('MooTools Framework not loaded yet!');
        return;
    }

    // EnlighterJS Check
    if (typeof EnlighterJS == 'undefined'){
        _logError('Javascript Resources not loaded yet!');
        return;
    }

    // EnlighterJS Config Check
    if (typeof EnlighterJS_Config == 'undefined'){
        _logError('Configuration not loaded yet!');
        return;
    }

    // Bootstrap
    window.addEvent('domready', function(){
        EnlighterJS.Util.Init(EnlighterJS_Config.selector.block, EnlighterJS_Config.selector.inline, EnlighterJS_Config);
    });
})();