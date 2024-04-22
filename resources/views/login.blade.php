<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Login | Prima Vision Eye Hospital</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Prima Vision Eye Hospital" name="description" />
  <meta content="Prima Vision Eye Hospital" name="author" />
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
  <link href="{{ asset('css/login/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/login/icons.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/login/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body data-topbar="dark">
  <div class="auth-page">
    <div class="container-fluid p-0">
      <div class="row g-0">
        <div class="col-xxl-4 col-lg-4 col-md-5">
          <div class="auth-full-page-content d-flex p-sm-5 p-4">
            <div class="w-100">
              <div class="d-flex flex-column h-100">
                <div class="mb-4 mb-md-5 text-center">
                  <a href="index.html" class="d-block auth-logo">
                    <img src="{{ asset('images/logopanjang.png') }}" alt="" height="100">
                  </a>
                </div>
                <div class="auth-content my-auto">
                  <div class="text-center">
                    <h5 class="mb-0">SISTEM RUMAH SAKIT</h5>
                    <p class="text-muted mt-2">Rumah Sakit Khusus Mata PRIMA VISION.</p>
                    @if (count($errors))
                      <div class="alert alert-danger alert-dismissible fade show" style="text-align: left"
                        role="alert">
                        {{ $errors->first('wrong') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    @endif
                  </div>
                  <form class="mt-4 pt-2" action="{{ url('periksa/masuk') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-floating form-floating-custom mb-4">
                      <input type="text" class="form-control" name="username" id="input-username"
                        placeholder="Enter User Name" autocomplete="off">
                      <label for="input-username">Username</label>
                      <div class="form-floating-icon">
                        <i data-feather="users"></i>
                      </div>
                    </div>

                    <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                      <input type="password" name="password" class="form-control pe-5" id="password-input"
                        placeholder="Enter Password">

                      <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0"
                        id="password-addon">
                        <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                      </button>
                      <label for="password-input">Password</label>
                      <div class="form-floating-icon">
                        <i data-feather="lock"></i>
                      </div>
                    </div>

                    <div class="row mb-4">
                      <div class="col">
                        <div class="form-check font-size-15">
                          <input class="form-check-input" type="checkbox" id="remember-check">
                          <label class="form-check-label font-size-13" for="remember-check">
                            Remember me
                          </label>
                        </div>
                      </div>

                    </div>
                    <div class="mb-3">
                      <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log In</button>
                    </div>
                  </form>
                </div>
                <div class="mt-4 mt-md-5 text-center">
                  <p class="mb-0">©
                    <script>
                      document.write(new Date().getFullYear())
                    </script> Prima Vision Eye Hospitals
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-8 col-lg-8 col-md-7">
          <div class="auth-bg pt-md-5 p-4 d-flex">
            <div class="bg-overlay"></div>
            <ul class="bg-bubbles">
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
            </ul>
            <div class="row justify-content-center align-items-end">
              <div class="col-xl-7">
                <div class="p-0 p-sm-4 px-xl-0">
                  <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">

                    <!-- end carouselIndicators -->
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <div class="testi-contain text-center text-white">
                          <i class="bx bxs-quote-alt-left text-success display-6"></i>
                          <h4 class="mt-4 fw-medium lh-base text-white">“Kesehatan adalah kekayaan terbesar yang
                            memberikan nikmat kebahagiaan dan nikmat kebugaran di sepanjang hari.”
                          </h4>
                          <div class="mt-4 pt-1 pb-5 mb-5">
                            <h5 class="font-size-16 text-white">- Djajendra
                            </h5>
                          </div>
                        </div>
                      </div>

                      <div class="carousel-item">
                        <div class="testi-contain text-center text-white">
                          <i class="bx bxs-quote-alt-left text-success display-6"></i>
                          <h4 class="mt-4 fw-medium lh-base text-white">“Gaya hidup sehat bukanlah barang yang bisa
                            dibeli, tapi kebiasaan yang harus Anda lakukan secara rutin.”</h4>
                          <div class="mt-4 pt-1 pb-5 mb-5">
                            <h5 class="font-size-16 text-white">- Denny Santoso
                            </h5>
                          </div>
                        </div>
                      </div>

                      <div class="carousel-item">
                        <div class="testi-contain text-center text-white">
                          <i class="bx bxs-quote-alt-left text-success display-6"></i>
                          <h4 class="mt-4 fw-medium lh-base text-white">“Kesehatan adalah dasar dari semua nikmat
                            Tuhan, yang tanpanya semua nikmat menjadi kurang utuh.”</h4>
                          <div class="mt-4 pt-1 pb-5 mb-5">
                            <h5 class="font-size-16 text-white">- Mario Teguh</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/login/jquery.min.js') }}"></script>
  <script src="{{ asset('js/login/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/login/metisMenu.min.js') }}"></script>
  <script src="{{ asset('js/login/simplebar.min.js') }}"></script>
  <script src="{{ asset('js/login/waves.min.js') }}"></script>
  <script src="{{ asset('js/login/feather.min.js') }}"></script>
  <script src="{{ asset('js/login/pace.min.js') }}"></script>
  <script src="{{ asset('js/login/pass-addon.init.js') }}"></script>
  <script src="{{ asset('js/login/feather-icon.init.js') }}"></script>

</body>

</html>
