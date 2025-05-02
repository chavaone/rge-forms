<?php

?>
<!DOCTYPE html>
    <html lang="gl" dir="ltr">
      <head>
        <meta charset="utf-8">
        <title></title>
      </head>
      <body>
        <article>
          <header>
            <h2>Formulario de Subscrición</h3>
          </header>
          <main>
            <h3>Datos</h3>
            <dl>
              <dt>Día e hora</dt>
              <dd><?php echo $tempo ; ?></dd>
              <dt>Nome</dt>
              <dd><?php echo $nome; ?></dd>
              <dt>NIF</dt>
              <dd><?php echo $nif; ?></dd>
              <dt>Email</dt>
              <dd><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></dd>
              <dt>Asociado/a a NEG</dt>
              <dd><?php echo $is_neg ? "Si" : "Non"; ?></dd>
            </dl>

            <hr/>

            <h3>Enderezo</h3>
            <?php if ($is_neg): ?>
              <p>Mesmos datos que os de NEG.</p>
            <?php else: ?>
            <dl>
              <dt>Enderezo</dt>
              <dd><?php echo $enderezo; ?></dd>
              <dt>CP</dt>
              <dd><?php echo $cp; ?></dd>
              <dt>Localidade</dt>
              <dd><?php echo $localidade; ?></dd>
              <dt>Concello</dt>
              <dd><?php echo $concello; ?></dd>
              <dt>Provincia</dt>
              <dd><?php echo $provincia; ?></dd>
              <dt>Teléfono 1</dt>
              <dd><?php echo $telefono1; ?></dd>
              <dt>Teléfono 2</dt>
              <dd><?php echo $telefono2; ?></dd>
            </dl>
            <?php endif; ?>

            <hr/>

            <h3>Datos de Pago</h3>
            <dl>
              <dt>Forma de pago:</dt>
              <dd><?php echo $pagoneg ? "Mesma que en NEG" : $formapago ?></dd>
              <?php if ($formapago == "domiciliacion"):?>
              <dt>Banco</dt>
              <dd><?php echo $banco; ?></dd>
              <dt>IBAN</dt>
              <dd><?php echo $iban; ?></dd>
              <dt>Titular</dt>
              <dd><?php echo $titular; ?></dd>
            <?php endif; ?>
            </dl>
          </main>
        </article>
      </body>
    </html>

