</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggleIcon = document.getElementById('toggleIcon');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');

    function toggleSidebar() {
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('show-mobile');
            sidebarBackdrop.classList.toggle('active');
        } else {
            sidebar.classList.toggle('hide');
            content.classList.toggle('full');
        }
    }

    toggleIcon.addEventListener('click', toggleSidebar);

    sidebarBackdrop.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
            sidebar.classList.remove('show-mobile');
            sidebarBackdrop.classList.remove('active');
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('show-mobile');
            sidebarBackdrop.classList.remove('active');
            sidebar.classList.remove('hide');
            content.classList.remove('full');
        }
    });
</script>
</body>

</html>