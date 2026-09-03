<?php
require_once __DIR__ . '/config/db.php';

$message = '';
$message_type = '';

// Handle Form Submissions (Enquiry & Brochure)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getDBConnection();
    
    $action = $_POST['action'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $country_code = trim($_POST['country_code'] ?? '+91');
    $phone = trim($_POST['phone'] ?? '');

    if (!empty($name) && !empty($email) && !empty($phone)) {
        if ($action === 'enquiry') {
            $bhk = $_POST['bhk_preference'] ?? '3 BHK Luxury Residence';
            $visit_date = !empty($_POST['site_visit_date']) ? $_POST['site_visit_date'] : null;

            if ($conn) {
                try {
                    $stmt = $conn->prepare("INSERT INTO enquiries (name, email, country_code, phone, bhk_preference, site_visit_date) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$name, $email, $country_code, $phone, $bhk, $visit_date]);
                    $message = "Thank you $name! Your site visit request has been submitted successfully.";
                    $message_type = "success";
                } catch (PDOException $e) {
                    $message = "Database error: " . $e->getMessage();
                    $message_type = "error";
                }
            } else {
                $message = "Thank you $name! Your enquiry has been received.";
                $message_type = "success";
            }
        } elseif ($action === 'brochure') {
            if ($conn) {
                try {
                    $stmt = $conn->prepare("INSERT INTO brochure_requests (name, email, country_code, phone) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$name, $email, $country_code, $phone]);
                    $message = "Thank you $name! Your E-Brochure request has been logged.";
                    $message_type = "success";
                } catch (PDOException $e) {
                    $message = "Database error: " . $e->getMessage();
                    $message_type = "error";
                }
            } else {
                $message = "Thank you $name! E-Brochure download initiated.";
                $message_type = "success";
            }
        }
    } else {
        $message = "Please fill in all required fields.";
        $message_type = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Rise by Ruchira Projects | Luxury Living Residences</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800&family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <?php if (!empty($message)): ?>
        <div style="position:fixed; top:80px; right:20px; z-index:99999; background: <?= $message_type === 'success' ? '#2e7d32' : '#d32f2f' ?>; color:#fff; padding:16px 24px; border-radius:4px; font-weight:600; box-shadow:0 10px 30px rgba(0,0,0,0.5);">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <!-- Sticky Luxury Navigation Header -->
    <header class="luxury-header">
        <a href="#hero" class="luxury-logo">
            <span style="font-family:'Cinzel', serif; font-size:20px; font-weight:700; color:#B9A15A; letter-spacing:2px;">THE RISE</span>
            <span style="font-size:10px; color:#aaaaaa; letter-spacing:1px; margin-left:6px;">BY RUCHIRA</span>
        </a>

        <ul class="luxury-nav-menu">
            <li><a href="#about" class="luxury-nav-link">ABOUT US</a></li>
            <li><a href="#highlights" class="luxury-nav-link">HIGHLIGHTS</a></li>
            <li><a href="#amenities" class="luxury-nav-link">AMENITIES</a></li>
            <li><a href="#skybridge" class="luxury-nav-link">SKY BRIDGE</a></li>
            <li><a href="#location" class="luxury-nav-link">LOCATION</a></li>
            <li><a href="#sustainability" class="luxury-nav-link">SUSTAINABILITY</a></li>
            <li><a href="#masterplan" class="luxury-nav-link">MASTER PLAN</a></li>
            <li><a href="#floorplans" class="luxury-nav-link">FLOOR PLANS</a></li>
            <li><a href="#gallery" class="luxury-nav-link">GALLERY</a></li>
            <li><a href="#contact" class="luxury-nav-link">CONTACT</a></li>
        </ul>

        <button class="luxury-header-btn" onclick="openEnquiryModal('ENQUIRE NOW')">ENQUIRE NOW</button>
    </header>

    <!-- Floating Right Side Action Tabs -->
    <div class="figma-floating-actions">
        <button class="figma-side-btn-gold" onclick="openEnquiryModal('QUICK ENQUIRY')">
            <span>ENQUIRY NOW</span>
        </button>
        <button class="figma-side-btn-dark" onclick="openBrochureModal()">
            <span>DOWNLOAD BROCHURE</span>
        </button>
    </div>

    <!-- 1:1 Figma Container -->
    <div class="figma-container">

        <!-- SECTION 01: HERO -->
        <section id="hero" class="figma-section">
            <img src="assets/figma-sections/01-hero.png" alt="The Rise Hero Section" class="section-bg">
            <button onclick="openEnquiryModal('HERO ENQUIRY NOW')" class="overlay-btn" style="top: 62%; left: 10.5%; width: 180px; height: 52px;" title="Enquiry Now"></button>
            <button onclick="openBrochureModal()" class="overlay-btn" style="top: 62%; left: 21%; width: 230px; height: 52px;" title="Download Brochure"></button>
        </section>

        <!-- SECTION 02: ABOUT -->
        <section id="about" class="figma-section">
            <img src="assets/figma-sections/02-about.png" alt="The Skyline Finds Its Signature" class="section-bg">
        </section>

        <!-- SECTION 03: HIGHLIGHTS -->
        <section id="highlights" class="figma-section">
            <img src="assets/figma-sections/03-highlights.png" alt="A Landmark, By Every Measure" class="section-bg">
        </section>

        <!-- SECTION 04: AMENITIES -->
        <section id="amenities" class="figma-section">
            <img src="assets/figma-sections/04-amenities.png" alt="Different Levels. Different Ways to Live" class="section-bg">
        </section>

        <!-- SECTION 05: SKY BRIDGE -->
        <section id="skybridge" class="figma-section">
            <img src="assets/figma-sections/05-skybridge.png" alt="The Sky Bridge at Level 34" class="section-bg">
            <button onclick="openEnquiryModal('EXPERIENCE THE SKY BRIDGE')" class="overlay-btn" style="bottom: 18%; left: 50%; transform: translateX(-50%); width: 280px; height: 56px;" title="Experience The Sky Bridge"></button>
        </section>

        <!-- SECTION 06: LOCATION -->
        <section id="location" class="figma-section">
            <img src="assets/figma-sections/06-location.png" alt="Well Connected. Well Positioned." class="section-bg">
        </section>

        <!-- SECTION 07: SUSTAINABILITY -->
        <section id="sustainability" class="figma-section">
            <img src="assets/figma-sections/07-sustainability.png" alt="Every Decision Made With Tomorrow In Mind" class="section-bg">
        </section>

        <!-- SECTION 08: MASTER PLAN -->
        <section id="masterplan" class="figma-section">
            <img src="assets/figma-sections/08-masterplan.png" alt="Designed As One Complete Experience" class="section-bg">
        </section>

        <!-- SECTION 09: FLOOR PLANS WITH INTERACTIVE WIDGET -->
        <section id="floorplans" class="figma-section">
            <img src="assets/figma-sections/09-floorplans.png" alt="Homes Designed Around Modern Living" class="section-bg">
            
            <!-- Interactive Dynamic Floor Plan Switcher Overlay -->
            <div class="floorplan-overlay-widget">
                <div class="fp-tabs">
                    <button class="fp-tab-btn active" data-plan="2bhk" onclick="switchFloorPlan('2bhk')">2 BHK SUITE</button>
                    <button class="fp-tab-btn" data-plan="3bhk" onclick="switchFloorPlan('3bhk')">3 BHK RESIDENCE</button>
                    <button class="fp-tab-btn" data-plan="4bhk" onclick="switchFloorPlan('4bhk')">4 BHK SKY DUPLEX</button>
                </div>

                <div class="fp-content-grid">
                    <div class="fp-details">
                        <h3 id="fpTitle">2 BHK Luxury Residence</h3>
                        <p id="fpDesc">Efficiently planned luxury layout with double-height living room balcony, cross-ventilation, and master suite with walk-in wardrobe area.</p>

                        <div class="fp-specs-grid">
                            <div>
                                <span class="fp-spec-label">TOTAL AREA</span>
                                <span class="fp-spec-value" id="fpArea">940.12 SQ. FT.</span>
                            </div>
                            <div>
                                <span class="fp-spec-label">BEDROOMS</span>
                                <span class="fp-spec-value" id="fpBeds">2 En Suite</span>
                            </div>
                            <div>
                                <span class="fp-spec-label">BATHROOMS</span>
                                <span class="fp-spec-value" id="fpBaths">2.5 Bath</span>
                            </div>
                            <div>
                                <span class="fp-spec-label">BALCONIES</span>
                                <span class="fp-spec-value" id="fpBalconies">2 Terraces</span>
                            </div>
                            <div>
                                <span class="fp-spec-label">HEIGHT</span>
                                <span class="fp-spec-value">11 Feet</span>
                            </div>
                            <div>
                                <span class="fp-spec-label">AMENITIES</span>
                                <span class="fp-spec-value">100+</span>
                            </div>
                        </div>

                        <div style="display:flex; gap:12px;">
                            <button class="btn-gold" style="width:auto; padding:14px 24px;" onclick="openEnquiryModal('INQUIRE FLOOR PLAN')">INQUIRE THIS PLAN</button>
                            <button class="btn-gold" style="width:auto; padding:14px 24px; background:#1C1C1C; color:#F5F2E9; border:1px solid #B9A15A;" onclick="openLightbox()">VIEW BLUEPRINT</button>
                        </div>
                    </div>

                    <div class="fp-image-container" onclick="openLightbox()">
                        <img id="fpImage" src="assets/figma/floor-plan-2bhk.png" alt="Floor Plan Blueprint">
                        <div style="position:absolute; bottom:16px; right:16px; background:rgba(0,0,0,0.7); padding:6px 12px; font-size:10px; color:#B9A15A; letter-spacing:1px; cursor:pointer;">CLICK TO ZOOM 🔍</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 10: GALLERY -->
        <section id="gallery" class="figma-section">
            <img src="assets/figma-sections/10-gallery.png" alt="A Landmark, Seen From Every Angle" class="section-bg">
        </section>

        <!-- SECTION 11: ABOUT RUCHIRA -->
        <section id="about-ruchira" class="figma-section">
            <img src="assets/figma-sections/11-about-ruchira.png" alt="Rooted In Trust - Ruchira Projects" class="section-bg">
        </section>

        <!-- SECTION 12: CONTACT CTA -->
        <section id="contact" class="figma-section">
            <img src="assets/figma-sections/12-contact.png" alt="Discover The Rise - Site Visit" class="section-bg">
            <button onclick="openEnquiryModal('BOOK A PRIVATE SITE VISIT')" class="overlay-btn" style="top: 48%; left: 10.5%; width: 240px; height: 54px;" title="Book a Site Visit"></button>
        </section>

        <!-- SECTION 13: FOOTER -->
        <section id="footer" class="figma-section">
            <img src="assets/figma-sections/13-footer.png" alt="The Rise Footer" class="section-bg">
        </section>

    </div>

    <!-- ENQUIRY / SITE VISIT MODAL -->
    <div class="modal-backdrop" id="enquiryModal">
        <div class="modal-box">
            <button class="modal-close" onclick="closeModals()">×</button>
            <div class="modal-title" id="modalTitleText">INQUIRE ABOUT THE RISE</div>
            <div class="modal-subtitle">Schedule a private guided tour of The Rise Experience Centre.</div>

            <form action="index.php" method="POST" id="enquiryForm">
                <input type="hidden" name="action" value="enquiry">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label>Email Address *</label>
                    <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                </div>
                <div class="form-group">
                    <label>Phone Number *</label>
                    <input type="tel" name="phone" class="form-control" placeholder="Enter 10 digit mobile number" required maxlength="10">
                </div>
                <div class="form-group">
                    <label>Residence Preference</label>
                    <select name="bhk_preference" class="form-control">
                        <option value="2 BHK Luxury Suite">2 BHK Luxury Suite</option>
                        <option value="3 BHK Luxury Residence" selected>3 BHK Luxury Residence</option>
                        <option value="3.5 BHK Premium Suite">3.5 BHK Premium Suite</option>
                        <option value="4 BHK Sky Duplex">4 BHK Sky Duplex</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Preferred Site Visit Date</label>
                    <input type="date" name="site_visit_date" class="form-control">
                </div>
                <button type="submit" class="btn-gold">SUBMIT & BOOK VISIT</button>
            </form>
        </div>
    </div>

    <!-- BROCHURE DOWNLOAD MODAL -->
    <div class="modal-backdrop" id="brochureModal">
        <div class="modal-box">
            <button class="modal-close" onclick="closeModals()">×</button>
            <div class="modal-title">DOWNLOAD E-BROCHURE</div>
            <div class="modal-subtitle">Enter your details to instantly receive the complete floorplans & brochure.</div>

            <form action="index.php" method="POST" id="brochureForm">
                <input type="hidden" name="action" value="brochure">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label>Email Address *</label>
                    <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                </div>
                <div class="form-group">
                    <label>Phone Number *</label>
                    <input type="tel" name="phone" class="form-control" placeholder="Enter 10 digit mobile number" required maxlength="10">
                </div>
                <button type="submit" class="btn-gold">DOWNLOAD BROCHURE NOW</button>
            </form>
        </div>
    </div>

    <!-- LIGHTBOX BLUEPRINT MODAL -->
    <div class="lightbox-modal" id="lightboxModal">
        <button class="modal-close" style="top:25px; right:35px; position:fixed;" onclick="closeModals()">×</button>
        <img id="lightboxImg" src="assets/figma/floor-plan-2bhk.png" class="lightbox-img" alt="Architectural Blueprint Zoom">
    </div>

    <!-- JavaScript Script -->
    <script src="assets/js/main.js"></script>
</body>

</html>
