document.addEventListener("DOMContentLoaded", function () {
    const itemsPerPage = 8; // Jumlah item per halaman
    const productItems = document.querySelectorAll(".product-item");
    const paginationContainer = document.querySelector(".pagination");

    function showPage(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        productItems.forEach((item, index) => {
            if (index >= start && index < end) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    }

    function setupPagination() {
        const pageCount = Math.ceil(productItems.length / itemsPerPage);
        paginationContainer.innerHTML = "";

        for (let i = 1; i <= pageCount; i++) {
            const li = document.createElement("li");
            li.classList.add("page-item");
            li.innerHTML = `<a href="#" class="page-link">${i}</a>`;
            li.addEventListener("click", function (e) {
                e.preventDefault();
                showPage(i);
                document
                    .querySelectorAll(".page-item")
                    .forEach((item) => item.classList.remove("active"));
                li.classList.add("active");
            });
            paginationContainer.appendChild(li);
        }

        // Set the first page as active
        if (paginationContainer.firstChild) {
            paginationContainer.firstChild.classList.add("active");
        }
    }

    // Initialize pagination
    setupPagination();
    showPage(1);
});
