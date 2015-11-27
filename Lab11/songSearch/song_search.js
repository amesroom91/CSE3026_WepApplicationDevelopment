document.observe("dom:loaded", function() {
    $("b_xml").observe("click", function(){
    	//construct a Prototype Ajax.request object
    	new Ajax.Request("songs_xml.php",{
    	    	method:"GET",
    	    	parameters:{top:$F('top')},
    	    	onSuccess:showSongs_XML,
    	    	onFailure:ajaxFailed,
    	    	onException:ajaxFailed
		});
    });
    $("b_json").observe("click", function(){
        //construct a Prototype Ajax.request object
       	new Ajax.Request("songs_json.php",{
    	    	method:"GET",
    	    	parameters:{top:$F('top')},
    	    	onSuccess:showSongs_JSON,
    	    	onFailure:ajaxFailed,
    	    	onException:ajaxFailed
		});
	});
});

function showSongs_XML(ajax) {
	alert(ajax.responseText);
	$('songs').innerHTML = "";
	var value = ajax.responseXML.getElementsByTagName("song");
	for(var i=0;i<value.length;i++)
	{
		var li = document.createElement("li");
		var title = value[i].getElementsByTagName("title")[0].firstChild.nodeValue;
		var artist = value[i].getElementsByTagName("artist")[0].firstChild.nodeValue;
		var genre = value[i].getElementsByTagName("genre")[0].firstChild.nodeValue;
		var time = value[i].getElementsByTagName("time")[0].firstChild.nodeValue;
		li.innerHTML = title + " - " + artist + "[" + genre + "] (" + time + ")";
		$('songs').appendChild(li);
	}
}

function showSongs_JSON(ajax) {
	alert(ajax.responseText);
	$('songs').innerHTML = "";
	var value = JSON.parse(ajax.responseText);
	for(var i=0; i<value.songs.length; i++)
	{
		var li = document.createElement("li");
		var title = value.songs[i].title;
		var artist = value.songs[i].artist;
		var genre = value.songs[i].genre;
		var time = value.songs[i].time;
		li.innerHTML = title + " - " + artist + "[" + genre + "] (" + time + ")";
		$('songs').appendChild(li);
	}
	
}

function ajaxFailed(ajax, exception) {
	var errorMessage = "Error making Ajax request:\n\n";
	if (exception) {
		errorMessage += "Exception: " + exception.message;
	} else {
		errorMessage += "Server status:\n" + ajax.status + " " + ajax.statusText + 
		                "\n\nServer response text:\n" + ajax.responseText;
	}
	alert(errorMessage);
}
