(function( $ ) {
	'use strict';

	 $("#neg")[0].checked = false;
	 $("#pagamentoneg")[0].checked = false;
	 $("#formapagamento")[0].value = "none";

	 $("#neg").change(function() {
	   var isenabled = $("#neg")[0].checked;
	   $("#enderezosubscritor input").each((i, input) => {input.disabled = isenabled;});
	   $("#enderezosubscritor input").each((i, input) => {input.required = ! isenabled;});
	   $("#pagamentoneg")[0].checked = false;
	   $("#pagamentoneg")[0].disabled = ! isenabled;
	   if (isenabled) {
	     $("#enderezosubscritor").addClass("disabled");
	   } else {
	     $("#enderezosubscritor").removeClass("disabled");
	     $("#formapagamento")[0].disabled = false;
	     $(".pagamentoinfo").removeClass("show");
	   }
	 });

	 $("#pagamentoneg").change(function(){
	   var isenabled = $("#pagamentoneg")[0].checked;
	   $("#formapagamento")[0].disabled = isenabled;
	   $("#formapagamento")[0].required = ! isenabled;
	   if (isenabled) {
	     $("#formapagamento")[0].value = "";
	     $(".pagamentoinfo").removeClass("show");
	     $("#datospagamento").addClass("show");
	     $(".pagamentoinfo#infoneg").addClass("show");
	   } else {
	     $("#datospagamento").removeClass("show");
	     $(".pagamentoinfo").removeClass("show");
	   }
	 });

	 $("#formapagamento").change(function() {
	   var formapagamento = $("#formapagamento")[0].value;
	   $(".pagamentoinfo").removeClass("show");
	   $("#datospagamento").addClass("show");
	   $(".pagamentoinfo#info" + formapagamento).addClass("show");
		 $("#banco").required = formadepagamento == "domiciliacion";
		 $("#iban").required = formadepagamento == "domiciliacion";
	 });

})( jQuery );
