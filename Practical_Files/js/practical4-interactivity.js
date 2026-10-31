
/**
 * StudentHub JavaScript - Practical 4
 * Theme, notification banner, FAQ, modal,
 * slider, navigation and events.
 */

document.addEventListener("DOMContentLoaded", function () {
    highlightActiveNavLink();
    enableSmoothScrolling();
    renderDynamicGreeting();

    initThemeSwitcher();
    initNotificationBanner();
    initCollapsibleFAQ();
    initModalPopup();
    initContentSlider();
    initHamburgerMenu();
    initEvents();
});

// 1. Theme Switcher

function initThemeSwitcher() {
    const savedTheme = localStorage.getItem("studenthub_theme");
    const isDark = savedTheme === "dark";

    document.documentElement.setAttribute(
        "data-theme",
        isDark ? "dark" : "light"
    );

    document.body.classList.toggle("dark-theme", isDark);
    updateThemeToggleIcons(isDark);

    document.addEventListener("click", function (e) {
        const button = e.target.closest(".theme-toggle-btn");
        if (!button) return;

        const dark = !document.body.classList.contains("dark-theme");

        document.body.classList.toggle("dark-theme", dark);
        document.documentElement.setAttribute(
            "data-theme",
            dark ? "dark" : "light"
        );

        localStorage.setItem(
            "studenthub_theme",
            dark ? "dark" : "light"
        );

        updateThemeToggleIcons(dark);
    });
}

function updateThemeToggleIcons(isDark) {
    document.querySelectorAll(".theme-toggle-btn").forEach(function (btn) {
        btn.innerHTML = isDark
            ? '☀️ <span class="d-none d-md-inline ms-1">Light</span>'
            : '🌙 <span class="d-none d-md-inline ms-1">Dark</span>';

        btn.setAttribute(
            "aria-label",
            isDark ? "Switch to Light Mode" : "Switch to Dark Mode"
        );
    });
}

// 2. Dismissible Notification Banner

function initNotificationBanner() {
    const banners = document.querySelectorAll(".notification-banner");

    banners.forEach(function (banner) {
        const closeButton = banner.querySelector(".banner-close-btn");

        if (!closeButton) return;

        closeButton.addEventListener("click", function (e) {
            e.preventDefault();
            hideBanner(banner);
        });
    });
}

function hideBanner(banner) {
    banner.classList.add("hidden");
    banner.style.display = "none";
    banner.setAttribute("aria-hidden", "true");
}

// 3. Collapsible FAQ

function initCollapsibleFAQ() {
    const headers = document.querySelectorAll(".faq-header");

    headers.forEach(function (header) {
        header.addEventListener("click", function () {
            const item = header.closest(".faq-item") || header.parentElement;
            const wasOpen = item.classList.contains("active");

            document.querySelectorAll(".faq-item").forEach(function (faq) {
                faq.classList.remove("active");

                const button = faq.querySelector(".faq-header");

                if (button) {
                    button.setAttribute("aria-expanded", "false");
                }
            });

            if (!wasOpen) {
                item.classList.add("active");
                header.setAttribute("aria-expanded", "true");
            }
        });
    });
}

// 4. Modal Popup

function initModalPopup() {
    document.addEventListener("click", function (e) {
        const trigger = e.target.closest("[data-modal-target]");

        if (trigger) {
            e.preventDefault();

            const targetId = trigger.getAttribute("data-modal-target");
            const modal = document.querySelector(targetId);

            if (modal) {
                modal.classList.add("active");
                modal.setAttribute("aria-hidden", "false");
            }

            return;
        }

        const closeButton = e.target.closest("[data-modal-close]");

        if (closeButton) {
            e.preventDefault();

            const modal = closeButton.closest(".custom-modal");

            if (modal) {
                closeModal(modal);
            }

            return;
        }

        if (e.target.classList.contains("custom-modal")) {
            closeModal(e.target);
        }
    });

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            const modal = document.querySelector(".custom-modal.active");

            if (modal) {
                closeModal(modal);
            }
        }
    });
}

function closeModal(modal) {
    modal.classList.remove("active");
    modal.setAttribute("aria-hidden", "true");
}

// 5. Content Slider

function initContentSlider() {
    const container = document.querySelector(".slider-container");

    if (!container) return;

    const track = container.querySelector(".slider-track");
    const slides = container.querySelectorAll(".slide-item");
    const previous = container.querySelector(".slider-btn-prev");
    const next = container.querySelector(".slider-btn-next");

    if (!track || slides.length === 0) return;

    let currentIndex = 0;

    function updateSlider() {
        track.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    if (next) {
        next.addEventListener("click", function () {
            currentIndex = (currentIndex + 1) % slides.length;
            updateSlider();
        });
    }

    if (previous) {
        previous.addEventListener("click", function () {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            updateSlider();
        });
    }
}

// 6. Responsive Hamburger Menu

function initHamburgerMenu() {
    // Bootstrap handles navigation toggling when loaded.
    if (window.bootstrap && window.bootstrap.Collapse) {
        return;
    }

    document.querySelectorAll(".navbar-toggler").forEach(function (toggle) {
        toggle.addEventListener("click", function () {
            const selector = toggle.getAttribute("data-bs-target");
            const targetId = toggle.getAttribute("aria-controls");

            const menu = selector
                ? document.querySelector(selector)
                : document.getElementById(targetId);

            if (!menu) return;

            menu.classList.toggle("show");

            toggle.setAttribute(
                "aria-expanded",
                String(menu.classList.contains("show"))
            );
        });
    });
}

// 7. Highlight Active Navigation Link

function highlightActiveNavLink() {
    const currentPath =
        window.location.pathname.split("/").pop() || "home.php";

    document.querySelectorAll(".navbar-nav .nav-link").forEach(function (link) {
        const href = link.getAttribute("href");

        if (!href) return;

        const linkPath = href.split("?")[0].split("#")[0];

        if (linkPath === currentPath) {
            link.classList.add("active");
            link.setAttribute("aria-current", "page");
        } else {
            link.classList.remove("active");
            link.removeAttribute("aria-current");
        }
    });
}

// 8. Smooth Scrolling

function enableSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener("click", function (e) {
            const targetId = anchor.getAttribute("href");

            if (!targetId || targetId === "#") return;

            const target = document.getElementById(targetId.substring(1));

            if (target) {
                e.preventDefault();

                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }
        });
    });
}

// 9. Dynamic Greeting

function renderDynamicGreeting() {
    const heroTitle = document.querySelector("section h1");

    if (!heroTitle) return;

    const hour = new Date().getHours();
    let greeting = "Welcome";

    if (hour < 12) {
        greeting = "Good Morning";
    } else if (hour < 18) {
        greeting = "Good Afternoon";
    } else {
        greeting = "Good Evening";
    }

    console.log(
        `[StudentHub Log]: ${greeting}! Practical 4 UI Loaded successfully.`
    );
}

// 10. Events Fetch, Search, Filter and Pagination

let events = [];
let page = 1;
let perPage = 5;

function initEvents() {
    const table = document.getElementById("eventTableBody");

    // Only initialize on pages containing the events table.
    if (!table) return;

    fetch("events.json")
        .then(function (response) {
            if (!response.ok) {
                throw new Error("Unable to load events");
            }

            return response.json();
        })
        .then(function (data) {
            events = Array.isArray(data) ? data : [];
            displayEvents();
        })
        .catch(function (error) {
            console.error("Events loading error:", error);

            table.innerHTML =
                "<tr><td colspan='4' class='text-center text-danger'>" +
                "Error loading events</td></tr>";
        });

    const search = document.getElementById("search");
    const category = document.getElementById("category");

    if (search) {
        search.addEventListener("input", function () {
            page = 1;
            displayEvents();
        });
    }

    if (category) {
        category.addEventListener("change", function () {
            page = 1;
            displayEvents();
        });
    }
}

function displayEvents() {
    const table = document.getElementById("eventTableBody");

    if (!table) return;

    const searchInput = document.getElementById("search");
    const categoryInput = document.getElementById("category");

    const searchText = searchInput
        ? searchInput.value.toLowerCase()
        : "";

    const category = categoryInput
        ? categoryInput.value
        : "All";

    let result = events.filter(function (event) {
        return String(event.name || "")
            .toLowerCase()
            .includes(searchText);
    });

    if (category !== "All") {
        result = result.filter(function (event) {
            return event.category === category;
        });
    }

    const totalPages = Math.max(1, Math.ceil(result.length / perPage));

    page = Math.min(Math.max(1, page), totalPages);

    const start = (page - 1) * perPage;
    const pageData = result.slice(start, start + perPage);

    let output = "";

    pageData.forEach(function (event) {
        output +=
            "<tr>" +
            "<td class='fw-bold text-navy'>" +
            "<i class='bi bi-calendar-event text-accent me-2'></i>" +
            escapeHTML(event.name) +
            "</td>" +
            "<td>" + escapeHTML(event.category) + "</td>" +
            "<td>" +
            "<span class='badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1'>" +
            escapeHTML(event.date) +
            "</span>" +
            "</td>" +
            "<td class='text-end'>" +
            "<button type='button' class='btn btn-sm btn-accent' data-modal-target='#eventModal'>" +
            "Register" +
            "</button>" +
            "</td>" +
            "</tr>";
    });

    if (pageData.length === 0) {
        output =
            "<tr><td colspan='4' class='text-center'>" +
            "No events found</td></tr>";
    }

    table.innerHTML = output;
}

function escapeHTML(value) {
    return String(value == null ? "" : value)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#39;");
}

function sortEvents() {
    events.sort(function (a, b) {
        return String(a.name || "").localeCompare(
            String(b.name || "")
        );
    });

    page = 1;
    displayEvents();
}

function nextPage() {
    page++;
    displayEvents();
}

function previousPage() {
    if (page > 1) {
        page--;
        displayEvents();
    }
}
