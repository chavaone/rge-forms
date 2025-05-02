<?php

?>
<form id="rgeformcontacto" method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] );?>">
  <div class="form-group">
    <label for="nome">Nome e apelidos</label>
    <input type="text" class="form-control" id="nome" required name="rge-nome">
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" required name="rge-email">
  </div>
  <div class="form-group">
    <label for="telefono">Teléfono</label>
    <input type="tel" class="form-control" id="telefono" name="rge-telefono">
  </div>
  <div class="form-group">
    <label for="asunto">Asunto</label>
    <input type="text" class="form-control" id="asunto" required name="rge-asunto">
  </div>
  <div class="form-group">
    <label for="mensaxe">Mensaxe</label>
    <textarea class="form-control" id="mensaxe" rows="3" name="rge-mensaxe"></textarea>
  </div>
  <div class="form-group">
    <label for="asunto">Se es humano responde: Canto é dous máis tres? (pregunta anti-robots)</label>
    <input type="text" class="form-control" id="captcha" required name="rge-captcha">
  </div>
  <button type="submit" class="btn btn-primary" name="rge-enviar">Enviar</button>
</form>
