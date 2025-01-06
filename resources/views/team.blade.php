<!DOCTYPE html>
<html lang="en">

<head>
  
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>CoLink</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Favicons -->
  <link href="{{ asset('images/colinklogo.png') }}" rel="icon">
  <link href="{{ asset('images/colinklogo.png') }}" rel="apple-touch-icon">
  

    <!-- Preconnect for fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- CDN Fonts -->
    <link href="https://fonts.cdnfonts.com/css/andasia" rel="stylesheet">
<!-- Bootstrap CSS -->
<link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

<!-- Bootstrap JS Bundle -->
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">


  <!-- Template Main CSS File -->
 
  @vite('resources/css/main.css')
  @vite('resources/js/app.js')

  
</head>
<body>

  <!-- ======= Header ======= -->
  <section id="topbar" class="topbar d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
            <i class="bi bi-envelope d-flex align-items-center">
            <a href="mailto:contact@example.com">colinkofficial@gmail.com</a></i>
            <i class="bi bi-phone d-flex align-items-center ms-4">
            <span>09669950377</span></i>
        </div>
       
        <div class="social-links d-none d-md-flex align-items-center">
          <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="instagram"><i class="bi bi-instagram"></i></i></a>
      </div>
    </div>
    
</section><!-- End Top Bar -->


<header id="header" class="header d-flex align-items-center">

<div class="container-fluid container-xl d-flex align-items-center justify-content-between">
  <a href="index.html" class="logo d-flex align-items-center">
   
    <img src="{{ asset('images/CoLink Logo White.png')}}" alt="">
    
  </a>
  <nav id="navbar" class="navbar">
<ul>
    <li class="active"><a href="{{ url('/') }}">Home</a></li>
    <li class="dropdown"><a href="{{ url('/team') }}"><span>Our Community</span></a></li>

    <li class="dropdown"><a href="{{ url('/blog') }}"><span>Our Work</span></a>
        <ul>
            <li><a href="{{ url('/services') }}">>> Services</a></li>
            <li><a href="{{ url('/interventions') }}">>> Interventions</a></li>
        </ul>
    </li>
    <li><a href="{{ url('/impact') }}">Our Impact</a></li>
    <li><a href="{{ url('/contact') }}">Get Involved</a></li>
    @auth
        <div class="flex items-center space-x-4">
    <!-- Bell Icon (Notification) -->
    <button class="p-1 rounded-full text-yellow-400 hover:text-yellow -500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
    </button>

    <!-- Avatar and Dropdown -->
    <div>
    <button class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="user-menu" aria-haspopup="true">
        {{-- Replace with the user's avatar --}}
        <img class="h-8 w-8 rounded-full object-cover" 
             src="{{ auth()->user()->avatar_url ?? asset('images/profile-icon2.png') }}" 
             alt="User Avatar"
             style="width: 15%; height: 20%; object-fit: cover;">
    </button>
</div>
    </div>

    
@else
    {{-- Login Button with Image --}}
    <a href="{{ route('login') }}">
        <img src="{{ asset('images/login.png') }}" alt="Login">
    </a>
    {{-- Or show Login and Register links --}}
    
@endauth
</ul>
</nav>

  <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
  <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

</div>
</header><!-- End Header -->

  <main id="main">
    <div class="breadcrumbs">
      
    <div class="page-header d-flex align-items-center" style="background-image: url('{{ url('images/teambg.png') }}'); background-size: cover; background-repeat: no-repeat; background-position: center;">
        <!-- Your content goes here -->
        <div class="container position-relative">
          <div class="row d-flex justify-content-right">
            <div class="col-lg-6 text-right">
            
              <h2><strong>Meet <span> CoLink</span></strong></h2>
              <h5>That’s an understatement. But as a team, we all share a real passion for innovation, creativity and fun. We know firsthand how great it feels to be engaged and energized. To feel that warm glow that comes from having a clear sense of purpose. So is it any wonder we’re on a mission to share all of this with teams like yours?</h5>
            </div>
          </div>
        </div>
      </div>
      <nav>
        <div class="container">
          <ol>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/team') }}"><span>Our Community</span></a></li>
             <li>Our Team</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Breadcrumbs -->
    <!-- ======= Our Team Section ======= -->
    <section id="team" class="team">
    <div class="container" data-aos="fade-up">
  <div class="row gy-4">
    
    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
      <div class="member">
        <img src="{{ asset('images/team/team-1.jpg') }}" class="img-fluid" alt="">
      
      <h4>Richard delos Reyes</h4>
      <span>Lead Convener</span>
      <div class="social">
        <a href=""><i class="bi bi-twitter"></i></a>
        <a href=""><i class="bi bi-facebook"></i></a>
        <a href=""><i class="bi bi-instagram"></i></a>
      </div>
      </div>
    </div><!-- End Team Member -->

    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
      <div class="member">
        <img src="{{ asset('images/team/team-2.jpg') }}" class="img-fluid" alt="">
     
      <h4>Berminie Albacite</h4>
      <span>Co-Lead Convener</span>
      <div class="social">
        <a href=""><i class="bi bi-twitter"></i></a>
        <a href=""><i class="bi bi-facebook"></i></a>
        <a href=""><i class="bi bi-instagram"></i></a>
      </div>
      </div>
    </div><!-- End Team Member -->

    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
      <div class="member">
        <img src="{{ asset('images/team/team-3.jpg') }}" class="img-fluid" alt="">
   
      <h4>Nheil Stephen Dela Cruz</h4>
      <span>Co-Lead Convener</span>
      <div class="social">
        <a href=""><i class="bi bi-twitter"></i></a>
        <a href=""><i class="bi bi-facebook"></i></a>
        <a href=""><i class="bi bi-instagram"></i></a>
      </div>
      </div>
    </div><!-- End Team Member -->





<div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
  <div class="member">
    <img src="{{ asset('images/team/team-4.jpg') }}" class="img-fluid" alt="">
    <h4>Raden Remolino</h4>
    <span>Junior Convener</span>
    <div class="social">
      <a href=""><i class="bi bi-twitter"></i></a>
      <a href=""><i class="bi bi-facebook"></i></a>
      <a href=""><i class="bi bi-instagram"></i></a>
    </div>
  </div>
</div><!-- End Team Member -->

<div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
  <div class="member">
    <img src="{{ asset('images/team/t5.jpg') }}" class="img-fluid" alt="">
    <h4>Mayell Mamalias</h4>
    <span>Junior Convener</span>
    <div class="social">
      <a href=""><i class="bi bi-twitter"></i></a>
      <a href=""><i class="bi bi-facebook"></i></a>
      <a href=""><i class="bi bi-instagram"></i></a>
    </div>
  </div>
</div><!-- End Team Member -->

<div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
  <div class="member">
    <img src="{{ asset('images/team/t6.jpg') }}" class="img-fluid" alt="">
    <h4>Mariella Mamalias</h4>
    <span>Junior Convener</span>
    <div class="social">
      <a href=""><i class="bi bi-twitter"></i></a>
      <a href=""><i class="bi bi-facebook"></i></a>
      <a href=""><i class="bi bi-instagram"></i></a>
    </div>
  </div>
</div><!-- End Team Member -->

<div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
  <div class="member">
    <img src="{{ asset('images/team/t7.jpg') }}" class="img-fluid" alt="">
    <h4>Drew Rufo</h4>
    <span>Junior Convener</span>
    <div class="social">
      <a href=""><i class="bi bi-twitter"></i></a>
      <a href=""><i class="bi bi-facebook"></i></a>
      <a href=""><i class="bi bi-instagram"></i></a>
    </div>
  </div>
</div><!-- End Team Member -->

<div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
  <div class="member">
    <img src="{{ asset('images/team/t8.jpg') }}" class="img-fluid" alt="">
    <h4>Kent John Gella</h4>
    <span>Junior Convener</span>
    <div class="social">
      <a href=""><i class="bi bi-twitter"></i></a>
      <a href=""><i class="bi bi-facebook"></i></a>
      <a href=""><i class="bi bi-instagram"></i></a>
    </div>
  </div>
</div><!-- End Team Member -->

<div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
  <div class="member">
    <img src="{{ asset('images/team/t9.jpg') }}" class="img-fluid" alt="">
    <h4>Jerson Cabunillas</h4>
    <span>Junior Convener</span>
    <div class="social">
      <a href=""><i class="bi bi-twitter"></i></a>
      <a href=""><i class="bi bi-facebook"></i></a>
      <a href=""><i class="bi bi-instagram"></i></a>
    </div>
  </div>
</div><!-- End Team Member -->

<div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
  <div class="member">
    <img src="{{ asset('images/team/t10.jpg') }}" class="img-fluid" alt="">
    <h4>Fritzie Rama</h4>
    <span>Junior Convener</span>
    <div class="social">
      <a href=""><i class="bi bi-twitter"></i></a>
      <a href=""><i class="bi bi-facebook"></i></a>
      <a href=""><i class="bi bi-instagram"></i></a>
    </div>
  </div>
</div><!-- End Team Member -->

<div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
  <div class="member">
    <img src="{{ asset('images/team/t11.jpg') }}" class="img-fluid" alt="">
    <h4>Michelle Monte</h4>
    <span>Junior Convener</span>
    <div class="social">
      <a href=""><i class="bi bi-twitter"></i></a>
      <a href=""><i class="bi bi-facebook"></i></a>
      <a href=""><i class="bi bi-instagram"></i></a>
    </div>
  </div>
</div><!-- End Team Member -->

<div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
  <div class="member">
    <img src="{{ asset('images/team/t12.jpg') }}" class="img-fluid" alt="">
    <h4>Leendon Gelborion</h4>
    <span>Junior Convener</span>
    <div class="social">
      <a href=""><i class="bi bi-twitter"></i></a>
      <a href=""><i class="bi bi-facebook"></i></a>
      <a href=""><i class="bi bi-instagram"></i></a>
    </div>
  </div>
</div><!-- End Team Member -->

<div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
  <div class="member">
    <img src="{{ asset('images/team/t13.jpg') }}" class="img-fluid" alt="">
    <h4>Aimee Rumaguera</h4>
    <span>Junior Convener</span>
    <div class="social">
      <a href=""><i class="bi bi-twitter"></i></a>
      <a href=""><i class="bi bi-facebook"></i></a>
      <a href=""><i class="bi bi-instagram"></i></a>
    </div>
  </div>
</div><!-- End Team Member -->
        </div>

      </div>
    </section><!-- End Our Team Section -->
  </main>


    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-5 col-md-12 footer-info">
            <a href="index.html" class="logo d-flex align-items-center">
              <span>CoLink</span>
            </a>
            <p>Connecting people, ideas, and opportunities — Colink, where collaboration thrives and possibilities unfold.</p>
            <div class="social-links d-flex mt-4">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              
            </div>
          </div>
  
          <div class="col-lg-2 col-6 footer-links">
          <h4>Our Services</h4>
            <ul>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/ourwork') }}">Our Work</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="{{ url('/terms') }}">Terms of Service</a></li>
            <li><a href="{{ url('/policy') }}">Privacy Policy</a></li>
          </ul>
          </div>
  
          <div class="col-lg-2 col-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><a href="#">Speakership</a></li>
              <li><a href="#">Coaching</a></li>
              <li><a href="#">Facilitation</a></li>
              <li><a href="#">Authentic Networking</a></li>
              <li><a href="#">Training</a></li>
            </ul>
          </div>
  
          <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
            <h4>Contact Us</h4>
            <p>
              Head Quarter <br>
              Langtad Argao , Cebu<br>
              Philippines<br><br>
              <strong>Phone:</strong> 09669950377<br>
              <strong>Email:</strong> colinkofficial@gmail.com<br>
            </p>
  
          </div>
  
        </div>
      </div>
  
      <div class="container mt-4">
        <div class="copyright">
          &copy; Copyright <strong><span>CoLink</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/impact-bootstrap-business-website-template/ -->
          Designed by <a href="https://bootstrapmade.com/">CodeCrafters</a>
        </div>
      </div>
  
    </footer><!-- End Footer -->
    <!-- End Footer -->
  
    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  
<!-- AOS Animation Library -->
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>

<!-- GLightbox -->
<script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>

<!-- PureCounter -->
<script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>

<!-- Swiper -->
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

<!-- Isotope Layout -->
<script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

<!-- PHP Email Form Validation -->
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>


  <!-- Template Main JS File -->
  <!-- Compiled Main JavaScript -->
  @vite('resources/js/app.js')
  @vite(['resources/css/main.css', 'resources/js/app.js'])


<!-- jQuery (External CDN) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- Popper.js (External CDN) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

<!-- Bootstrap JavaScript (External CDN) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html> 