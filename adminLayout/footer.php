</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jquery cdn link -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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

    // Add smooth animations to page elements
    document.addEventListener('DOMContentLoaded', function() {
        // Animate cards on load
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Add hover effects to table rows
        const tableRows = document.querySelectorAll('.table tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.01)';
            });
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    });

    let deleteUser = $(".deleteUser");
    let deleteBtn = $("#deleteBtn");
    let closeBtn = $("#closeBtn");
    let deleteKey = null;
    deleteUser.on("click", function(e) {
        deleteKey = e.currentTarget.getAttribute("data-value");
        // console.log("Value of deleteKey from deleteUser click:", deleteKey);
        key = deleteKey;
    })
    deleteBtn.on("click", () => {
        // console.log("Value of deleteKey in deleteBtn click:", deleteKey);
        if (key == deleteKey) {
            location.replace("?deleteId=" + key);
            closeBtn.click();
        } else {
            location.replace("?deleteError=" + deleteKey);
            closeBtn.click();
        }
    });
</script>
</body>

</html>