rge_app = {};

rge_app.display_subscription_data = function (id) {
  var data = jQuery("#data-" + id).html();
  var data_obj = JSON.parse(data);
  var html = `<dl>
    <dt>Socio de NEG?</dt>
    <dd>${data_obj.neg}</dd>

    <dt>NIF</dt>
    <dd>${data_obj.nif}</dd>


    <dt>Enderezo</dt>
    <dd>${data_obj.enderezo}</dd>

    <dt>Teléfonos</dt>
    <dd>${data_obj.tlf}</dd>

    <dt>Pago</dt>
    <dd>${data_obj.pago}</dd>

  </dl>`;
  jQuery("#data_display").html(html);
};

rge_app.display_contact_message = function (id) {
  var info = jQuery("#full-message-" + id).html();
  jQuery("#message_display").html(info);
};
