/**
 * $RCSfile: editor_plugin_src.js,v $
 * $Revision: 1.23 $
 * $Date: 2006/03/15 11:11:38 $
 *
 * @author Alessandro do Valle Nunes <alessandronunes@gmail.com>
 * @copyright Copyleft © 2006, Alessandro do Valle Nunes, Some rights reserved.
 */

/* Import plugin specific language pack */
tinyMCE.importPluginLanguagePack('imgmanager', 'en,pt_br');

// Plugin static class
var TinyMCE_ImgManagerPlugin = {
	getInfo : function() {
		return {
			longname : 'Image Manager',
			author : 'Alessandro do Valle Nunes',
			authorurl : 'http://alessandro.rpgrock.net',
			infourl : 'http://alessandro.rpgrock.net',
			version : tinyMCE.majorVersion + "." + tinyMCE.minorVersion
		};
	},

	/**
	 * Returns the HTML contents of the imgmanager control.
	 */
	getControlHTML : function(cn) {
		switch (cn) {
			case "imgmanager":
				return tinyMCE.getButtonHTML(cn, 'lang_imgmanager_desc', '{$pluginurl}/../../themes/advanced/images/image.gif', 'mceImgManager');
		}

		return "";
	},

	/**
	 * Executes the mceImgManager command.
	 */
	execCommand : function(editor_id, element, command, user_interface, value) {
		// Handle commands
		switch (command) {
			case "mceImgManager":
            var template = new Array();
           /*EVA*/
            template['file']   = '../../plugins/imgmanager/ImageManager/manager.php'; // Relative to theme
            template['width']  = 660;
            template['height'] = 500;

			// Language specific width and height addons
			template['width'] += tinyMCE.getLang('lang_emotions_delta_width', 0);
			template['height'] += tinyMCE.getLang('lang_emotions_delta_height', 0);

			tinyMCE.openWindow(template, {editor_id : editor_id, inline : "yes"});
			return true;
		}

		// Pass to next handler in chain
		return false;
	}
};

// Register plugin
tinyMCE.addPlugin('imgmanager', TinyMCE_ImgManagerPlugin);