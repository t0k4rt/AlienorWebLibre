// JavaScript Document

function rechThesoAlpha(champNom,champVal){
	if (champVal.value.length > 3) {
		document.domaine = "alienor.org";
	//alert(champVal.value);
	
	//urlOk = '../thesaurus/awl.htm';
	//urlOk = '../thesaurus/pageProxy.php?url=http:/alienorweb/www.alienor.org/public/thesoalpha.asp?__GroupId=286&curtheso=DSCP&curindex=&__formGroupid=37&__TableId=32&SRC='+champNom+'&IdItem=DISCIPLINE&lastterm='+champVal.value;
	urlOk = '../thesaurus/pageProxy.php?url=http://www.alienor.org/testpublicv2/public/fs_theso.asp?__GroupId=286&curtheso=DSCP&curindex=&__formGroupid=37&__TableId=32&SRC='+champNom+'&IdItem=DISCIPLINE&lastterm='+champVal.value;
	//urlOk = '../thesaurus/pageProxy.php?url=http://www.alienor.org/testpublicv2/public/thesoAWL.asp?__GroupId=286&curtheso=DSCP&curindex=&__formGroupid=37&__TableId=32&SRC='+champNom+'&IdItem=DISCIPLINE&lastterm='+champVal.value+'&ajax=oui';
	//dialOk= 'assist_'+champNom;
	//alert(dialOk);
	//document.getElementById('assist_DISCIPLINE').innerHTML = '<a href="http://www.alienor.org">essai</a>';
	//window.open(urlOk);
	OpenAjaxPostCmd(urlOk,'assist_DISCIPLINE','','attente','assist_DISCIPLINE','2','2');
	}
}

function affecteValeur(val,champVal){
	document.getElementById(champVal).value = val;	
	document.getElementById('assist_DISCIPLINE').innerHTML= "";
	}

function openAjax() {

	var ajax;
	try{
		ajax = new XMLHttpRequest();
	}catch(ee){
		try{
			ajax = new ActiveXObject("Msxml2.XMLHTTP");
		}catch(e){
			try{
				ajax = new ActiveXObject("Microsoft.XMLHTTP");
			}catch(E){
				ajax = false;
			}
		}
	}
	return ajax;
}

function CpForm(FormName){
	comp = "document." + FormName;
	var frm = eval(comp);
	Cps = "";
	for (i=0; i<frm.length; i++){
		Cps = Cps + frm.elements[i].name + "=" + frm.elements[i].value + "&";
	}
	Cps = Cps.substring(0,Cps.length -1);
	return Cps;
}

function OpenAjaxPostCmd(pagina,camada,values,msg,divcarga,metodo,tpmsg) { 
	if(document.getElementById) {
		var ajax = openAjax();
		if(tpmsg=='1'){
			var exibeLoading = document.getElementById(divcarga);
		}
		var exibeResultado = document.getElementById(camada);
		if(metodo=='1'){
			ajax.open("POST", pagina, true);
			ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
			ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
			ajax.setRequestHeader("Pragma", "no-cache");
			valor = CpForm(values)
		}else{
					
			valor = null
			ajax.open("GET", pagina + values, true);
		}
		ajax.onreadystatechange = function() {
			if(ajax.readyState == 1) {
				if(tpmsg=='1'){
					exibeLoading.style.display = 'inline';
					exibeLoading.innerHTML = msg
				}else{
					exibeResultado.innerHTML = msg
				}
			}
			if(ajax.readyState == 4) {
				if(tpmsg=='1'){
					exibeLoading.innerHTML = ""
					exibeLoading.style.display = 'none';
				}else{
					exibeResultado.innerHTML = ""
				}
				if(ajax.status == 200) {
					var resultado = null;
					resultado = ajax.responseText;
					resultado = resultado.replace(/\+/g," ");
					resultado = unescape(resultado);
					exibeResultado.innerHTML = resultado;
				} else {
					exibeResultado.innerHTML = "<br / ><br / ><center>An error occurred:</center><br / ><br / > <center>" + resultado + "&nbsp;" + ajax.status + "</center>";
				}
			}
		}
		ajax.send(valor);
	}		 
}
