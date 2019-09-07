/**
 * plugin.js (edited for WP)
 *
 * Copyright, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/*global tinymce:true */

tinymce.PluginManager.add('emoticons', function(editor, url) {
	var emoticons = [{
		smile: ':-)',
		razz: ':-P',
		cool: '8-)',
		wink: ';-)',
		biggrin: ':-D'
	},
	{
		twisted: ':twisted:',
		mrgreen: ':mrgreen:',
		lol: ':lol:',
		rolleyes: ':roll:',
		confused: ':-?'
	},
	{
		cry: ':cry:',
		surprised: ':-o',
		evil: ':evil:',
		neutral: ':-|',
		redface: ':oops:'
	},
	{
		mad: ':-x',
		eek: '8-O',
		sad: ':-(',
		arrow: ':arrow:',
		idea: ':idea:'
	}];

	function getHtml() {
		var emoticonsHtml;

		emoticonsHtml = '<table role="list" class="mce-grid">';

		tinymce.each(emoticons, function( row ) {
			emoticonsHtml += '<tr>';

			tinymce.each( row, function( icon, name ) {
				var emoticonUrl = url + '/img/icon_' + name + '.gif';

				emoticonsHtml += '<td><a href="#" data-mce-alt="' + icon + '" tabindex="-1" ' +
					'role="option" aria-label="' + icon + '"><img src="' +
					emoticonUrl + '" style="width: 15px; height: 15px; padding: 3px;" role="presentation" alt="' + icon + '" /></a></td>';
			});

			emoticonsHtml += '</tr>';
		});

		emoticonsHtml += '</table>';

		return emoticonsHtml;
	}

	editor.addButton('emoticons', {
		type: 'panelbutton',
		panel: {
			role: 'application',
			autohide: true,
			html: getHtml,
			onclick: function(e) {
				var linkElm = editor.dom.getParent( e.target, 'a' );

				if ( linkElm ) {
					editor.insertContent(
						' ' + linkElm.getAttribute('data-mce-alt') + ' '
					);

					this.hide();
				}
			}
		},
		tooltip: 'Emoticons'
	});
});
