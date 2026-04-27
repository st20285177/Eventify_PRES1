<?php
declare(strict_types=1);
require_once __DIR__ . '/config/app.php';
$pageTitle = 'Eventify | Welcome';
require_once __DIR__ . '/views/partials/header.php';
?>
<style>
    .feature-showcase {
        width: 100%;
        margin-bottom: 3rem;
        padding: 1.25rem;
        border-radius: 32px;
        background: linear-gradient(180deg, rgba(255,255,255,.42), rgba(255,255,255,.16));
        border: 1px solid rgba(91, 140, 255, .12);
        box-shadow: 0 18px 36px rgba(64, 89, 146, .08);
    }
    .feature-showcase-header {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 1rem;
        margin-bottom: 1rem;
        padding: .25rem .25rem 0;
    }
    .feature-showcase-header h2 {
        margin: 0;
        font-weight: 700;
        color: #1b2744;
    }
    .feature-showcase-header p {
        margin: .35rem 0 0;
        color: #5f6f92;
    }
    .scroll-hint {
        font-size: .9rem;
        color: #6a5cff;
        background: rgba(106, 92, 255, .08);
        border: 1px solid rgba(106, 92, 255, .15);
        padding: .55rem .9rem;
        border-radius: 999px;
        white-space: nowrap;
    }
    .feature-slider {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        gap: 24px;
        overflow-x: auto;
        overflow-y: hidden;
        padding: 6px 4px 22px;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
    }
    .feature-slide {
        flex: 0 0 calc((100% - 48px) / 3);
        min-width: 320px;
        scroll-snap-align: start;
        min-height: 230px;
        padding: 28px;
        border-radius: 28px;
        position: relative;
        overflow: hidden;
        background: linear-gradient(180deg, rgba(255,255,255,.96), rgba(255,255,255,.84));
        border: 1px solid rgba(91, 140, 255, .18);
        box-shadow: 0 18px 36px rgba(64, 89, 146, .13);
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .feature-slide:hover {
        transform: translateY(-4px);
        box-shadow: 0 24px 44px rgba(64, 89, 146, .18);
    }
    .feature-slide::before {
        content: "";
        position: absolute;
        inset: 0 0 auto 0;
        height: 6px;
        background: linear-gradient(90deg, #6a5cff, #57a5ff, #1fc8b5);
    }
    .feature-icon-bubble {
        width: 52px;
        height: 52px;
        display: grid;
        place-items: center;
        border-radius: 18px;
        margin-bottom: 18px;
        color: #fff;
        font-size: 1.35rem;
        background: linear-gradient(135deg, #6a5cff, #57a5ff);
        box-shadow: 0 12px 24px rgba(106, 92, 255, .2);
    }
    .feature-slide h2 {
        color: #1b2744;
        margin-bottom: .75rem;
        font-weight: 700;
    }
    .feature-slide p {
        color: #5f6f92;
        line-height: 1.65;
    }
    .feature-slider::-webkit-scrollbar {
        height: 13px;
    }
    .feature-slider::-webkit-scrollbar-track {
        background: #e5ebf8;
        border-radius: 999px;
        border: 4px solid transparent;
        background-clip: content-box;
    }
    .feature-slider::-webkit-scrollbar-thumb {
        background: linear-gradient(90deg, #6a5cff, #57a5ff, #1fc8b5);
        border-radius: 999px;
        border: 3px solid #eef4ff;
    }
    .feature-slider::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(90deg, #5548df, #407fe0, #19ad9d);
    }
    .feature-slider {
        scrollbar-color: #6a5cff #e5ebf8;
        scrollbar-width: thin;
    }
    .hero-rotator {
        position: relative;
        min-height: 420px;
        border-radius: 28px;
        overflow: hidden;
        background: linear-gradient(135deg, rgba(18,27,69,.98), rgba(11,18,56,.98));
        box-shadow: 0 24px 52px rgba(12, 24, 74, .24);
        border: 1px solid rgba(86, 118, 255, .15);
    }
    .hero-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transform: scale(1.03);
        transition: opacity .6s ease, transform .6s ease;
        padding: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .hero-slide.is-active {
        opacity: 1;
        transform: scale(1);
        z-index: 2;
    }
    .hero-slide--image img {
        width: 100%;
        max-width: 520px;
        height: auto;
        display: block;
    }
    .hero-slide--poster {
        background:
            radial-gradient(circle at top right, rgba(122, 90, 255, .28), transparent 30%),
            radial-gradient(circle at bottom left, rgba(31, 200, 181, .18), transparent 28%);
    }
    .poster-card {
        width: 100%;
        max-width: 420px;
        border-radius: 26px;
        padding: 24px;
        background: rgba(17, 28, 84, .78);
        border: 1px solid rgba(120, 149, 255, .18);
        box-shadow: 0 18px 32px rgba(0, 0, 0, .18);
    }
    .poster-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(255,255,255,.08);
        color: #b6c4ff;
        font-size: .82rem;
        letter-spacing: .08em;
        text-transform: uppercase;
    }
    .poster-card h3 {
        color: #fff;
        font-size: 2rem;
        margin: 1rem 0 .75rem;
    }
    .poster-meta {
        display: grid;
        gap: 12px;
        margin-top: 1.25rem;
    }
    .poster-meta-item {
        border-radius: 16px;
        padding: 12px 14px;
        background: rgba(255,255,255,.06);
        color: #d7e2ff;
    }
    .poster-meta-item strong {
        color: #fff;
        display: block;
    }
    .hero-slide--stats {
        background:
            radial-gradient(circle at 80% 20%, rgba(92, 83, 255, .24), transparent 24%),
            radial-gradient(circle at 20% 85%, rgba(31, 200, 181, .14), transparent 24%);
    }
    .stats-board {
        width: 100%;
        max-width: 460px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    .stats-card {
        border-radius: 22px;
        padding: 20px;
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(120, 149, 255, .18);
        color: #d7e2ff;
        min-height: 130px;
    }
    .stats-card strong {
        display: block;
        color: #fff;
        font-size: 2rem;
        margin-bottom: 8px;
    }
    .hero-dots {
        position: absolute;
        left: 50%;
        bottom: 18px;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        z-index: 5;
    }
    .hero-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255,255,255,.28);
        transition: transform .2s ease, background .2s ease;
    }
    .hero-dot.is-active {
        background: #7a6bff;
        transform: scale(1.15);
    }
    @media (max-width: 991px) {
        .feature-slide {
            flex: 0 0 78%;
        }
        .feature-showcase-header {
            align-items: flex-start;
            flex-direction: column;
        }
        .hero-rotator {
            min-height: 360px;
            margin-top: 1rem;
        }
    }
    @media (max-width: 576px) {
        .feature-slide {
            flex: 0 0 90%;
            min-width: 260px;
        }
        .hero-rotator {
            min-height: 320px;
        }
        .hero-slide,
        .poster-card,
        .stats-card {
            padding: 18px;
        }
        .stats-board {
            grid-template-columns: 1fr;
        }
    }
</style>
<section class="hero-section rounded-4 overflow-hidden mb-5">
    <div class="row g-0 align-items-center">
        <div class="col-lg-6 p-4 p-md-5">
            <span class="eyebrow">Public event advertising platform</span>
            <h1 class="display-5 fw-bold mt-3">Plan, publish and manage memorable events with confidence.</h1>
            <p class="lead text-secondary mt-3">Eventify is designed for a single organiser who needs a clean dashboard to create public event listings, manage updates and maintain a polished online presence.</p>
            <div class="d-flex flex-wrap gap-3 mt-4">
                <?php if (is_logged_in()): ?>
                    <a class="btn btn-primary btn-lg" href="add-event.php">Create an Event</a>
                    <a class="btn btn-outline-secondary btn-lg" href="view-events.php">Manage Events</a>
                <?php else: ?>
                    <a class="btn btn-primary btn-lg" href="login.php">Log in as Organiser</a>
                    <a class="btn btn-outline-secondary btn-lg" href="about.php">About the Platform</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-6 p-4 p-md-5">
    <div class="hero-rotator" id="heroRotator">
     <div class="hero-slide hero-slide--image is-active">
             <img src="assets/images/Image1.png" alt="Eventify image 1">
        </div>

        <div class="hero-slide hero-slide--image">
             <img src="assets/images/Image2.png" alt="Eventify image 2">
        </div>

        <div class="hero-slide hero-slide--image">
         <img src="assets/images/Image3.png" alt="Eventify image 3">
        </div>

        <div class="hero-dots" id="heroDots">
          <span class="hero-dot is-active"></span>
          <span class="hero-dot"></span>
           <span class="hero-dot"></span>
        </div>
     </div>
     </div>
    </div>
</section>
<section class="feature-showcase">
    <div class="feature-showcase-header">
        <div>
            <h2 class="h3">What you can do with Eventify</h2>
            <p>Swipe or scroll through the key tools available to organisers.</p>
        </div>
        <span class="scroll-hint">Scroll sideways →</span>
    </div>
    <div class="feature-slider">
        <article class="feature-slide">
            <div class="feature-icon-bubble">↔</div>
            <h2 class="h4">Designed for easy navigation</h2>
            <p class="mb-0">Move around the platform with ease, access the main features quickly, and manage your events from one simple dashboard.</p>
        </article>
        <article class="feature-slide">
            <div class="feature-icon-bubble">＋</div>
            <h2 class="h4">Add and manage events</h2>
            <p class="mb-0">Create new events in minutes and keep everything up to date, from the venue and schedule to ticket price, capacity, images and event details.</p>
        </article>
        <article class="feature-slide">
            <div class="feature-icon-bubble">✎</div>
            <h2 class="h4">Edit and delete control</h2>
            <p class="mb-0">Edit your listings with ease, update important details, and delete old events when they are no longer needed.</p>
        </article>
        <article class="feature-slide">
            <div class="feature-icon-bubble">🔒</div>
            <h2 class="h4">Secure organiser access</h2>
            <p class="mb-0">Log in securely to access organiser tools and manage event listings from one convenient place.</p>
        </article>
        <article class="feature-slide">
            <div class="feature-icon-bubble">☰</div>
            <h2 class="h4">Clear event overview</h2>
            <p class="mb-0">View your events in one place and keep track of the details that matter most.</p>
        </article>
        <article class="feature-slide">
            <div class="feature-icon-bubble">◱</div>
            <h2 class="h4">Responsive design</h2>
            <p class="mb-0">The platform is designed to work smoothly across different screen sizes for a better user experience.</p>
        </article>
    </div>
</section>
<section class="row g-4 align-items-stretch">
    <div class="col-lg-7">
        <div class="content-panel h-100">
            <h2 class="h3">This website has been developed using:</h2>
            <ul class="check-list mt-3">
                <li>HTML to create the structure and content of the website.</li>
                <li>CSS to control the styling, layout and overall appearance.</li>
                <li>Bootstrap to provide a responsive and consistent design across all pages.</li>
                <li>JavaScript to support interactive features, form validation and overall usability.</li>
                <li>PHP to handle server-side logic, page processing and organiser functionality.</li>
                <li>MySQL to store and manage event information and user data.</li>
                <li>An MVC-inspired structure with server-side rendering to keep the website organised and easier to maintain.</li>
                <li>Semantic HTML and accessible form labels to improve accessibility and create a better user experience.</li>
            </ul>
        </div>
    </div>
    <div class="col-lg-5">
        <aside class="content-panel h-100">
            <h2 class="h3">How to add new event</h2>
            <ol class="ps-3 mb-0">
                <li>Log in as the organiser.</li>
                <li>Create an event.</li>
                <li>Browse the list of available events.</li>
                <li>Choose the event you would like to attend.</li>
                <li>Review the event details, including date, time and venue.</li>
                <li>Follow the booking instructions provided on the event page.</li>
                <li>Review, edit and delete it from the event list.</li>
            </ol>
        </aside>
    </div>
</section>
<script>
    (function () {
        const slides = document.querySelectorAll('#heroRotator .hero-slide');
        const dots = document.querySelectorAll('#heroDots .hero-dot');
        let current = 0;
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('is-active', i === index);
            });
            dots.forEach((dot, i) => {
                dot.classList.toggle('is-active', i === index);
            });
        }
        setInterval(() => {
            current = (current + 1) % slides.length;
            showSlide(current);
        }, 3000);
    })();
</script>
<?php require_once __DIR__ . '/views/partials/footer.php'; ?>