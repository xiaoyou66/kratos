/*!
---
name: Enlighter.ThemePreview
description: Experimental Theme Demo/Live Preview

license: MIT-Style X11 License
version: 1.0

authors:
  - Andi Dittrich http://andidittrich.de/
  
requires:
  - EnlighterJS/2.4

provides: [Enlighter]
...
*/

var _tp = new Class({
	
	container: null,
	wrapper: null,
	currentThemeBase: null,
	currentUserStyles: null,
	style: null,
	tokenKeys: ['kw1', 'kw2', 'kw3', 'kw4', 'co1', 'co2', 'st0', 'st1', 'st2', 'nu0', 'me0', 'me1', 'br0', 'sy0', 'es0', 're0', 'de1', 'de2'],
		
	initialize: function(){
		// get container
		this.container = document.getElements('.wpcustomEnlighterJS');
		this.wrapper = document.getElements('.wpcustomEnlighterJSWrapper');
	},
	
	
	// receives the updated settings from admin panel
	update: function(s){		
		// initialized ?
		if (!this.container || !this.wrapper){
			return;
		}
		
		// changes detected ? - performance improvement by not updating the document on each data-push
		var cu = Object.toQueryString(s);
		if (cu == this.currentUserStyles){
			return;
		}
		this.currentUserStyles = cu;
		
		// theme base changed ? add basic styles
		if (s.customThemeBase != this.currentThemeBase){
			// drop old base
			if (this.currentThemeBase){
				this.container.removeClass(this.currentThemeBase);
				this.wrapper.removeClass(this.currentThemeBase + 'Wrapper');
			}
			
			// generate theme name
			this.currentThemeBase = s.customThemeBase.toLowerCase() + 'EnlighterJS';
			
			// set new theme
			this.container.addClass(this.currentThemeBase);
			this.wrapper.addClass(this.currentThemeBase + 'Wrapper');
		}
		
		// remove previous styles
		this.dropCSSRules();
		
		// ========= FONT STYLES ======================
		this.addCSSRule('.wpcustomEnlighterJS span', {
			'font-family': 		s.customFontFamily,
			'color':		 	s.customFontColor,
			'line-height':		s.customLineHeight,
			'font-size':		s.customFontSize
		});
		
		// ========= LINE STYLES ======================
		this.addCSSRule('ol.wpcustomEnlighterJS, ol.wpcustomEnlighterJS li, ul.wpcustomEnlighterJS, ul.wpcustomEnlighterJS li', {
			'font-family': 		s.customLinenumberFontFamily,
			'font-size':		s.customLinenumberFontSize,
			'color':			s.customLinenumberFontColor
		});
		
		// ========= SPECIAL STYLES ======================
		this.addCSSRule('ol.wpcustomEnlighterJS.hoverEnabled li:hover, ul.wpcustomEnlighterJS.hoverEnabled li:hover', {
			'background-color': s.customLineHoverColor
		});
		this.addCSSRule('ol.wpcustomEnlighterJS li.specialline', {
			'background-color': s.customLineHighlightColor
		});
		
		// ========= RAW STYLES ======================
		this.addCSSRule('.wpcustomEnlighterJSWrapper pre', {
			'font-family':		s.customRawFontFamily,
			'font-size':		s.customRawFontSize,
			'line-height':		s.customRawLineHeight,
			'color':			s.customRawFontColor,
			'background-color':	s.customRawBackgroundColor
		});
		
		// ========= TOKEN STYLES =====================
		Array.each(this.tokenKeys, function(key){
			// basic color rules
			var r = {
				'color':				s['custom-color-' + key],
				'background-color':		s['custom-bgcolor-' + key],
			};
			
			// style rules
			switch (s['custom-fontstyle-' + key]){
				case 'bold':
					r['font-weight'] = 'bold';
					r['font-style'] =  'normal';
					break;
				case 'italic':
					r['font-style'] =  'italic';
					r['font-weight'] =  'normal';
					break;
				case 'bolditalic':
					r['font-weight'] = 'bold';
					r['font-style'] =  'italic';
					break;
				case 'normal':
					r['font-weight'] = 'normal';
					r['font-style'] =  'normal';
					break;	
			}
			
			// text decoration rules
			switch (s['custom-decoration-' + key]){
				case 'overline':
					r['text-decoration'] = 'overline';
					break;
				case 'underline':
					r['text-decoration'] = 'underline';
					break;
				case 'through':
					r['text-decoration'] = 'line-through';
					break;
				case 'normal':
					r['text-decoration'] = 'none';
					break;
			}
			
			// custom rule for each token
			this.addCSSRule('.wpcustomEnlighterJS .' + key, r);
		}, this);
		
		console.log(s);
	},
	
	// add a new css rule to the document
	addCSSRule: function(selector, r){
		// buffer
		var rules = '';
		
		// join rules
		Object.each(r, function(value, key){
			if (value.length > 0){
				rules += key + ':' + value + ';'
			}
		});
		
		// cross browser comapibility
		if ('insertRule' in this.style.sheet) {
			this.style.sheet.insertRule(selector + '{' + rules + '}', 0);
		}else if('addRule' in this.style.sheet) {
			this.style.sheet.addRule(selector, rules, 0);
		}
	},
	
	// drop the rules - just remove the style element and re-create it
	dropCSSRules: function(){
		// styles available ?
		if (this.style){
			this.style.dispose();
		}
		
		// create new style container
		this.style = new Element('style');
		document.getElement('head').grab(this.style);	
	}
});

//create instance
window.addEvent('load', function(){
	window.ThemePreview = new _tp();
});