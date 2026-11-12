<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
$indicadores = [
    ['numero' => '12.500+', 'titulo' => 'Entregas realizadas'],
    ['numero' => '98,5%', 'titulo' => 'Índice de pontualidade'],
    ['numero' => '45+', 'titulo' => 'Parceiros logísticos'],
    ['numero' => '24/7', 'titulo' => 'Acompanhamento operacional']
];
?>

<link rel="stylesheet" href="./assets/css/home.css">

<main class="tt-home">

    <!-- HERO -->
    <section class="tt-home__hero">

        <div class="tt-home__hero-content">

            <span class="tt-home__eyebrow">
                LOGÍSTICA INTELIGENTE • TRANSPORTE • INOVAÇÃO
            </span>

            <h1>
                Movimentamos o futuro.
                <span>Entregamos confiança.</span>
            </h1>

            <p>
                Conectamos destinos e oportunidades através de soluções
                inteligentes em transporte e logística. Sua carga,
                nossa responsabilidade.
            </p>

            <div class="tt-home__hero-actions">
                <a href="index.php?pagina=fretes"
                   class="tt-home__button tt-home__button--primary">
                    Conhecer nossos serviços
                    <span>↗</span>
                </a>

                <a href="#sobre"
                   class="tt-home__button tt-home__button--outline">
                    Conheça a TranspTech
                </a>
            </div>

            <div class="tt-home__hero-note">
                <span class="tt-home__status-dot"></span>
                Tecnologia e eficiência em cada entrega.
            </div>

        </div>

        <div class="tt-home__hero-image">
            <div class="tt-home__image-overlay"></div>

            <div class="tt-home__floating-card">
                <span>OPERAÇÃO LOGÍSTICA</span>
                <strong>Em movimento</strong>
                <small>Conectando destinos todos os dias.</small>
            </div>
        </div>

    </section>


    <!-- INDICADORES -->
    <section class="tt-home__stats">

        <?php foreach ($indicadores as $indicador): ?>

            <article class="tt-home__stat">
                <strong>
                    <?= htmlspecialchars($indicador['numero']) ?>
                </strong>

                <span>
                    <?= htmlspecialchars($indicador['titulo']) ?>
                </span>
            </article>

        <?php endforeach; ?>

    </section>


    <!-- SOBRE -->
    <section class="tt-home__about" id="sobre">

        <div class="tt-home__section-heading">
            <span class="tt-home__eyebrow">QUEM SOMOS</span>

            <h2>
                Mais do que transportar.
                <span>Conectamos possibilidades.</span>
            </h2>
        </div>

        <div class="tt-home__about-content">

            <div class="tt-home__about-image">
                <img
                    src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1000&q=85"
                    alt="Centro logístico e armazenamento de mercadorias"
                    loading="lazy"
                >
            </div>

            <div class="tt-home__about-text">

                <h3>Uma nova forma de pensar a logística.</h3>

                <p>
                    A TranspTech nasceu com o propósito de transformar
                    a maneira como empresas gerenciam suas operações
                    de transporte.
                </p>

                <p>
                    Unimos planejamento, tecnologia e profissionais
                    qualificados para oferecer uma experiência
                    logística mais eficiente, segura e transparente.
                </p>

                <div class="tt-home__values">

                    <div>
                        <span>01</span>
                        <strong>Compromisso</strong>
                        <p>Responsabilidade em cada operação.</p>
                    </div>

                    <div>
                        <span>02</span>
                        <strong>Inovação</strong>
                        <p>Tecnologia trabalhando a nosso favor.</p>
                    </div>

                    <div>
                        <span>03</span>
                        <strong>Confiança</strong>
                        <p>Relacionamentos construídos com transparência.</p>
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- SERVIÇOS -->
    <section class="tt-home__services">

        <div class="tt-home__section-heading">
            <span class="tt-home__eyebrow">O QUE FAZEMOS</span>

            <h2>
                Soluções que movem
                <span>o seu negócio.</span>
            </h2>

            <p>
                Uma operação logística completa, planejada para
                atender diferentes necessidades.
            </p>
        </div>

        <div class="tt-home__service-grid">

            <article class="tt-home__service-card">
                <div class="tt-home__service-icon">↗</div>
                <h3>Transporte de cargas</h3>
                <p>
                    Movimentação de mercadorias com planejamento,
                    segurança e eficiência.
                </p>
                <a href="index.php?pagina=fretes">Saiba mais →</a>
            </article>

            <article class="tt-home__service-card">
                <div class="tt-home__service-icon">▤</div>
                <h3>Gestão de fretes</h3>
                <p>
                    Organização e controle das operações
                    em um único ambiente.
                </p>
                <a href="index.php?pagina=fretes">Saiba mais →</a>
            </article>

            <article class="tt-home__service-card">
                <div class="tt-home__service-icon">⌖</div>
                <h3>Distribuição logística</h3>
                <p>
                    Planejamento de rotas e conexão entre
                    origem e destino.
                </p>
                <a href="index.php?pagina=transporte">Saiba mais →</a>
            </article>

            <article class="tt-home__service-card">
                <div class="tt-home__service-icon">◷</div>
                <h3>Acompanhamento</h3>
                <p>
                    Monitoramento das etapas para proporcionar
                    maior transparência operacional.
                </p>
                <a href="index.php?pagina=fretes">Saiba mais →</a>
            </article>

        </div>

    </section>


    <!-- DIFERENCIAIS -->
    <section class="tt-home__difference">

        <div class="tt-home__difference-content">

            <span class="tt-home__eyebrow">
                NOSSO DIFERENCIAL
            </span>

            <h2>
                Sua operação merece
                <span>ir mais longe.</span>
            </h2>

            <p>
                Acreditamos que uma logística eficiente começa
                com organização, informação e pessoas comprometidas.
            </p>

            <ul>
                <li>Planejamento operacional estruturado</li>
                <li>Controle centralizado de informações</li>
                <li>Gestão de transportadores e produtos</li>
                <li>Mais transparência nas operações</li>
            </ul>

            <a href="index.php?pagina=transporte"
               class="tt-home__button tt-home__button--primary">
                Conhecer nossa operação ↗
            </a>

        </div>

        <div class="tt-home__difference-visual">
            <div class="tt-home__visual-box">
                <span>TRANSPTECH</span>
                <strong>Logística inteligente.</strong>
                <div class="tt-home__visual-line"></div>
                <small>Planejamento • Tecnologia • Eficiência</small>
            </div>
        </div>

    </section>


    <!-- CTA -->
    <section class="tt-home__cta">

        <span class="tt-home__eyebrow">VAMOS CONECTAR DESTINOS?</span>

        <h2>
            O próximo destino do seu negócio
            <span>começa aqui.</span>
        </h2>

        <p>
            Conte com uma operação logística planejada
            para acompanhar o crescimento da sua empresa.
        </p>

        <a href="index.php?pagina=fretes"
           class="tt-home__button tt-home__button--primary">
            Acesse nossos serviços ↗
        </a>

    </section>

    <footer class="tt-home__disclaimer">
        Informações institucionais e indicadores fictícios,
        utilizados exclusivamente para demonstração acadêmica.
    </footer>

</main>

</body>
</html>