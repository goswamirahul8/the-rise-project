// Comprehensive Interactive JavaScript Controller for The Rise

const FLOOR_PLANS_DATA = {
    '2bhk': {
        type: '2 BHK',
        title: '2 BHK Luxury Residence',
        area: '940.12 SQ. FT.',
        bathrooms: '2.5 Bath',
        bedrooms: '2 En Suite',
        balconies: '2 Terraces',
        description: 'Efficiently planned luxury layout with double-height living room balcony, cross-ventilation, and master suite with walk-in wardrobe area.',
        image: 'assets/figma/floor-plan-2bhk.png'
    },
    '3bhk': {
        type: '3 BHK',
        title: '3 BHK Premium Residence',
        area: '1,650.50 SQ. FT.',
        bathrooms: '3.5 Bath',
        bedrooms: '3 En Suite',
        balconies: '3 Terraces',
        description: 'Expansive multi-generational home with dedicated powder room, grand foyer, wrap-around viewing balcony, and maid quarters.',
        image: 'assets/figma/floor-plan-2bhk.png'
    },
    '4bhk': {
        type: '4 BHK',
        title: '4 BHK Presidential Sky Suite',
        area: '2,480.00 SQ. FT.',
        bathrooms: '4.5 Bath',
        bedrooms: '4 En Suite',
        balconies: '4 Terraces',
        description: 'Unrivaled luxury occupying corner footprints with 270-degree sky views, double master suites, private elevator vestibule, and chef kitchen.',
        image: 'assets/figma/floor-plan-2bhk.png'
    }
};

let currentFloorPlanKey = '2bhk';

// Switch Active Floorplan Tab
window.switchFloorPlan = function(key) {
    currentFloorPlanKey = key;
    const plan = FLOOR_PLANS_DATA[key];
    if (!plan) return;

    // Update Tab Classes
    document.querySelectorAll('.fp-tab-btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.getAttribute('data-plan') === key) {
            btn.classList.add('active');
        }
    });

    // Update Text Content
    const titleEl = document.getElementById('fpTitle');
    const descEl = document.getElementById('fpDesc');
    const areaEl = document.getElementById('fpArea');
    const bedsEl = document.getElementById('fpBeds');
    const bathsEl = document.getElementById('fpBaths');
    const balconiesEl = document.getElementById('fpBalconies');
    const imgEl = document.getElementById('fpImage');

    if (titleEl) titleEl.textContent = plan.title;
    if (descEl) descEl.textContent = plan.description;
    if (areaEl) areaEl.textContent = plan.area;
    if (bedsEl) bedsEl.textContent = plan.bedrooms;
    if (bathsEl) bathsEl.textContent = plan.bathrooms;
    if (balconiesEl) balconiesEl.textContent = plan.balconies;
    if (imgEl) imgEl.src = plan.image;
};

// Modal Trigger Functions
window.openEnquiryModal = function(title, defaultBhk) {
    const titleEl = document.getElementById('modalTitleText');
    const selectEl = document.querySelector('#enquiryModal select[name="bhk_preference"]');

    if (titleEl) {
        titleEl.textContent = title || 'INQUIRE ABOUT THE RISE';
    }

    if (selectEl && defaultBhk) {
        selectEl.value = defaultBhk;
    }

    const modal = document.getElementById('enquiryModal');
    if (modal) modal.classList.add('active');
};

window.openBrochureModal = function() {
    const modal = document.getElementById('brochureModal');
    if (modal) modal.classList.add('active');
};

window.closeModals = function() {
    document.querySelectorAll('.modal-backdrop, .lightbox-modal').forEach(m => m.classList.remove('active'));
};

// Lightbox Viewer
window.openLightbox = function(imgSrc) {
    const lb = document.getElementById('lightboxModal');
    const lbImg = document.getElementById('lightboxImg');
    if (lb && lbImg) {
        lbImg.src = imgSrc || document.getElementById('fpImage').src;
        lb.classList.add('active');
    }
};

// Form Handler Helper
window.handleFormSubmit = function(event, message) {
    event.preventDefault();
    alert(message || 'Thank you! Your request has been logged successfully.');
    closeModals();
    event.target.reset();
};

document.addEventListener('DOMContentLoaded', () => {
    // Backdrop click close
    window.onclick = function(event) {
        if (event.target.classList.contains('modal-backdrop') || event.target.classList.contains('lightbox-modal')) {
            closeModals();
        }
    };
});
