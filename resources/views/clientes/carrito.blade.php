@extends('layouts.cliente')

@section('title', 'Tu Carrito')

@section('content')
    <div class="container py-4">
        <h2 class="text-center mb-4 fw-bold text-primary">
            <i class="fas fa-shopping-cart me-2"></i>Tu Carrito
        </h2>

        <!-- Alertas -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show text-center">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($items->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                <h4 class="text-muted">Tu carrito está vacío</h4>
                <a href="{{ route('cliente.tienda') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-store me-2"></i>Ir a la tienda
                </a>
            </div>
        @else
            <!-- Tabla de productos (Desktop) -->
            <div class="d-none d-md-block">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio</th>
                                <th class="text-end">Subtotal</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->producto->nombre }}</td>
                                    <td class="text-center">{{ $item->cantidad }}</td>
                                    <td class="text-end">Q{{ number_format($item->producto->precio, 2) }}</td>
                                    <td class="text-end">Q{{ number_format($item->producto->precio * $item->cantidad, 2) }}
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('cliente.carrito.eliminar', $item) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('¿Eliminar este producto del carrito?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <th class="text-end text-primary">Q{{ number_format($total, 2) }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Lista de productos (Mobile) -->
            <div class="d-md-none">
                @foreach ($items as $item)
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title mb-1">{{ $item->producto->nombre }}</h5>
                                <form action="{{ route('cliente.carrito.eliminar', $item) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Eliminar este producto del carrito?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <span class="text-muted">Cantidad:</span>
                                    <span class="fw-bold">{{ $item->cantidad }}</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="text-muted">Precio:</span>
                                    <span class="fw-bold">Q{{ number_format($item->producto->precio, 2) }}</span>
                                </div>
                            </div>
                            <div class="mt-2 text-end">
                                <span class="text-muted">Subtotal:</span>
                                <span class="fw-bold text-primary">
                                    Q{{ number_format($item->producto->precio * $item->cantidad, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="card mt-3 bg-light">
                    <div class="card-body text-center">
                        <h5 class="mb-0">
                            <span class="text-muted me-2">Total:</span>
                            <span class="fw-bold text-primary">Q{{ number_format($total, 2) }}</span>
                        </h5>
                    </div>
                </div>
            </div>

            <!-- Formulario de pago -->
            <div class="card shadow mt-4">
                <div class="card-body">
                    <h4 class="text-center mb-4">
                        <i class="fas fa-credit-card me-2"></i>Información de Pago
                    </h4>

                    <!-- Vista previa de tarjeta -->
                    <div class="card mb-4 border-primary">
                        <div class="card-body bg-light">
                            <div class="d-flex justify-content-between mb-3">
                                <i id="card-icon-preview" class="fab fa-cc-visa fa-2x text-primary"></i>
                                <span id="card-type-preview" class="badge bg-primary">VISA</span>
                            </div>
                            <div id="card-number-preview" class="h5 mb-4 font-monospace">•••• •••• •••• ••••</div>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Expiración</small>
                                    <div id="card-expiry-preview" class="font-monospace">••/••</div>
                                </div>
                                <div class="col-6 text-end">
                                    <small class="text-muted">CVV</small>
                                    <div id="card-cvv-preview" class="font-monospace">•••</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="payment-form" method="POST" action="{{ route('cliente.carrito.checkout') }}">
                        @csrf

                        <!-- Campo oculto para los datos reales -->
                        <input type="hidden" name="card_number" id="real-card-number">
                        <input type="hidden" name="expiry_date" id="real-expiry">
                        <input type="hidden" name="cvv" id="real-cvv">

                        <!-- Número de tarjeta -->
                        <div class="mb-3">
                            <label for="card-number-input" class="form-label">Número de tarjeta</label>
                            <input type="text" id="card-number-input" class="form-control"
                                placeholder="1234 5678 9012 3456" maxlength="19">
                            <small class="text-muted">Ej: 4111 1111 1111 1111 para pruebas</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="expiry-input" class="form-label">Fecha de expiración (MM/AA)</label>
                                <input type="text" id="expiry-input" class="form-control" placeholder="MM/AA"
                                    maxlength="5">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cvv-input" class="form-label">Código de seguridad (CVV)</label>
                                <input type="password" id="cvv-input" class="form-control" placeholder="123"
                                    maxlength="4">
                            </div>
                        </div>

                        <button id="submit-btn" type="submit" class="btn btn-primary w-100 py-2 fw-bold" disabled>
                            <i class="fas fa-check-circle me-2"></i>Confirmar Pedido
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementos del DOM
            const cardNumberInput = document.getElementById('card-number-input');
            const expiryInput = document.getElementById('expiry-input');
            const cvvInput = document.getElementById('cvv-input');
            const submitBtn = document.getElementById('submit-btn');

            // Elementos de vista previa
            const cardNumberPreview = document.getElementById('card-number-preview');
            const cardExpiryPreview = document.getElementById('card-expiry-preview');
            const cardCvvPreview = document.getElementById('card-cvv-preview');
            const cardTypePreview = document.getElementById('card-type-preview');
            const cardIconPreview = document.getElementById('card-icon-preview');

            // Campos ocultos para el formulario real
            const realCardNumber = document.getElementById('real-card-number');
            const realExpiry = document.getElementById('real-expiry');
            const realCvv = document.getElementById('real-cvv');

            // Tipos de tarjeta
            const cardTypes = {
                visa: {
                    pattern: /^4[0-9]{12}(?:[0-9]{3})?$/,
                    icon: 'fa-cc-visa',
                    name: 'VISA'
                },
                mastercard: {
                    pattern: /^5[1-5][0-9]{14}$/,
                    icon: 'fa-cc-mastercard',
                    name: 'MASTERCARD'
                },
                amex: {
                    pattern: /^3[47][0-9]{13}$/,
                    icon: 'fa-cc-amex',
                    name: 'AMEX'
                },
                diners: {
                    pattern: /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/,
                    icon: 'fa-cc-diners-club',
                    name: 'DINERS'
                },
                discover: {
                    pattern: /^6(?:011|5[0-9]{2})[0-9]{12}$/,
                    icon: 'fa-cc-discover',
                    name: 'DISCOVER'
                },
                jcb: {
                    pattern: /^(?:2131|1800|35\d{3})\d{11}$/,
                    icon: 'fa-cc-jcb',
                    name: 'JCB'
                }
            };

            // Formatear número de tarjeta
            function formatCardNumber(number) {
                return number.replace(/\s+/g, '').replace(/(\d{4})/g, '$1 ').trim();
            }

            // Formatear fecha de expiración
            function formatExpiry(expiry) {
                return expiry.replace(/^(\d{2})/, '$1/');
            }

            // Detectar tipo de tarjeta
            function detectCardType(number) {
                const cleanNumber = number.replace(/\s+/g, '');

                for (const [type, data] of Object.entries(cardTypes)) {
                    if (data.pattern.test(cleanNumber)) {
                        return data;
                    }
                }

                return {
                    icon: 'fa-credit-card',
                    name: 'TARJETA'
                };
            }

            // Validar número de tarjeta con algoritmo de Luhn
            function validateCardNumber(number) {
                const cleanNumber = number.replace(/\s+/g, '');

                // Verificar longitud básica
                if (!/^\d{13,19}$/.test(cleanNumber)) return false;

                // Algoritmo de Luhn
                let sum = 0;
                for (let i = 0; i < cleanNumber.length; i++) {
                    let digit = parseInt(cleanNumber.charAt(i));

                    if ((cleanNumber.length - i) % 2 === 0) {
                        digit *= 2;
                        if (digit > 9) digit -= 9;
                    }

                    sum += digit;
                }

                return sum % 10 === 0;
            }

            // Validar fecha de expiración
            function validateExpiry(expiry) {
                if (!/^\d{2}\/\d{2}$/.test(expiry)) return false;

                const [month, year] = expiry.split('/');
                const expiryMonth = parseInt(month, 10);
                const expiryYear = 2000 + parseInt(year, 10);

                if (expiryMonth < 1 || expiryMonth > 12) return false;

                const currentDate = new Date();
                const currentYear = currentDate.getFullYear();
                const currentMonth = currentDate.getMonth() + 1;

                if (expiryYear < currentYear) return false;
                if (expiryYear === currentYear && expiryMonth < currentMonth) return false;

                return true;
            }

            // Validar CVV
            function validateCVV(cvv, cardNumber) {
                if (!/^\d{3,4}$/.test(cvv)) return false;

                const cleanCardNumber = cardNumber.replace(/\s+/g, '');
                const cardType = detectCardType(cleanCardNumber).name;

                // AMEX tiene 4 dígitos, otros 3
                return cardType === 'AMEX' ? cvv.length === 4 : cvv.length === 3;
            }

            // Actualizar vista previa
            function updatePreview() {
                const cardNumber = cardNumberInput.value || '•••• •••• •••• ••••';
                const expiry = expiryInput.value || '••/••';
                const cvv = cvvInput.value || '•••';

                // Actualizar vista previa
                cardNumberPreview.textContent = formatCardNumber(cardNumber);
                cardExpiryPreview.textContent = formatExpiry(expiry);
                cardCvvPreview.textContent = cvv;

                // Actualizar tipo de tarjeta e icono
                const cardType = detectCardType(cardNumber);
                cardTypePreview.textContent = cardType.name;
                cardIconPreview.className = `fab ${cardType.icon} fa-2x text-primary`;

                // Actualizar campos ocultos con datos limpios
                realCardNumber.value = cardNumber.replace(/\s+/g, '');
                realExpiry.value = expiry.replace(/\//g, '');
                realCvv.value = cvv;
            }

            // Validar todo el formulario
            function validateForm() {
                const isCardValid = validateCardNumber(cardNumberInput.value);
                const isExpiryValid = validateExpiry(expiryInput.value);
                const isCvvValid = validateCVV(cvvInput.value, cardNumberInput.value);

                submitBtn.disabled = !(isCardValid && isExpiryValid && isCvvValid);
            }

            // Event listeners
            cardNumberInput.addEventListener('input', function(e) {
                // Formatear automáticamente
                let value = e.target.value.replace(/\D/g, '');
                value = value.substring(0, 16);
                value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
                e.target.value = value.trim();

                updatePreview();
                validateForm();
            });

            expiryInput.addEventListener('input', function(e) {
                // Formatear automáticamente MM/AA
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                e.target.value = value;

                updatePreview();
                validateForm();
            });

            cvvInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
                updatePreview();
                validateForm();
            });

            // Validar al cargar la página
            updatePreview();
            validateForm();
        });
    </script>
@endsection
