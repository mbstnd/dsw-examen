<!doctype html>

<html
  lang="es"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Registro - Sistema de Usuarios</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->

    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />

    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />

    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="../../assets/vendor/libs/@form-validation/form-validation.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="../../assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>
    <!-- Config -->
    <script src="../../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6">
          <!-- Register Card -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center mb-6">
                <a href="index.html" class="app-brand-link">
                  <span class="app-brand-logo demo">
                    <!-- Aquí puedes colocar el logo de tu sistema -->
                  </span>
                  <span class="app-brand-text demo text-heading fw-bold">Sistema</span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-1">¡Empieza tu aventura aquí! 🚀</h4>
              <p class="mb-6">Gestiona tu cuenta de manera fácil y rápida.</p>
              @if ($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
              <form id="formRegistro" class="mb-6" action="{{ route('usuario.registrar') }}" method="POST">
                @csrf
                <div class="mb-6">
                  <label for="nombre" class="form-label">Nombre</label>
                  <input
                    type="text"
                    class="form-control"
                    id="nombre"
                    name="nombre"
                    placeholder="Introduce tu nombre"
                    required />
                </div>
                <div class="mb-6">
                  <label for="apellido" class="form-label">Apellido</label>
                  <input
                    type="text"
                    class="form-control"
                    id="apellido"
                    name="apellido"
                    placeholder="Introduce tu apellido"
                    required />
                </div>
                <div class="mb-6">
                  <label for="email" class="form-label">Correo Electrónico</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Introduce tu correo electrónico"
                    required />
                </div>
                <div class="mb-6 form-password-toggle">
                  <label class="form-label" for="password">Contraseña</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="••••••••••••"
                      required />
                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                  </div>
                </div>
                <div class="mb-6 form-password-toggle">
                    <label class="form-label" for="rePassword">Confirmar Contraseña</label>
                    <div class="input-group input-group-merge">
                      <input
                        type="password"
                        id="rePassword"
                        class="form-control"
                        name="password_confirmation"
                        placeholder="••••••••••••"
                        required />
                      <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                    </div>
                  </div>


                <div class="my-8">
                  <div class="form-check mb-0 ms-2">
                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required />
                    <label class="form-check-label" for="terms-conditions">
                      Acepto la
                      <a href="javascript:void(0);">política de privacidad y los términos</a>
                    </label>
                  </div>
                </div>
                <button class="btn btn-primary d-grid w-100" type="submit" >Registrarse</button>
              </form>

              <p class="text-center">
                <span>¿Ya tienes una cuenta?</span>
                <a href="{{ route('usuario.login') }}">
                  <span>Inicia sesión</span>
                </a>
              </p>
            </div>
          </div>
          <!-- Register Card -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../../assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="../../assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../../assets/js/pages-auth.js"></script>
  </body>
</html>
