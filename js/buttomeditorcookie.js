(function() {
	tinymce.PluginManager.add('my_mce_button', function( editor, url ) {
		var elem = url.split("/");
		var str = "";

  			for (var i = 0; i < elem.length-1; i++)

    			str += elem[i] + "/";
				
		editor.addButton('my_mce_button', {
			title : 'Cookie Policy',
			image : str+'images/cookies.png',
			//text: 'cookie',
			onclick: function() {
				var tipo = prompt("Tipologia servizio", "");
				var showbox = prompt("Mostra messaggio blocco contenuto", "no");
				var privacy = prompt("Insere url pagina privacy", "");
				
				selected = tinyMCE.activeEditor.selection.getContent();
				if( selected ){
							//If text is selected when button is clicked
							//Wrap shortcode around it.
							content =  '[cookie tipo="'+tipo+'" showbox="'+showbox+'" privacy="'+privacy+'"]'+selected+'[/cookie]';
						}else{
							content =  '[cookie tipo="'+tipo+'" showbox="'+showbox+'" privacy="'+privacy+'"]';
						}

						tinymce.execCommand('mceInsertContent', false, content);
			}
		});
	});
})();
