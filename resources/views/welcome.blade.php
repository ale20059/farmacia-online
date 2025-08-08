<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Catálogo | Pharma FDINOVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #1cc88a;
            --accent-color: #f6c23e;
            --light-bg: #f8f9fc;
            --dark-text: #5a5c69;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-text);
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color), #224abe);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
            background-color: #f1f8ff;
        }

        .no-image {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 200px;
            background-color: #f1f8ff;
            color: var(--primary-color);
        }

        .no-image i {
            font-size: 3rem;
        }

        .card-title {
            color: var(--primary-color);
            font-weight: 600;
        }

        .price {
            color: var(--secondary-color);
            font-weight: bold;
            font-size: 1.2rem;
        }

        .btn-login {
            background-color: var(--primary-color);
            border: none;
            border-radius: 50px;
            padding: 8px 0;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background-color: #3a5bc7;
            transform: translateY(-2px);
        }

        .badge-category {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: var(--accent-color);
            color: white;
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 0.8rem;
        }

        @media (max-width: 768px) {
            .card {
                margin-bottom: 1.5rem;
            }
        }

        .footer {
            background-color: white;
            padding: 2rem 0;
            margin-top: 3rem;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>
    <div class="header text-center">
        <div class="container">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Pharma FDINOVA"
                style="width: 120px; margin-bottom: 1rem;" />
            <h1 class="display-5 fw-bold mb-3">PHARMA FDINOVA</h1>
            <p class="lead">Productos de calidad para tu bienestar</p>
        </div>
    </div>

    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h2 class="h4 fw-bold text-uppercase" style="color: var(--primary-color);">
                <i class="fas fa-pills me-2"></i>Nuestro Catálogo
            </h2>
            <div class="d-flex align-items-center mt-2 mt-md-0">
                <input type="text" id="inputBuscar" class="form-control me-2" placeholder="Buscar productos..."
                    style="max-width: 250px;" />
                <button id="btnBuscar" class="btn btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="row" id="productosCatalogo">
            @foreach ($productos as $producto)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 producto-item">
                    <div class="card h-100">
                        @if ($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top"
                                alt="{{ $producto->nombre }}" />
                        @else
                            <div class="no-image">
                                <i class="fas fa-pills"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span
                                    class="badge bg-info text-white">{{ $producto->categoria ?? 'Medicamento' }}</span>
                            </div>
                            <h5 class="card-title nombre-producto">{{ $producto->nombre }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($producto->descripcion, 70) }}</p>

                            <div class="mt-auto">
                                <p class="price mb-3">Q{{ number_format($producto->precio, 2) }}</p>
                                <form action="{{ route('cliente.login') }}" method="GET">
                                    <button class="btn btn-login text-white w-100">
                                        <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>

    <div class="footer">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold mb-3" style="color: var(--primary-color);">Contacto</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i>Av. 5, Zona 1, Calle principal, Santo
                        Tomás Milpas Altas</p>
                    <p><i class="fas fa-phone me-2"></i> (502) 46586316</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold mb-3" style="color: var(--primary-color);">Horario</h5>
                    <p>Lunes a Viernes: 8:00 - 20:00</p>
                    <p>Sábado y Domingo: 9:00 - 18:00</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold mb-3" style="color: var(--primary-color);">Síguenos</h5>
                    <a href="https://www.facebook.com" class="text-decoration-none me-3"><i
                            class="fab fa-facebook-f fa-lg" style="color: var(--primary-color);"></i></a>
                    <a href="https://www.instagram.com" class="text-decoration-none me-3"><i
                            class="fab fa-instagram fa-lg" style="color: var(--primary-color);"></i></a>
                    <a href="https://wa.me/50246586316" class="text-decoration-none"><i class="fab fa-whatsapp fa-lg"
                            style="color: var(--primary-color);"></i></a>
                </div>
            </div>
            <hr />
            <p class="mb-0 text-muted small">© 2023 Pharma FDINOVA. Todos los derechos reservados.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const inputBuscar = document.getElementById("inputBuscar");
            const productos = document.querySelectorAll(".producto-item");

            inputBuscar.addEventListener("input", () => {
                const textoBusqueda = inputBuscar.value.toLowerCase().trim();

                productos.forEach(producto => {
                    const nombre = producto.querySelector(".nombre-producto").textContent
                        .toLowerCase();
                    if (nombre.includes(textoBusqueda)) {
                        producto.style.display = "block";
                    } else {
                        producto.style.display = "none";
                    }
                });
            });
        });
    </script>
</body>

</html>
