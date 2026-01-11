window.loadPage = function(page) {

    const xhr = new XMLHttpRequest();
    xhr.open("GET", `/sistem_parkir/Public/ajax/page.php?page=${page}`, true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                document.getElementById("app").innerHTML = xhr.responseText;

                // tandai sudah load
                document.getElementById('app').dataset.loaded = 'true';

                // update active sidebar link
                document.querySelectorAll('.sidebar-link, .mobile-link').forEach(link => {
                    link.classList.remove('active');
                    if (link.dataset.page === page) link.classList.add('active');
                });
            } else {
                document.getElementById("app").innerHTML =
                    "<div class='text-center text-red-400 py-10'>Gagal load halaman</div>";
            }
        }
    };

    xhr.send();
};

document.addEventListener("DOMContentLoaded", function() {
    // tandai kalau dashboard sudah langsung di-render
    document.getElementById('app').dataset.loaded = 'true';

    // Event delegation untuk sidebar dan mobile link
    document.addEventListener('click', function(e) {
        const link = e.target.closest('.sidebar-link, .mobile-link');
        if (!link) return;
        const page = link.dataset.page;
        if (!page) return;
        e.preventDefault();
        loadPage(page);
    });
});
