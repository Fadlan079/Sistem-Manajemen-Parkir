// helper: tunggu elemen tersedia sebelum callback
function waitForElement(selector, callback, interval = 50, timeout = 2000) {
    const start = Date.now();
    const timer = setInterval(() => {
        const el = document.querySelector(selector);
        if (el) {
            clearInterval(timer);
            callback(el);
        } else if (Date.now() - start > timeout) {
            clearInterval(timer);
            console.warn('waitForElement timeout:', selector);
        }
    }, interval);
}

// fungsi load page
window.loadPage = function(pageOrEvent, pageMaybe, callback) {
    let page, event;

    // cek apakah parameter pertama adalah event atau string
    if (pageOrEvent && pageOrEvent.preventDefault) {
        event = pageOrEvent;
        page = pageMaybe;
    } else {
        page = pageOrEvent;
        event = null;
    }

    if (event) event.preventDefault();

    const xhr = new XMLHttpRequest();
    xhr.open("GET", `ajax/page.php?page=${page}`, true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            const appEl = document.getElementById("app");
            if (xhr.status === 200) {
                appEl.innerHTML = xhr.responseText;

                // set active sidebar link
                document.querySelectorAll('.sidebar-link, .mobile-link').forEach(link => {
                    link.classList.remove('active');
                    if (link.dataset.page === page) link.classList.add('active');
                });

                // trigger callback setelah DOM inject
                if (typeof callback === 'function') {
                    callback();
                }
            } else {
                appEl.innerHTML = "<div class='text-center text-red-400 py-10'>Gagal load halaman</div>";
            }
        }
    };

    xhr.send();
};

// Event listener untuk klik sidebar / mobile
document.addEventListener("DOMContentLoaded", function() {
    document.addEventListener('click', function(e) {
        const link = e.target.closest('.sidebar-link, .mobile-link');
        if (!link) return;

        const page = link.dataset.page;
        if (!page) return;

        loadPage(e, page, () => {
            // kalau halaman dashboard, load default tab tiket
            if (page === 'dashboard') {
                waitForElement('#tab-tiket', (defaultTab) => {
                    loadTable('tiket', defaultTab);
                });
            }
        });
    });

    // initial load dashboard
    const app = document.getElementById('app');
    if (app && app.innerHTML.trim() === '') {
        loadPage('dashboard', () => {
            waitForElement('#tab-tiket', (defaultTab) => {
                loadTable('tiket', defaultTab);
            });
        });
    }
});


function openModal() {
    const modal = document.getElementById('globalModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    document.getElementById('globalModal').classList.add('hidden');
    document.getElementById('modalContent').innerHTML = '';
}

function openTambahTarif() {
    fetch('?action=tambah-tarif')
        .then(res => res.text())
        .then(html => {
            document.getElementById('modalContent').innerHTML = html;
            openModal();
        });
}

function openEditTarif(id) {
    fetch(`?action=edit-tarif&id=${id}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById('modalContent').innerHTML = html;
            openModal();
        });
}

document.addEventListener('submit', function (e) {
    const form = e.target;

    if (form.id === 'formTambahTarif') {
        e.preventDefault();

        fetch('?action=store-tambah-tarif', {
            method: 'POST',
            body: new FormData(form)
        })
        .then(res => res.json())
        .then(res => {
            showAlert(res.status,res.message);
            if (res.status) {
                closeModal();
                loadPage('manage-tarif');
            }
        })
        .catch(err => {
            console.error(err);
            showAlert('error', 'Terjadi kesalahan saat memproses data');
        });
    }
});

document.addEventListener('submit', function (e) {
    if (e.target && e.target.id === 'formEditTarif') {
        e.preventDefault();

        fetch('?action=store-edit-tarif', {
            method: 'POST',
            body: new FormData(e.target)
        })
        .then(res => res.json())
        .then(res => {
            showAlert(res.status, res.message);

            if (res.status) {
                closeModal();
                loadPage('manage-tarif');
            }
        })
        .catch(() => {
            showAlert('error', 'Terjadi kesalahan server');
        });
    }
});

function deleteTarif(id) {
    if (!confirm('Yakin ingin menghapus tarif ini?')) return;

    fetch(`?action=delete-tarif&id=${id}`, {
        method: 'GET'
    })
    .then(res => res.json())
    .then(res => {
        showAlert(res.status, res.msg);

        if (res.status === 'success') {
            loadPage('manage-tarif');
        }
    })
    .catch(() => {
        showAlert('error', 'Terjadi kesalahan server');
    });
}



function showAlert(type, message) {
    const styles = {
        success: 'bg-green-600/80 text-white border-green-700',
        error: 'bg-red-600/80 text-white border-red-700',
        warning: 'bg-yellow-500/80 text-white border-yellow-600',
        info: 'bg-blue-600/80 text-white border-blue-700',
    };

    const icons = {
        success: 'fa-circle-check',
        error: 'fa-circle-xmark',
        warning: 'fa-triangle-exclamation',
        info: 'fa-circle-info',
    };

    const style = styles[type] || styles.info;
    const icon  = icons[type] || icons.info;

    const alertEl = document.createElement('div');
    alertEl.className = `
        fixed z-300 top-20 left-1/2 transform -translate-x-1/2
        p-4 mb-5 border rounded-lg flex items-center shadow-lg
        backdrop-blur-sm opacity-0 -translate-y-12
        ${style}
    `;

    alertEl.innerHTML = `
        <i class="fa-solid ${icon} mr-2 text-xl"></i>
        <span class="font-medium">${message}</span>
    `;

    document.body.appendChild(alertEl);

    requestAnimationFrame(() => {
        alertEl.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        alertEl.style.opacity = '1';
        alertEl.style.transform = 'translate(-50%, 0)';
    });

    setTimeout(() => {
        alertEl.style.opacity = '0';
        alertEl.style.transform = 'translate(-50%, -50px)';
        setTimeout(() => alertEl.remove(), 500);
    }, 3000);
}
