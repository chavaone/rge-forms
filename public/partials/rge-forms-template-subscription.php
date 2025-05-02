<?php

?>
<form id="rgeformsubs" method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] );?>">
  <section>
    <h4>Datos subscritor/a</h4>
    <div class="form-row">
      <div class="form-group col-md-9">
        <label for="nome">Nome e apelidos</label>
        <input type="text" class="form-control" id="nome" required name="rge-nome">
      </div>
      <div class="form-group col-md-3">
        <label for="nif">NIF</label>
        <input type="text" class="form-control" id="nif" required name="rge-nif">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" required name="rge-email">
      </div>
      <div class="form-group col-md-6 switch-neg">
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" id="neg" checked="false" name="rge-isneg">
          <label class="custom-control-label" for="neg">Está vostede asociado/a a Nova Escola Galega?</label>
        </div>
      </div>
    </div>

  </section>

  <section id="enderezosubscritor">
    <h4>Enderezo</h4>
    <p class="infodatos">Usaranse os datos datos que temos na súa ficha de asociado/a a Nova Escola Galega. Siga na forma de pagamento.</p>
    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="enderezo">Enderezo</label>
        <input type="text" class="form-control" id="enderezo" required name="rge-enderezo">
      </div>

    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="cp">CP</label>
        <input type="number" class="form-control" id="cp" required name="rge-cp">
      </div>
      <div class="form-group col-md-4">
        <label for="localidade">Localidade</label>
        <input type="text" class="form-control" id="localidade" required name="rge-localidade">
      </div>
      <div class="form-group col-md-4">
        <label for="concello">Concello</label>
        <input type="text" class="form-control" id="concello" required name="rge-concello">
      </div>

    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="provincia">Provincia</label>
        <input type="text" class="form-control" id="provincia" required name="rge-provincia">
      </div>
      <div class="form-group col-md-4">
        <label for="phone1">Tlf. Fixo</label>
        <input type="tel" class="form-control" id="phone1" required name="rge-telefono1">
      </div>
      <div class="form-group col-md-4">
        <label for="phone2">Tlf. Móbil</label>
        <input type="tel" class="form-control" id="phone1" required name="rge-telefono2">
      </div>
    </div>
  </section>

  <section>
    <h4>Forma de Pagamento</h4>
    <div class="form-group">
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="pagamentoneg" disabled name="rge-pagamentoneg">
        <label class="custom-control-label" for="pagamentoneg">Desexa manter a forma de pagamento coa que está asociado/a a Nova Escola galega?</label>
      </div>
    </div>
    <div class="form-group" >
        <label for="formapagamento">Seleccione unha forma de pagamento</label>
        <select id="formapagamento" class="form-control" required name="rge-formapagamento">
          <option value="" disabled selected>Prema para seleccionar unha forma de pagamento</option>
          <option value="domiciliacion">Domiciliación bancaria</option>
          <option value="cheque">Cheque a favor de Nova Escola Galega</option>
          <option value="transferencia">Transferencia bancaria á conta de NEG</option>
          <option value="reembolso">Reembolso (inclúe gastos)</option>
        </select>
    </div>
  </section>

  <section id="datospadeliver_mailgamento">
    <div class="pagamentoinfo" id="infoneg">
      <h4>Datos Pagamento</h4>
      <p>Usarase a forma de pagamento empregada como asociado/a a Nova Escola Galega.</p>
    </div>

    <div class="pagamentoinfo" id="infodomiciliacion">
      <h4>Datos Pagamento</h4>
      <h5>Datos para a domiciliación bancaria</h5>
      <div class="form-group">
        <label for="banco">Entidade Bancaria</label>
        <input type="text" class="form-control" id="banco" name="rge-banco">
      </div>
      <div class="form-group">
        <label for="iban">IBAN</label>
        <input type="text" class="form-control" id="iban" name="rge-iban">
      </div>
      <div class="form-group">
        <label for="titular">Titular da conta (no caso de ser diferente)</label>
        <input type="text" class="form-control" id="titular" name="rge-titular">
      </div>
    </div>

    <div class="pagamentoinfo" id="infocheque">
      <h4>Datos Pagamento</h4>
      <p>Info cheque</p>
    </div>

    <div class="pagamentoinfo" id="infotransferencia">
      <h4>Datos Pagamento</h4>
      <p>Para facer a subscrición a través dunha transferencia bancaria, faga unha trasferencia cos seguintes datos e envíe o xustificante de pago ó enderezo <a href="mailto:...">...</a></p>
      <dl style="width: 80%; margin:auto;">
        <dt>Entidade Bancaria</dt>
        <dd>Abanca</dd>

        <dt>IBAN</dt>
        <dd>...</dd>

        <dt>Concepto</dt>
        <dd>Subscrición RGE - <em>Insira aquí o seu nome</em></dd>
      </dl>
    </div>

    <div class="pagamentoinfo" id="inforeembolso">
      <h4>Datos Pagamento</h4>
      <p>TODO: Info sobre como facer o envio reembolso</p>
    </div>
  </section>

  <section>
    <div class="form-group">
      <label for="asunto">Se es humano responde: Canto é dous máis tres? (pregunta anti-robots)</label>
      <input type="text" class="form-control" id="captcha" required name="rge-captcha">
    </div>
  </section>

  <section>
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" name="rge-condicions" id="condicions" required>
      <label class="custom-control-label" for="condicions">Leo e acepto os <a href="">Termos da subscrición</a> e o <a href="">Aviso legal</a></label>
    </div>
  </section>

  <section>
    <button type="submit" name="rge-enviar" class="btn btn-primary">Enviar</button>
  </section>
</form>
