<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Freya, Hotel, Hostal, Gestion, Seguridad, Eficiencia, Calidad, Informacion, Reservas">
    <meta name="author" content="Amadeus Soluciones">

    <title>Freya - Hotel</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url().'public/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet">-->
    <!-- NProgress -->
    <!--<link href="<?php // echo base_url().'public/gentelella/vendors/nprogress/nprogress.css'; ?>" rel="stylesheet">-->
    <!-- Custom Theme Style -->
    <!--<link href="<?php // echo base_url().'public/gentelella/build/css/custom.min.css'; ?>" rel="stylesheet">-->
    
    <link rel="shortcut icon" href="<?php echo base_url().'public/img/favicon.ico'; ?>">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h4>CONTRATO DE HOSPEDAJE HOTEL <?php echo $this->config->item('namebussines'); ?></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        
                        <div class="x_panel">
                            <div class="x_content">
                                <p style="text-align: justify; font-size: 9px">
                                    El presente contrato es de adhesión y contiene los derechos y obligaciones tanto de EL HOTEL como de EL HUÉSPED, teniendo en cuenta lo
dispuesto en los artículos 1192 y siguientes del Código de Comercio y las disposiciones de la Ley 300 de 1996, las normas que las adicionan,
complementan y modifican. Por lo tanto, LAS PARTES se adhieren a sus términos, los cuales se consignan en las siguientes cláusulas. Toda la
información es suministrada de manera conjunta, por lo que se resalta el deber de información a cargo del consumidor consagrado en el numeral 2.1
del artículo 3 de la Ley 1480 de 2011 –Estatuto del Consumidor-.
                                </p>
                                <p style="text-align: justify; font-size: 9px">
                                    <span style="font-weight: bold">PRIMERA. OBJETO.</span> Por virtud del presente contrato <B style="font-weight: bold">HOTEL <?php echo $this->config->item('namebussines'); ?></B>, quien para todos los efectos derivados de este contrato
se denominará EL HOTEL le prestará alojamiento a EL HUÉSPED en la habitación y sus accesorios, a cambio de un precio, por el número de días y
con las especificaciones indicadas en la Tarjeta de Registro Hotelero, conforme a lo dispuesto en el artículo 81 de la Ley 300 de 1996. Así mismo, en la
correspondiente tarjeta de registro hotelero EL HOTEL diligenciará los datos de cada HUÉSPED.
                                </p>
                                <p style="text-align: justify; font-size: 9px">
                                    El hospedaje, bajo ninguna circunstancia será de un término superior a treinta (30) días consecutivos. EL HOTEL podrá efectuar cambios de habitación
si EL HUÉSPED lo acepta y se trata de un alojamiento de iguales o mejores condiciones, o ante una situación de caso fortuito o fuerza mayor. La hora
de ingreso o check-in es a partir de las <?php echo $this->config->item('checkin'); ?> del día de llegada y la hora de salida o check-out es hasta las <?php echo $this->config->item('checkout'); ?> del día de salida. El ingreso
anticipado o la salida con posterioridad a la hora indicada estará sujeta a disponibilidad y el HUESPED deberá pagar el valor correspondiente. El precio
total del alojamiento se cobrará con independencia del tiempo que efectivamente permanezca el HUÉSPED en EL HOTEL. En este sentido, el uso
parcial causa el pago de la tarifa plena. La prestación de los servicios objeto del contrato y de aquellos complementarios que ofrezca EL HOTEL estará
sujeta a disponibilidad y a los horarios, turnos o existencias físicas de los insumos, bienes, facilidades o espacios para
ella.
                                </p>
                                <p style="text-align: justify; font-size: 9px">
                                    <span style="font-weight: bold">SEGUNDA. PRECIO.</span> El precio del presente contrato corresponde al canon por noche que EL HUESPED se obliga a pagar y que asciende a la suma
que se indica en la Tarjeta de Registro Hotelero y corresponde a la reserva efectuada, todo lo cual se describirá en la factura correspondiente.

El HUÉSPED deberá pagar también todos los cargos por concepto de alimentos, bebidas, lavandería y en general por todos aquellos servicios
adicionales al alojamiento que se provean y no estén incluidos dentro de la tarifa ofrecida. EL HUÉSPED declara que ha sido informado de las tarifas
por concepto de alojamiento y que las ha aceptado de manera consiente y voluntaria. De igual manera, ha obtenido información acerca de los precios
de los servicios adicionales al alojamiento. El incumplimiento del pago acordado generará a cargo del HUÉSPED intereses de mora a la tasa máxima
legal permitida por la Superintendencia Financiera de Colombia.
                                </p>
                                <p style="text-align: justify; font-size: 9px">
                                    <span style="font-weight: bold">TERCERA. DURACIÓN.</span> El presente contrato tendrá como fecha de inicio el día de la compra y como finalización, aquella en la que se haya
establecido la salida de EL HUÉSPED con paz y salvo de pago de todos los servicios prestados y de las obligaciones que se hayan generado a su
cargo.
                                </p>
                                <p style="text-align: justify; font-size: 9px">
                                    <span style="font-weight: bold">CUARTA. OBLIGACIONES DEL HOTEL.</span> Son obligaciones de EL HOTEL las que se enuncian a continuación:<br>
[4.1] Prestar el servicio ofrecido y que se constituye en el objeto de este contrato, bajo las condiciones de calidad e idoneidad ofrecidas y las exigibles
legalmente.
[4.2] Atender, recibir, tramitar y responder las sugerencias, quejas o reclamos presentados por EL HUÉSPED. Las peticiones, quejas o reclamos que se
alleguen serán atendidos conforme a las disposiciones propias del derecho de petición y el procedimiento establecido en la Ley 1480 de 2011 -Estatuto
del Consumidor-.
[4.3] No intervenir en el uso legítimo que EL HUÉSPED haga sobre la habitación, salvo que se trate de la limpieza y arreglo diario general, o de
reparaciones urgentes y necesarias para garantizar los derechos de EL HUÉSPED.
[4.4] Expedir a EL HUÉSPED los recibos correspondientes por concepto de prestación de servicios y recibo de dinero.
[4.5] Las demás que por ministerio de la ley resulten aplicables.
                                </p>
                                <p style="text-align: justify; font-size: 9px">
                                    <span style="font-weight: bold">QUINTA. OBLIGACIONES DEL HUÉSPED.</span> Son obligaciones de EL HUÉSPED las que se enuncian a continuación, sin perjuicio de todas aquellas que
por la naturaleza del contrato sean exigibles:<br />
[5.1] Identificarse para registrarse en el HOTEL con documento de identidad idóneo, presentando su cédula de ciudadanía en caso de ser 
colombiano o su pasaporte o documento pertinente en caso de ser extranjero. Para menores de edad, deberá presentarse documento de 
identificación válido y los menores de edad deberán estar acompañados por su representante legal o un mayor de edad facultado para 
ejercer su representación. [5.2] Informarse acerca de las características de los servicios ofrecidos, así como de los términos indicados 
en la cláusula de responsabilidad, las cuales hacen parte integral de este contrato. [5.3] Cancelar en la forma pactada y oportuna el 
valor del hospedaje, de los servicios adicionales más los impuestos correspondientes. [5.4] EL HUÉSPED reconoce y acepta que la factura 
que se expida con ocasión de la prestación de todos los servicios de EL HOTEL constituye mérito ejecutivo y no se requiere comunicación 
previa para la constitución en mora. [5.5] Guardar una conducta adecuada, que no atente bajo ninguna circunstancia contra la vida, dignidad, 
integridad de los demás huéspedes y/o de los vecinos del HOTEL. Este deber de conducta se hace extensible a los bienes que se encuentran 
dentro del HOTEL y zonas aledañas. En caso que EL HUÉSPED ocasione algún daño y perjuicio a bienes del HOTEL y/o de terceros, será exclusivo 
y único responsable sobre el particular por la totalidad del perjuicio causado, tanto de índole material como moral. [5.6] Registrar en la 
recepción del HOTEL a todos los acompañantes o invitados y pagar el canon o valor correspondiente por cada uno de ellos, tambien debera 
registrar los vehiculos ingresados al HOTEL. [5.7] Mantener el número de personas autorizadas para el ingreso a la habitación. En caso que 
EL HUÉSPED ingrese alguien adicional a los acompañantes informados previamente, deberá avisar de manera inmediata a EL HOTEL, con quien 
manejará el precio adicional por los ocupantes adicionales siempre y cuando EL HOTEL consienta en ello. Lo anterior, sin perjuicio del 
derecho de EL HOTEL a dar por terminado el contrato por incumplimiento, en forma inmediata, sin devolución de suma alguna. EL HUÉSPED se 
abstendrá de realizar fiestas o reuniones con participación de terceros no inscritos en el contrato, a no ser se haya llegado a un 
acuerdo previo con EL HOTEL y se haya otorgado autorización expresa y escrita y fijado una tarifa para dicho caso. [5.8] Queda prohibido 
el turismo sexual de menores y la práctica de actividades dentro del HOTEL que se relacionen directa o indirectamente con dicho delito. 
                                </p>
                                <p style="text-align: justify; font-size: 9px">
                                    <span style="font-weight: bold">SEXTA. TERMINACIÓN DEL CONTRATO.</span> El contrato de hospedaje terminará 
                                    en los siguientes eventos: i) Por vencimiento del plazo pactado; ii) Por mutuo acuerdo entre las partes; iii) 
                                    el contrato puede terminar de manera anticipada por el incumplimiento de EL HUÉSPED de cualquiera de sus obligaciones 
                                    tales como el pago debido de los servicios prestados, incumplimiento de las obligaciones aquí estipuladas y 
                                    derivadas de la naturaleza del contrato, entre otras; iii) por conductas de EL HUÉSPED que atenten contra la vida, 
                                    seguridad, integridad propia o de terceros y que generen potencial daño o perjuicios concretados a personas y 
                                    bienes de EL HOTEL y/o de terceros.  
                                </p>
                                <p style="text-align: justify; font-size: 9px">
                                    <span style="font-weight: bold">SÉPTIMA. DESTINACIÓN Y USO DEL INMUEBLE.</span> EL HOTEL alquila la habitación bajo la modalidad de alojamiento turístico 
                                    exclusivamente, y se prohíbe el uso de la propiedad para fines diferentes. Adicionalmente, se prohíbe el uso de la 
                                    habitación para el desarrollo de actividades relacionadas con el narcotráfico, lavado de dinero, negocios ilícitos y 
                                    otras actividades ilegales. 
                                </p>
                                <p style="text-align: justify; font-size: 10px">
                                    <br /><br /><br />
                                    _____________________________<br />
                                    EL HUESPED (Principal)<br />
                                    Nombre: <?php echo urldecode($nombre); ?><br />
                                    Identificacion: <?php echo $tipodoc." ".$idusuario; ?>
                                </p>
                                <p style="text-align: justify; font-size: 10px">
                                    
                                </p>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
      </div>
    </div>

    
  </body>
</html>
