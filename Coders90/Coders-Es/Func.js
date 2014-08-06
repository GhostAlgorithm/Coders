/*                Copyright (c) 2014 
José Fernando Flores Santamaría <fer.santamaria@programmer.net>
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

var XMLHttpRequestObject = false; 

if (window.XMLHttpRequest) {
	XMLHttpRequestObject = new XMLHttpRequest();
} else if (window.ActiveXObject) {
	XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
}

function getData(dataSource, divID, compstring){ 

	if(compstring!=""){
		if(XMLHttpRequestObject) {
		var obj = document.getElementById(divID); 
		XMLHttpRequestObject.open("GET", "../"+dataSource + "?vineta="+compstring); 
		XMLHttpRequestObject.onreadystatechange = function() 
		{ 

			if (XMLHttpRequestObject.readyState == 4 && 
				XMLHttpRequestObject.status == 200) { 
				obj.innerHTML = XMLHttpRequestObject.responseText; 
			} 
		} 
		XMLHttpRequestObject.send(null); 
		}

	} else {
		obj.innerHTML="";
	}
}

function valorchk(){
	var chk=document.getElementById('newAdmin').checked;
	alert(chk);
}

function tag(){
	var searchtext=document.getElementById('searchbar').value;
	return searchtext;
}

function tagAdmin(){
	var searchtext=document.getElementById('searchbar-admin').value;
	return searchtext;
}

function hide_show_div(hidediv,showdiv){
	document.getElementById(hidediv).style.display = "none";
	document.getElementById(showdiv).style.display = "table";

	if(hidediv=="selector"){
		//doclan=doclan.toUpperCase();
		document.getElementById('title').innerHTML = "Editor de Código - "+doclan.toUpperCase();
	} else {
		document.getElementById('title').innerHTML = "Editor de Código - Nuevo Archivo";
	}
}

function borrar(divID){
	if(document.getElementById('searchbar').value.length==1){
		document.getElementById(divID).innerHTML="";
	}
}

function fileName(){
	document.getElementById('selector').value=document.getElementById('fileUpload').files[0].name;
}

function email(){
	var e1 = document.getElementById("Email").value;
	var e2 = document.getElementById("ReEmail").value;

	if (e2 != e1) {
	  alert("Emails no son iguales");
	  document.getElementById("ReEmail").focus();
	}
}

function act(){
	var dat = new Date();
	var dd = dat.getDate();
	var mm = dat.getMonth()+1; 
	var mm2 = mm.toString();
	var dd2 = dd.toString();
	var yy = dat.getFullYear();

	if (mm2.length<2){
		mm2=0+mm2;
	}
	
	if (dd2.length<2){
		dd2=0+dd2;
	}
		
	var actdate=yy+mm2+dd2;

	var pdate = document.getElementById("Birthday").value;
	var py = pdate.slice(0,4);
	var pm = pdate.slice(5,7);
	var pd = pdate.slice(8,10);
	
	pdate=py+pm+pd;

	if(Number(pdate)>Number(actdate)){
		$('#notification').html("Fecha Inválida");	
		document.getElementById("Birthday").focus();
	} 
	

}

function valNums() {
 if ((event.keyCode < 48) || (event.keyCode > 57)) 
  event.returnValue = false;
}

function valText() {
 if ((event.keyCode == 32) || (event.keyCode != 32) && (event.keyCode < 65) || (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122) && (event.keyCode < 192))
  event.returnValue = false;
}

function valPass(){
	var p1 = document.getElementById("Pass1").value;
	var p2 = document.getElementById("Pass2").value;

	if (p2 != p1) {
	  alert("Las contraseñas no coinciden");
	  document.getElementById("Pass2").focus();
	}
}

$("#targetDiv").on('click','h6',function(){
	var text = $( "#searchbar" ).val();
	var text2=$.trim(text);

	if (text2!="" && text.length>2) {
		window.location.href = "../search/?tag="+text2+"";
	}
});

$(".notifier").click(function(){
	var idf=$(this).attr("idf");
	 $.post("../notifActions.php", 
          {idf: idf, action: "View"},
     function() {
        
     }
    );
});