<?php
/*
 * ============================================================
 *   REGALO DE CUMPLEAÑOS PARA CHAN
 * ============================================================
 *  Hecho con mucho cariño: PHP + HTML + CSS + JavaScript.
 *
 *  COMO EJECUTARLO (necesitas PHP instalado):
 *    1) Abre una terminal en esta carpeta.
 *    2) Ejecuta:  php -S localhost:8000
 *    3) Abre el navegador en:  http://localhost:8000
 * ============================================================
 */

// ------------------------------------------------------------
// CONFIGURACION: cambia estos datos por los reales
// ------------------------------------------------------------
$nombre      = "Chan";
$edad        = 20;                       // (opcional) ponle su edad
$amigosDesde = "2021-06-01";             // fecha desde la que se conocen

// ------------------------------------------------------------
// Calcular cuantos dias llevan siendo amigos
// ------------------------------------------------------------
$inicio        = new DateTime($amigosDesde);
$hoy           = new DateTime('today');
$diasJuntos    = $inicio->diff($hoy)->days;

// ------------------------------------------------------------
// Mensajes secretos que se esconden dentro de las cajas de regalo
// ------------------------------------------------------------
$regalos = [
    [
        "icono"   => "&#9670;",
        "titulo"  => "Tu primer diamante",
        "texto"   => "Te acuerdas de la primera vez que encontramos diamantes juntos en Minecraft? " .
                     "Gritaste tan fuerte por el micro que casi me rompes el oido. Fue uno de los mejores dias.",
        "color"   => "#4AEDD9",
    ],
    [
        "icono"   => "&#9733;",
        "titulo"  => "Ace en Valorant",
        "texto"   => "Te he visto hacer aces que ni los pros. La mejor player que he conocido, sin discusion. " .
                     "Contigo hasta un 1v5 parece facil.",
        "color"   => "#FF4655",
    ],
    [
        "icono"   => "&#9829;",
        "titulo"  => "Eres muy especial",
        "texto"   => "No eres una chica cualquiera. Eres de esas personas que aparecen una vez en la vida " .
                     "y se quedan para siempre en el corazon.",
        "color"   => "#FF5C8A",
    ],
    [
        "icono"   => "&#10048;",
        "titulo"  => "Perdoname",
        "texto"   => "Sé que no todo fue perfecto y que hubo momentos duros. Aun asi te quiero muchisimo, " .
                     "y quiero que siempre lo sepas. A pesar de todo, tu.",
        "color"   => "#FFD700",
    ],
];

// ------------------------------------------------------------
// Mensajes romanticos que van apareciendo aleatoriamente
// ------------------------------------------------------------
$frases = [
    "Eres mi cabeza de creeper favorita.",
    "En Valorant nadie te gana una 1v1.",
    "Contigo hasta xd exagerado es divertido.",
    "Me encanta jugar contigo, hoy y siempre.",
    "Eres la mejor, punto.",
    "Gracias por existir, Chan.",
    "Siempre gana nuestro duo.",
];

$fraseRandom = $frases[array_rand($frases)];

// ------------------------------------------------------------
// Guardar una carta del formulario en un archivo
// ------------------------------------------------------------
$cartaGuardada = false;
$carpetaCartas = __DIR__ . DIRECTORY_SEPARATOR . "cartas";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["carta"])) {
    $texto = trim($_POST["carta"]);
    if ($texto !== "") {
        if (!is_dir($carpetaCartas)) {
            @mkdir($carpetaCartas, 0777, true);
        }
        $archivo  = $carpetaCartas . DIRECTORY_SEPARATOR . "carta_" . date("Ymd_His") . ".txt";
        $contenido = date("d/m/Y H:i") . " - Para Chan:\n" . $texto . "\n";
        @file_put_contents($archivo, $contenido);
        $cartaGuardada = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feliz Cumpleanos, <?php echo htmlspecialchars($nombre); ?>!</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Lluvia de particulas (Minecraft style) -->
    <canvas id="particles"></canvas>

    <!-- ======================= HERO ======================= -->
    <header class="hero">
        <div class="hero-glow"></div>

        <div class="pixel-heart" aria-hidden="true">
            <span class="pixel"></span><span class="pixel"></span><span class="pixel"></span><span class="pixel"></span><span class="pixel"></span>
            <span class="pixel"></span><span class="pixel"></span><span class="pixel"></span><span class="pixel"></span><span class="pixel"></span>
            <span class="pixel"></span><span class="pixel"></span><span class="pixel"></span><span class="pixel"></span><span class="pixel"></span>
            <span class="pixel"></span><span class="pixel"></span><span class="pixel"></span><span class="pixel"></span><span class="pixel"></span>
            <span class="pixel"></span><span class="pixel"></span><span class="pixel"></span><span class="pixel"></span><span class="pixel"></span>
        </div>

        <p class="hero-kicker">&#9670; Un regalo hecho a mano &#9670;</p>
        <h1 class="hero-title">Feliz Cumplea&ntilde;os</h1>
        <h2 class="hero-name"><?php echo strtoupper(htmlspecialchars($nombre)); ?></h2>

        <p class="hero-sub">
            Para la chica m&aacute;s especial que conozco.<br>
            <?php echo htmlspecialchars($fraseRandom); ?>
        </p>

        <div class="hero-stats">
            <div class="stat">
                <span class="stat-num"><?php echo $diasJuntos; ?></span>
                <span class="stat-label">d&iacute;as juntos</span>
            </div>
            <div class="stat">
                <span class="stat-num">&#8734;</span>
                <span class="stat-label">partidas jugadas</span>
            </div>
            <div class="stat">
                <span class="stat-num">1</span>
                <span class="stat-label">persona como t&uacute;</span>
            </div>
        </div>

        <a href="#minecraft" class="btn-scroll">Desliza para bajar &#9660;</a>
    </header>

    <!-- ======================= MINECRAFT ======================= -->
    <section class="section" id="minecraft">
        <div class="section-inner">
            <p class="section-tag tag-green">&#9632; Nuestro mundo</p>
            <h3 class="section-title">Minecraft con vos</h3>
            <p class="section-desc">
                Todas esas horas construyendo, picando y muriendo por un creeper...
                Cada bloque de ese mundo guarda un recuerdo contigo.
            </p>

            <div class="blocks">
                <div class="block-card reveal">
                    <div class="block-face grass"></div>
                    <h4>Nuestra base</h4>
                    <p>Esa casa que nunca terminamos y que dec&iacute;amos que iba a ser la mejor del server.</p>
                </div>
                <div class="block-card reveal">
                    <div class="block-face diamond"></div>
                    <h4>Minando juntos</h4>
                    <p>Cada diamante que encontraba era tuyo. Y cada uno que encontrabas me lo presum&iacute;as.</p>
                </div>
                <div class="block-card reveal">
                    <div class="block-face redstone"></div>
                    <h4>Nuestras bromas</h4>
                    <p>Tus trampas de redstone y mis gritos cuando volaba por los aires. Nunca me aburro contigo.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ======================= VALORANT ======================= -->
    <section class="section section-dark" id="valorant">
        <div class="section-inner">
            <p class="section-tag tag-red">&#9733; Ace Hunter</p>
            <h3 class="section-title">La mejor player de Valorant</h3>
            <p class="section-desc">
                Te lo digo en serio: eres la mejor jugadora que conozco.
                Punto. No hay discusi&oacute;n.
            </p>

            <div class="stats-grid">
                <div class="stat-card reveal">
                    <span class="stat-icon">&#9673;</span>
                    <span class="stat-big">100%</span>
                    <span class="stat-small">de punter&iacute;a</span>
                </div>
                <div class="stat-card reveal">
                    <span class="stat-icon">&#128165;</span>
                    <span class="stat-big">ACE</span>
                    <span class="stat-small">casi cada partida</span>
                </div>
                <div class="stat-card reveal">
                    <span class="stat-icon">&#127942;</span>
                    <span class="stat-big">MVP</span>
                    <span class="stat-small">del coraz&oacute;n</span>
                </div>
                <div class="stat-card reveal">
                    <span class="stat-icon">&#128149;</span>
                    <span class="stat-big">DUO</span>
                    <span class="stat-small">perfecto</span>
                </div>
            </div>

            <p class="valorant-line">
                &ldquo;GG WP&rdquo; no significa nada cuando juego contigo...
                ganemos o perdamos, siempre es la mejor partida.
            </p>
        </div>
    </section>

    <!-- ======================= REGALOS ======================= -->
    <section class="section" id="regalos">
        <div class="section-inner">
            <p class="section-tag tag-gold">&#10048; Abre tus regalos</p>
            <h3 class="section-title">4 cajitas, 4 verdades</h3>
            <p class="section-desc">Haz clic en cada una. Guardan algo que quiero decirte.</p>

            <div class="gifts">
                <?php foreach ($regalos as $i => $r): ?>
                    <button class="gift reveal"
                            data-titulo="<?php echo htmlspecialchars($r['titulo']); ?>"
                            data-texto="<?php echo htmlspecialchars($r['texto']); ?>"
                            data-color="<?php echo htmlspecialchars($r['color']); ?>"
                            data-icono="<?php echo htmlspecialchars($r['icono']); ?>">
                        <span class="gift-lid"></span>
                        <span class="gift-box">
                            <span class="gift-symbol" style="color:<?php echo htmlspecialchars($r['color']); ?>">
                                <?php echo $r['icono']; ?>
                            </span>
                        </span>
                        <span class="gift-hint">t&oacute;came</span>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ======================= CARTA ======================= -->
    <section class="section section-letter" id="carta">
        <div class="section-inner">
            <p class="section-tag tag-pink">&#9829; Desde el coraz&oacute;n</p>
            <h3 class="section-title">A pesar de todo</h3>

            <div class="letter reveal">
                <p>Chan,</p>
                <p>
                    No s&eacute; muy bien c&oacute;mo empezar esto, as&iacute; que lo digo simple:
                    eres una chica muy, muy especial para m&iacute;.
                </p>
                <p>
                    S&eacute; que no todo ha sido f&aacute;cil. Que hubo momentos que dolieron,
                    cosas que se dijeron y cosas que se quedaron sin decir. Pero a pesar de todo,
                    a pesar de todo lo que pas&oacute;, <strong>te quiero mucho</strong>.
                </p>
                <p>
                    Me quedo con las risas en Minecraft, con las partidas de Valorant donde me
                    salvabas la vida, con tu voz en el micro y con cada momento que compartimos.
                    Eso es lo que importa.
                </p>
                <p>
                    Hoy es tu d&iacute;a. Ojal&aacute; te r&iacute;as tanto como cuando te mato sin querer
                    y ojal&aacute; este a&ntilde;o te traiga todo lo bonito que mereces.
                </p>
                <p class="letter-sign">Con todo mi cari&ntilde;o &#9829;</p>
            </div>

            <div class="letter-form">
                <h4>&iquest;Quieres dejarme una carta t&uacute; tambi&eacute;n?</h4>
                <?php if ($cartaGuardada): ?>
                    <p class="form-ok">&#10003; Tu carta se guard&oacute; con mucho cari&ntilde;o. Gracias, Chan.</p>
                <?php endif; ?>
                <form method="POST" action="#carta">
                    <textarea name="carta" rows="5" placeholder="Escribe algo lindo aqu&iacute;..." required></textarea>
                    <button type="submit" class="btn-send">Enviar mi carta &#9829;</button>
                </form>
            </div>
        </div>
    </section>

    <!-- ======================= FINAL ======================= -->
    <footer class="footer">
        <button id="confettiBtn" class="btn-confetti">&#127881; Lanzar confeti</button>
        <button id="musicBtn" class="btn-music">&#9835; Tocar canci&oacute;n</button>
        <p class="footer-text">
            Hecho a mano, solo para <?php echo htmlspecialchars($nombre); ?>. &#9829;<br>
            <?php echo date("Y"); ?> &middot; Feliz cumplea&ntilde;os de nuevo.
        </p>
    </footer>

    <!-- ======================= MODAL ======================= -->
    <div class="modal" id="modal">
        <div class="modal-content">
            <button class="modal-close" id="modalClose">&times;</button>
            <div class="modal-icon" id="modalIcon"></div>
            <h3 id="modalTitle"></h3>
            <p id="modalText"></p>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
