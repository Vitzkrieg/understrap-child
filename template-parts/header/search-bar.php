<script id="ihk-header-search-bar">
    function update_header_search_bar(data = []) {
        const { loggedin, title, icon, account_link, cart_count } = data;

        const containers = document.querySelectorAll('.account-link');
        containers.forEach(container => {
            const link = container.querySelector('a');
            const icon_el = link.querySelector('i');
            const logclass      = (loggedin) ? 'logged-in' : 'logged-out';
            container.classList.add(logclass);
            link.setAttribute('href', account_link);
            link.setAttribute('title', title);
            icon.split(' ').forEach(icon => {
                icon_el.classList.add(icon);
            });

        });

        if (cart_count) {
            const cart_els = document.querySelectorAll('.cart-contents-count');
            cart_els.forEach(cart_el => {
                cart_el.classList.add('has-count');
                cart_el.textContent = cart_count;
            });
        }
    }

    const bodyData = new FormData();
    bodyData.append( 'action', 'ihk_account_status' );


    fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
        method: 'POST',
        credentials: 'same-origin',
        body: bodyData,
    })
    .then((response) => {
        return response.json();
    })
    .then((response) => {
        if (response?.success) {
            update_header_search_bar(response.data);
        }
    })
    .catch((error) => {
        console.log(error)
    });
</script>