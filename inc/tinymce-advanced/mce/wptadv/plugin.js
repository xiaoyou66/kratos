/**
 * This file is part of the TinyMCE Advanced WordPress plugin and is released under the same license.
 * For more information please see tinymce-advanced.php.
 *
 * Copyright (c) 2007-2019 Andrew Ozz. All rights reserved.
 */

( function( tinymce ) {
	tinymce.PluginManager.add( 'wptadv', function( editor ) {
		var noAutop = ( ! editor.settings.wpautop && editor.settings.tadv_noautop );

		function addLineBreaks( html ) {
			var blocklist = 'table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre' +
				'|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section' +
				'|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary';

			html = html.replace( new RegExp( '<(?:' + blocklist + ')(?: [^>]*)?>', 'gi' ), '\n$&' );
			html = html.replace( new RegExp( '</(?:' + blocklist + ')>', 'gi' ), '$&\n' );
			html = html.replace( /(<br(?: [^>]*)?>)[\r\n\t]*/gi, '$1\n' );
			html = html.replace( />\n[\r\n\t]+</g, '>\n<' );
			html = html.replace( /^<li/gm, '\t<li' );
			html = html.replace( /<td>\u00a0<\/td>/g, '<td>&nbsp;</td>' );

			return tinymce.trim( html );
		}

		editor.addCommand( 'Tadv_Mark', function() {
			editor.formatter.toggle('mark');
		});

		editor.addButton( 'tadv_mark', {
			icon: 'backcolor',
			tooltip: 'Mark',
			cmd: 'Tadv_Mark',
			stateSelector: 'mark'
		});

		editor.on( 'init', function() {
			if ( noAutop ) {
				editor.on( 'SaveContent', function( event ) {
					event.content = event.content.replace( /caption\](\s|<br[^>]*>|<p>&nbsp;<\/p>)*\[caption/g, 'caption] [caption' );

					event.content = event.content.replace( /<(object|audio|video)[\s\S]+?<\/\1>/g, function( match ) {
						return match.replace( /[\r\n\t ]+/g, ' ' );
					});

					event.content = event.content.replace( /<pre( [^>]*)?>[\s\S]+?<\/pre>/g, function( match ) {
						match = match.replace( /<br ?\/?>(\r\n|\n)?/g, '\n' );
						return match.replace( /<\/?p( [^>]*)?>(\r\n|\n)?/g, '\n' );
					});

					event.content = addLineBreaks( event.content );
				});
			}

			try {
				if ( editor.plugins.searchreplace && ! editor.controlManager.buttons.searchreplace ) {
					editor.shortcuts.remove( 'meta+f' );
				}
			} catch ( er ) {}

			editor.formatter.register({
				mark: { inline: 'mark' }
			});
		});

		editor.on( 'ObjectResizeStart', function( event ) {
			var element = event.target;
			var table = editor.$( element );
			var parentWidth;
			var tableWidth;
			var width;

			if ( table.is( 'table' ) ) {
				if ( element.style.width && element.style.width.indexOf( '%' ) !== -1 ) {
					return;
				}

				parentWidth = parseInt( table.parent().css( 'width' ), 10 );
				tableWidth = parseInt( event.width, 10 );

				if ( parentWidth && tableWidth ) {
					if ( Math.abs( parentWidth - tableWidth ) < 3 ) {
						table.css({ width: '100%' });
					} else {
						width = Math.round( ( tableWidth / parentWidth ) * 100 );

						if ( width > 10 && width < 200 ) {
							table.css({ width: width + '%' });
						}
					}
				}
			}
		}, true );

		editor.addMenuItem( 'tmaresettablesize', {
			text: 'Reset table size',
			cmd: 'tmaResetTableSize',
			icon: 'dashicon dashicons-image-flip-horizontal',
			context: 'format',
		});

		editor.addMenuItem( 'tmaremovetablestyles', {
			text: 'Remove table styling',
			cmd: 'tmaRemoveTableStyles',
			icon: 'dashicon dashicons-editor-table',
			context: 'format',
		});

		editor.addButton( 'tmaresettablesize', {
			title: 'Reset table size',
			cmd: 'tmaResetTableSize',
			icon: 'dashicon dashicons-image-flip-horizontal',
		} );

		editor.addButton( 'tmaremovetablestyles', {
			title: 'Remove table styling',
			cmd: 'tmaRemoveTableStyles',
			icon: 'dashicon dashicons-editor-table',
		} );

		editor.addCommand( 'tmaRemoveTableStyles', function() {
			var node = editor.selection.getStart();
			var table = editor.dom.getParents( node, 'table' );

			if ( table ) {
				editor.$( table ).attr({
					style: null,
					width: null,
					height: null,
					border: null,
					cellspacing: null,
					cellpadding: null
				}).find( 'tr, td' ).each( function( i, element ) {
					editor.$( element ).attr({
						style: null,
						width: null,
						height: null
					});
				} );
			}
		} );

		editor.addCommand( 'tmaResetTableSize', function() {
			var node = editor.selection.getStart();
			var table = editor.dom.getParents( node, 'table' );

			if ( table ) {
				removeInlineSizes( table );

				editor.$( table ).find( 'tr, td' ).each( function( i, element ) {
					removeInlineSizes( element );
				} );
			}
		} );

		function removeInlineSizes( node ) {
			var element = editor.$( node );

			element.css({ width: null, height: null });

			if ( ! element.attr( 'style' ) ) {
				element.attr({ style: null });
			}
		}

		if ( noAutop ) {
			editor.on( 'beforeSetContent', function( event ) {
				var autop;
				var wp = window.wp;

				if ( ! wp ) {
					return;
				}

				autop = wp.editor && wp.editor.autop;

				if ( ! autop ) {
					autop = wp.oldEditor && wp.oldEditor.autop;
				}

				if ( event.load && autop && event.content && event.content.indexOf( '\n' ) > -1 && ! /<p>/i.test( event.content ) ) {
					event.content = autop( event.content );
				}
			}, true );

			if ( editor.settings.classic_block_editor ) {
				editor.on( 'beforeGetContent', function( event ) {
					if ( event.format === 'raw' ) {
						return;
					}

					var blocks = tinymce.$( '.block-editor-block-list__block' );

					if ( blocks.length === 1 && blocks.attr( 'data-type' ) === 'core/freeform' ) {
						// Mark all paragraph tags inside a single freeform block so they are not stripped by the block editor...
						editor.$( 'p' ).each( function ( i, node ) {
							if ( ! node.hasAttributes() ) {
								editor.$( node ).attr( 'data-tadv-p', 'keep' );
							}
						} );
					} else {
						// Remove the above ugliness...
						editor.$( 'p[data-tadv-p]' ).removeAttr( 'data-tadv-p' );
					}
				}, true );
			}
		}

		return {
			addLineBreaks: addLineBreaks
		};
	});
}( window.tinymce ));
