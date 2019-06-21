/*
	Funciones Javascript que se usan en varias de las páginas
*/

// Llamada a inicio() cuando se carga la página
window.addEventListener("load", inicio);


// Función inicial
function inicio() {
	// Para mostrar el modal del aviso legal del footer
	var avisoLegal = document.getElementById("avisoLegal");
	var enlace = document.getElementById("abrirAvisoLegal");
	var cerrar = document.getElementById("cerrarAvisoLegal");

	enlace.onclick = function() {
	  avisoLegal.style.display = "block";
	}
	cerrar.onclick = function() {
	  avisoLegal.style.display = "none";
	}
	window.onclick = function(event) {
	 	if (event.target == avisoLegal) {
	    	avisoLegal.style.display = "none";
		}
	}

	// Funcion JQUERY para que en el campo del precio no puedan escribirse más de 9999 o menos de 0
	$("#precio").keyup(function() {
		var num = $("#precio").val();
		if (num > 9999) {
			$("#precio").val(9999);
		}
		else if (num < 0) {
			$("#precio").val(0);
		}
	});
}
