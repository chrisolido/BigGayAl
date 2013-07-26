
switchEditors = {

	mode : '',

	I : function(e) {
		return document.getElementById(e);
	},

	edInit : function() {
		var h = tinymce.util.Cookie.getHash("TinyMCE_content_size"), H = this.I('edButtonHTML'), P = this.I('edButtonPreview');

		// Activate TinyMCE if it's the user's default editor
		if ( getUserSetting( 'editor' ) == 'html' ) {
			if ( h )
				try { this.I('content').style.height = h.ch - 30 + 'px'; } catch(e){};
		} else {
			try {
				this.I("quicktags").style.display = "none";
			} catch(e){};
			tinyMCE.execCommand("mceAddControl", false, "content");
		}
	},
	
	saveCallback : function(el, content, body) {

		if ( tinyMCE.activeEditor.isHidden() )
			content = this.I(el).value;
		else
			content = this.pre_wpautop(content);

		return content;
	},

	pre_wpautop : function(content) {
		// filtered when switching visual to html

		// We have a TON of cleanup to do. Line breaks are already stripped.

		// Protect pre|script tags
		content = content.replace(/<(pre|script)[^>]*>[\s\S]+?<\/\1>/g, function(a) {
			a = a.replace(/<br ?\/?>[\r\n]*/g, '<wp_temp>');
			return a.replace(/<\/?p( [^>]*)?>[\r\n]*/g, '<wp_temp>');
		});

		// Pretty it up for the source editor
		var blocklist1 = 'blockquote|ul|ol|li|table|thead|tbody|tr|th|td|div|h[1-6]|p';
		content = content.replace(new RegExp('\\s*</('+blocklist1+')>\\s*', 'mg'), '</$1>\n');
		content = content.replace(new RegExp('\\s*<(('+blocklist1+')[^>]*)>', 'mg'), '\n<$1>');
		
		content = content.replace(new RegExp('<p( [^>]*)?>[\\s\\n]*<(/?script[^>]*)>', 'mg'), '\n<$2>');
		content = content.replace(new RegExp('<(/?script[^>]*)>[\\s\\n]*</p>', 'mg'), '\n<$1>');

		// Fix some block element newline issues
		content = content.replace(new RegExp('\\s*<div', 'mg'), '\n<div');
		content = content.replace(new RegExp('</div>\\s*', 'mg'), '</div>\n');
		content = content.replace(new RegExp('\\s*\\[caption([^\\[]+)\\[/caption\\]\\s*', 'gi'), '\n\n[caption$1[/caption]\n\n');
		content = content.replace(new RegExp('caption\\]\\n\\n+\\[caption', 'g'), 'caption]\n\n[caption');

		var blocklist2 = 'blockquote|ul|ol|li|table|thead|tr|th|td|h[1-6]|pre';
		content = content.replace(new RegExp('\\s*<(('+blocklist2+') ?[^>]*)\\s*>', 'mg'), '\n<$1>');
		content = content.replace(new RegExp('\\s*</('+blocklist2+')>\\s*', 'mg'), '</$1>\n');
		content = content.replace(new RegExp('<li([^>]*)>', 'g'), '\t<li$1>');

		if ( content.indexOf('<object') != -1 ) {
			content = content.replace(new RegExp('\\s*<param([^>]*)>\\s*', 'mg'), "<param$1>");
			content = content.replace(new RegExp('\\s*</embed>\\s*', 'mg'), '</embed>');
		}

		// Unmark special paragraph closing tags
		content = content.replace(new RegExp('</p#>', 'g'), '</p>\n');
		content = content.replace(new RegExp('\\s*(<p [^>]+>.*</p>)', 'mg'), '\n$1');
		content = content.replace(new RegExp('<p>\\s*</p>', 'mg'), "<p>&nbsp;</p>\n");

		// put back the line breaks in pre|script
		content = content.replace(/<wp_temp>/g, '\n');
		// Hope.
		return content;
	},

	go : function(id, mode) {
		id = id || 'content';
		mode = mode || this.mode || '';

		var ed = tinyMCE.get(id) || false;
		var qt = this.I('quicktags');
		var H = this.I('edButtonHTML');
		var P = this.I('edButtonPreview');
		var ta = this.I(id);

		if ( 'tinymce' == mode ) {

			if ( ed && ! ed.isHidden() )
				return false;

			this.mode = 'html';
			ta.style.color = '#fff';

			P.className = 'active';
			H.className = '';
			edCloseAllTags(); // :-(

			qt.style.display = 'none';

			ta.value = this.wpautop(ta.value);

			if ( ed ) ed.show();
			else tinyMCE.execCommand("mceAddControl", false, id);

			setUserSetting( 'editor', 'tinymce' );
		} else {
			if ( ! ed || ed.isHidden() )
				return false;

			this.mode = 'tinymce';
			H.className = 'active';
			P.className = '';

			ta.style.height = ed.getContentAreaContainer().offsetHeight + 6 + 'px';

			ed.hide();
			qt.style.display = 'block';

			ta.style.color = '';
			setUserSetting( 'editor', 'html' );
		}
		return false;
	},

	wpautop : function(pee) {
		// filtered when switching html to visual
		var blocklist = 'table|thead|tfoot|caption|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|blockquote|address|math|p|h[1-6]|script';
		var blocklist2 = 'table|thead|tfoot|caption|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|blockquote|address|math|h[1-6]|script';
		pee = pee + "\n\n";
		pee = pee.replace(new RegExp('(<(?:'+blocklist+')[^>]*>)', 'gi'), "\n$1");
		pee = pee.replace(new RegExp('(</(?:'+blocklist+')>)', 'gi'), "$1\n\n");
		pee = pee.replace(new RegExp("\\r\\n|\\r", 'g'), "\n");
		pee = pee.replace(new RegExp("\\n\\s*\\n+", 'g'), "\n\n");
		pee = pee.replace(new RegExp('([\\s\\S]+?)\\n\\n', 'mg'), "<p>$1</p>\n");
		pee = pee.replace(new RegExp('<p( [^>]*)?>[\\s\\n]*</p>', 'mg'), "<p$1>&nbsp;</p>\n");
		pee = pee.replace(new RegExp('<p>\\s*(</?(?:'+blocklist+')[^>]*>)\\s*</p>', 'gi'), "$1");
		pee = pee.replace(new RegExp("<p>(<li.+?)</p>", 'gi'), "$1");
		pee = pee.replace(new RegExp("<p ?[^>]*>(<!--(.*)?-->)", 'gi'), "$1");
		pee = pee.replace(new RegExp("(<!--(.*)?-->)</p>", 'gi'), "$1");
		pee = pee.replace(new RegExp('<p>\\s*<blockquote([^>]*)>', 'gi'), "<blockquote$1><p>");
		pee = pee.replace(new RegExp('</blockquote>\\s*</p>', 'gi'), '</p></blockquote>');
		pee = pee.replace(new RegExp('<p>[\\s\\n]*(<(?:'+blocklist+')[^>]*>)', 'gi'), "$1");
		pee = pee.replace(new RegExp('<p>[\\s\\n]*(</(?:'+blocklist2+')[^>]*>)', 'gi'), "$1");
		pee = pee.replace(new RegExp('(<(?:'+blocklist2+')[^>]*>)[\\s\\n]*</p>', 'gi'), "$1");
		pee = pee.replace(new RegExp('(</(?:'+blocklist+')[^>]*>)[\\s\\n]*</p>', 'gi'), "$1");
		pee = pee.replace(new RegExp('(</?(?:'+blocklist+')[^>]*>)\\s*<br />', 'gi'), "$1");
		pee = pee.replace(new RegExp('<br />(\\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)>)', 'gi'), '$1');
		pee = pee.replace(new RegExp('(?:<p>|<br ?/?>)*\\s*\\[caption([^\\[]+)\\[/caption\\]\\s*(?:</p>|<br ?/?>)*', 'gi'), '[caption$1[/caption]');

		// Fix the pre|script tags
		pee = pee.replace(/<(pre|script)[^>]*>[\s\S]+?<\/\1>/g, function(a) {
			a = a.replace(/<br ?\/?>[\r\n]*/g, '\n');
			return a.replace(/<\/?p( [^>]*)?>[\r\n]*/g, '\n');
		});

		return pee;
	}
}
