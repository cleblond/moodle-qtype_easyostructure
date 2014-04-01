
function getSmiles(textfieldid) {
	document.getElementById(textfieldid).value = document.getElementById('EASYOSTRUCTURE' + textfieldid).smiles();
}


/*
function getSmilesEdit(buttonname){
    var buttonnumber= buttonname.slice(7,-1);
	textfieldid = 'id_answer_' + buttonnumber;
	document.getElementById(textfieldid).value = document.getElementById('JME').smiles();
}
*/


///modified by crl for easyostructure sketch
function getSmilesEdit(buttonname, format){
    var buttonnumber = buttonname.slice(7,-1);
    var s = document.MSketch.getMol(format);
	s = local2unix(s); // Convert "\n" to local line separator
	s = "\n" + s;
	textfieldid = 'id_structure';
	document.getElementById(textfieldid).value = s;
}







function clean3D() {
    if(document.MSketch != null) {
        document.MSketch.clean3D();
    }
}

function clean2D() {
    if(document.MSketch != null) {
        document.MSketch.clean2D();
    }
}





M.qtype_easyostructure={
    insert_structure_into_applet : function(){
		var textfieldid = 'id_structure';
		if(document.getElementById(textfieldid).value != '') {
		
		var s = document.getElementById(textfieldid).value;
		document.MSketch.setMol(s, 'mrv');
		}

	}
}
