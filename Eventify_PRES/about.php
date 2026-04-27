<?php

declare(strict_types=1);

require_once __DIR__ . '/config/app.php';

$pageTitle = 'Eventify | About';
require_once __DIR__ . '/views/partials/header.php';
?>
<section class="row g-4 align-items-stretch">
    <div class="col-lg-7">
        <article class="content-panel h-100">
            <span class="eyebrow">About the website</span>
            <h1 class="h2 mt-2">What Eventify is designed to do</h1>
            <p>Eventify is a tool that helps people who organise events. It makes it easy for them to let others know about their events, look at what's already happening, and make changes as needed. This way, everything stays up to date and easy to understand.</p>
            <p>The platform is intentionally structured around usability, accessibility, and a professional visual hierarchy. It uses semantic HTML, Bootstrap, custom CSS, JavaScript validation, PHP, MySQL, and a simple MVC-inspired architecture to demonstrate full-stack web development practice.</p>
            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <div class="mini-card h-100">
                        <h2 class="h5">Design values</h2>
                        <p class="mb-0">Consistency, clarity, accessibility, feedback and simple navigation.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mini-card h-100">
                        <h2 class="h5">Technical values</h2>
                        <p class="mb-0">Separation of concerns, secure form handling and maintainable structure.</p>
                    </div>
                </div>
            </div>
        </article>
    </div>
    <div class="col-lg-5">
        <aside class="content-panel h-100">
            <span class="eyebrow">About the developer</span>
            <h2 class="h3 mt-2">Developer statement</h2>
            <p>This prototype has been produced as part of the DAT6006 assessment to demonstrate design planning, architecture awareness, and practical implementation across front-end and back-end technologies.</p>
            <p class="mb-0">I have created Eventify to make it easy for organisers to create and manage event listings. My goal was to build a website that's simple, easy to use, and looks professional. I wanted to make sure the site is straightforward, with a clean design and a consistent feel throughout. This way, users can easily find what they're looking for and have a great experience. I focused on keeping things simple and practical, so organisers can quickly create and manage their events without being overwhelmed by complicated features. The result is a platform that's easy to navigate and use, making it perfect for anyone looking to create and manage public events.</p>
        </aside>
    </div>
</section>
<?php require_once __DIR__ . '/views/partials/footer.php'; ?>
