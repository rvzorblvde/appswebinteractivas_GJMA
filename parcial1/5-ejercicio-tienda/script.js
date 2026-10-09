$(document).ready(function () {
    console.log('Landing page de tienda cargada (jQuery adaptado)');

    // modales Bootstrap
    const cartModal = new bootstrap.Modal(document.getElementById('carritoModal'));
    const subModal = new bootstrap.Modal(document.getElementById('suscripcionModal'));
    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));

    // ESTADO DEL CARRITO 
    let carrito = [];

    // renderizar y calcular el carrito
    function actualizarCarrito() {
        const $cartList = $('#cartItemsList');
        $cartList.empty();
        let total = 0;

        if (carrito.length === 0) {
            $cartList.html('<p class="text-muted text-center my-4">Tu carrito está vacío.</p>');
            $('#btnVaciarCarrito').hide();
        } else {
            $('#btnVaciarCarrito').show();
            carrito.forEach((item, index) => {
                total += item.price;
                $cartList.append(`
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div>
                            <h6 class="mb-0">${item.product}</h6>
                            <small class="text-muted">$${item.price.toFixed(2)}</small>
                        </div>
                        <button class="btn btn-sm btn-outline-danger btn-remove-item" data-index="${index}">Quitar</button>
                    </div>
                `);
            });
        }

        // sumar total y badge del navbar
        $('#cartTotalSum').text('$' + total.toFixed(2));
        $('#cartCount').text(carrito.length);
        
        // cambiar color del badge si hay items
        if(carrito.length > 0) {
            $('#cartCount').removeClass('bg-primary').addClass('bg-danger');
        } else {
            $('#cartCount').removeClass('bg-danger').addClass('bg-primary');
        }
    }

    // iniciar carrito
    actualizarCarrito();

    // añadir al carrito
    $('.btn-add-to-cart').on('click', function (e) {
        e.preventDefault();
        
        const product = $(this).data('product');
        const price = parseFloat($(this).data('price'));

        carrito.push({ product, price });
        actualizarCarrito();
        
        // Mostrar el modal del carrito directamente para confirmar
        cartModal.show();
    });

    // quitar un item del carrito
    $('#cartItemsList').on('click', '.btn-remove-item', function() {
        const index = $(this).data('index');
        carrito.splice(index, 1);
        actualizarCarrito();
    });

    // vaciar el carrito
    $('#btnVaciarCarrito').on('click', function() {
        carrito = [];
        actualizarCarrito();
    });


    // filtros y buscar
    function filtrarProductos() {
        const terminoBusqueda = $('#searchInput').val().toLowerCase();
        const categoriaActiva = $('.filter-buttons .active').data('filter');

        $('.product-item').each(function() {
            const titulo = $(this).find('.card-title').text().toLowerCase();
            const categoria = $(this).data('category');

            const coincideTexto = titulo.includes(terminoBusqueda);
            const coincideCategoria = (categoriaActiva === 'todos' || categoria === categoriaActiva);

            if (coincideTexto && coincideCategoria) {
                $(this).fadeIn(300);
            } else {
                $(this).hide();
            }
        });
    }

    // keyip event
    $('#searchInput').on('keyup', function() {
        filtrarProductos();
    });

    // evento de botones de categoría
    $('.filter-buttons .btn').on('click', function() {
        $('.filter-buttons .btn').removeClass('active');
        $(this).addClass('active');
        filtrarProductos();
    });


    // email suscribirse
    $('#btnSubscribe').on('click', function () {
        const email = $('#emailInput').val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email && emailRegex.test(email)) {
            $('#modalEmailSubscription').text(email);
            subModal.show();
            $('#emailInput').val('');
        } else {
            errorModal.show();
        }
    });

    // ease scroll
    $('a[href^="#"]').on('click', function (e) {
        const target = $($(this).attr('href'));

        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 70
            }, 600);
        }
    });
});