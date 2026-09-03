// Interactive Frontend Controller for The Rise

document.addEventListener('DOMContentLoaded', () => {

    // Amenities Data
    const amenitiesData = [
        {
            title: "infinity Swimming Pool",
            category: "Wellness",
            desc: "Temperature-controlled swimming pool with panoramic views of the city skyline.",
            img: "assets/images/96a4a093c5844280c1a59d4ccfa1b617c3fb3b08.jpg"
        },
        {
            title: "State-of-the-Art Gymnasium",
            category: "Wellness",
            desc: "Equipped with world-class fitness gear, cardio zones, and personal training areas.",
            img: "assets/images/df8f6394386f2f8cd63a78d512d1218d40e9344b.jpg"
        },
        {
            title: "Yoga & Meditation Deck",
            category: "Wellness",
            desc: "Tranquil outdoor terrace designed for mindfulness, morning yoga, and relaxation.",
            img: "assets/images/62eef311fd598ba01ce310718356c96296f0eb64.jpg"
        },
        {
            title: "Private Mini Theatre",
            category: "Leisure",
            desc: "A 20-seater private screening room with Dolby Atmos surround sound.",
            img: "assets/images/2e6dd130e876baf17b1ca57ee7896863c429ac2b.jpg"
        },
        {
            title: "Sky Lounge & Bar",
            category: "Social",
            desc: "Elevated social hub at the Sky Bridge offering sunset views and cocktail seating.",
            img: "assets/images/8ff74f0bcdf75f0030e4abbaf88bf15f89efadd3.png"
        },
        {
            title: "Co-Working Hub & Boardrooms",
            category: "Work",
            desc: "High-speed Wi-Fi enabled workspaces, private pods, and meeting rooms.",
            img: "assets/images/3ea3497a008aee5a2139c8cad370153ee3b03bdf.png"
        }
    ];

    let currentAmenityIndex = 0;
    const amenitiesGrid = document.querySelector('.amenities-cards-grid');
    const counterEl = document.getElementById('amenityCounter');

    function renderAmenities() {
        if (!amenitiesGrid) return;
        amenitiesGrid.innerHTML = '';

        const slice = amenitiesData.slice(currentAmenityIndex, currentAmenityIndex + 3);
        slice.forEach(item => {
            const card = document.createElement('div');
            card.className = 'amenity-card';
            card.innerHTML = `
                <img src="${item.img}" alt="${item.title}">
                <div class="amenity-card-content">
                    <span style="font-size:10px; letter-spacing:1px; color:#c9a84c; text-transform:uppercase; font-weight:600;">${item.category}</span>
                    <h3>${item.title}</h3>
                    <p>${item.desc}</p>
                </div>
            `;
            amenitiesGrid.appendChild(card);
        });

        if (counterEl) {
            counterEl.textContent = `${String(currentAmenityIndex + 1).padStart(2, '0')} / ${String(amenitiesData.length).padStart(2, '0')}`;
        }
    }

    renderAmenities();

    const prevBtn = document.getElementById('prevAmenity');
    const nextBtn = document.getElementById('nextAmenity');

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            currentAmenityIndex = (currentAmenityIndex - 1 + amenitiesData.length) % amenitiesData.length;
            renderAmenities();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            currentAmenityIndex = (currentAmenityIndex + 1) % amenitiesData.length;
            renderAmenities();
        });
    }

    // Category Filter Pills
    const categoryPills = document.querySelectorAll('.category-pill');
    categoryPills.forEach(pill => {
        pill.addEventListener('click', () => {
            categoryPills.forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
        });
    });

    // Floorplan Tabs Switcher
    const floorplanData = {
        '2BHK': {
            title: 'THE BELGRAVIA SUITE (2 BHK)',
            desc: 'A curated home designed for dynamic professionals. The layout divides social areas from the master sanctuary, providing a seamless flow toward the private terrace.',
            img: 'assets/images/2e6dd130e876baf17b1ca57ee7896863c429ac2b.jpg',
            area: '940.12 SQ. FT.',
            bedrooms: '2 EN-SUITE',
            bathrooms: '2.5 BATH',
            balconies: '2 TERRACES'
        },
        '3BHK': {
            title: 'THE IMPERIAL RESIDENCE (3 BHK)',
            desc: 'Expansive 3 BHK layout featuring a grand living room, dining foyer, maid quarter, and triple-aspect floor-to-ceiling windows overlooking lush gardens.',
            img: 'assets/images/df8f6394386f2f8cd63a78d512d1218d40e9344b.jpg',
            area: '1,540.50 SQ. FT.',
            bedrooms: '3 EN-SUITE',
            bathrooms: '3.5 BATH',
            balconies: '3 TERRACES'
        },
        '4BHK': {
            title: 'THE SKY DUPLEX (4 BHK)',
            desc: 'Perched above Level 35, the Sky Duplex features a double-height living ceiling, private plunge pool, and panoramic 360-degree views of Bengaluru skyline.',
            img: 'assets/images/96a4a093c5844280c1a59d4ccfa1b617c3fb3b08.jpg',
            area: '2,850.00 SQ. FT.',
            bedrooms: '4 EN-SUITE + MAID',
            bathrooms: '5 BATH',
            balconies: '4 TERRACES'
        }
    };

    const planPills = document.querySelectorAll('.floorplan-section .tab-pill-btn');
    planPills.forEach(btn => {
        btn.addEventListener('click', () => {
            const type = btn.getAttribute('data-type');
            if (floorplanData[type]) {
                planPills.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const data = floorplanData[type];
                document.getElementById('planTitle').textContent = data.title;
                document.getElementById('planDesc').textContent = data.desc;
                document.getElementById('planImage').src = data.img;
                document.getElementById('specArea').textContent = data.area;
                document.getElementById('specBedrooms').textContent = data.bedrooms;
                document.getElementById('specBathrooms').textContent = data.bathrooms;
                document.getElementById('specBalconies').textContent = data.balconies;
            }
        });
    });

    // Custom Country Select Dropdown
    document.querySelectorAll('.custom-country-select').forEach(container => {
        const btn = container.querySelector('.country-select-btn');
        const hiddenInput = container.querySelector('input[type="hidden"]');
        const flagImg = btn.querySelector('.flag-img');
        const codeSpan = btn.querySelector('.selected-code');

        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            container.classList.toggle('open');
        });

        container.querySelectorAll('.country-option').forEach(option => {
            option.addEventListener('click', () => {
                const code = option.getAttribute('data-code');
                const flag = option.getAttribute('data-flag');

                hiddenInput.value = code;
                codeSpan.textContent = code;
                flagImg.src = flag;

                container.classList.remove('open');
            });
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('.custom-country-select').forEach(c => c.classList.remove('open'));
    });

    // Modal Handlers
    window.openEnquiryModal = function () {
        document.getElementById('enquiryModal').classList.add('active');
    };

    window.openBrochureModal = function () {
        document.getElementById('brochureModal').classList.add('active');
    };

    window.closeModals = function () {
        document.querySelectorAll('.modal-backdrop').forEach(m => m.classList.remove('active'));
    };

    // Form Submissions
    const enquiryForm = document.getElementById('enquiryForm');
    if (enquiryForm) {
        enquiryForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Thank you! Your site visit request has been submitted. Our team will get in touch with you shortly.');
            closeModals();
            enquiryForm.reset();
        });
    }

    const brochureForm = document.getElementById('brochureForm');
    if (brochureForm) {
        brochureForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Thank you! The E-Brochure download will begin shortly.');
            closeModals();
            brochureForm.reset();
        });
    }
});
