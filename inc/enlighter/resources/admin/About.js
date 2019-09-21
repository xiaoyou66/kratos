jQuery(function(jq){
    // container actions
    var currentTab = jq('#EnlighterTabNav a:first-child');
    jq('#EnlighterTabNav a').each(function(){
        // get current element
        var el = jq(this);

        // hide content container
        jq('#' + el.attr('data-tab')).hide();

        // click event
        el.click(function(){
            // remove highlight
            currentTab.removeClass('nav-tab-active');

            // hide container
            jq('#' + currentTab.attr('data-tab')).hide();

            // store current active tab
            currentTab = el;
            currentTab.addClass('nav-tab-active');

            // show container
            jq('#' + currentTab.attr('data-tab')).show();
        });
    });

    // show first container
    currentTab.click();

    // show navbar
    jq('#EnlighterTabNav').show();
});