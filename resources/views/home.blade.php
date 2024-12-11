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
      <a href="/" class="logo d-flex align-items-center">
       
        <img src="{{ asset('images/CoLink Logo White.png')}}" alt="">
        
      </a>
      <nav id="navbar" class="navbar">
    <ul>
        <li class="active"><a href="{{ url('/') }}">Home</a></li>
        <li class="dropdown"><a href="{{ url('/team') }}"><span>Our Community</span></a></li>
        <li class="dropdown"><a href="{{ url('/intervention') }}"><span>Our Work</span></a>
            <ul>
                <li><a href="{{ url('/dashboard') }}">>> Services</a></li>
                <li><a href="{{ url('/intervention') }}">>> Interventions</a></li>
            </ul>
        </li>
        <li><a href="{{ url('/impact') }}">Our Impact</a></li>
        <li><a href="{{ url('/donation') }}">Get Involved</a></li>
    
        @auth
    <!-- If the user is logged in, show the avatar, notification bell, and logout button -->
    <div class="flex items-center space-x-4">
        <!-- Bell Icon (Notification) -->
        <button class="p-1 rounded-full text-yellow-400 hover:text-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
        </button>

        <!-- Avatar and Dropdown -->
        <div>
            <button class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="user-menu" aria-haspopup="true">
                {{-- Replace with the user's avatar --}}
                <a href="{{ route('profile') }}">
    <img class="h-8 w-8 rounded-full object-cover"
         src="{{ auth()->user()->avatar_url ?? asset('images/profile-icon2.png') }}" 
         alt="User Avatar"
         style="object-fit: cover;">
</a>
            </button>
        </div>

        <!-- Logout Icon -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="p-1 rounded-full text-gray-400 hover:text-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 16l-4-4m0 0l4-4m-4 4h14m-7 4v1m0-8v1" />
                </svg>
            </button>
        </form>
   
@else

<!-- If the user is NOT logged in, show the login button -->

<a href="{{ route('login') }}">
    <img src="{{ asset('images/login.png') }}" alt="Login" style="width: 40%; height: 50%; bottom:100px; object-fit: cover;">
</a>
</div>
      
@endauth



    </ul>
   
</nav>

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
  </header><!-- End Header -->
  <!-- End Header -->

  <!-- ======= Hero Section ======= -->

  <section id="hero" class="hero">
    <div class="col-lg-6 order-1 order-lg-2">
      <div class="bg">
      <img src="{{asset('images/home6pic.png')}}" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="100">
    </div>
  </div>
    <div class="container position-relative">
      <div class="row gy-5" data-aos="fade-in">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-center text-lg-start">
          <h2>Your Partner of <span>choice</span> in  
          
            Uplifting
         
            <span> the Youth  </span> 
        
        and their  communites</h2>
          <p>We are a youth-serving organization acknowledged by the Local Government Unit of Argao dedicated to uplifting the youth and their communities through learning and development interventions.</p>
          <div class="d-flex justify-content-center justify-content-lg-start">
            <a href="contract_form.php" class="btn-get-started">Partner with Us</a>
          
          </div>
        </div>
       
    </div>
  </div>

    <div class="icon-boxes position-relative">
      <div class="container position-relative">
        <div class="row gy-4 mt-5">

          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="icon-box">
            <div class="icon">
    <img src="{{ asset('images/icon1.png') }}" alt="Leadership Image">
</div>
                <h4 class="title"><a href="" class="stretched-link">Leadership</a></h4>
            </div>
        </div><!--End Icon Box -->
        

          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="icon-box">
              <div class="icon2"><img src="{{asset ('images/icon2.png')}}" alt="Leadership Image"></div>
              <h4 class="title"><a href="" class="stretched-link">Integrity</a></h4>
            </div>
          </div><!--End Icon Box -->

          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="icon-box">
              <div class="icon3"><img src="{{asset ('images/icon3.png')}}" alt="Leadership Image"></div>
              <h4 class="title"><a href="" class="stretched-link">Nurture for Growth</a></h4>
            </div>
          </div><!--End Icon Box -->

          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="icon-box">
              <div class="icon4"><img src="{{asset ('images/icon4.png')}}" alt="Leadership Image"></div>
              <h4 class="title"><a href="" class="stretched-link">Kollab</a></h4>
            </div>
          </div><!--End Icon Box -->

        </div>
      </div>
    </div>

    </div>
  </section>
  <!-- End Hero Section -->

  <main id="main">

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h1>What is CoLink?</h1> <p>Partner of choice in uplifting 1,000 youth and their communities to Breakthrough and Co-Elevation</p>
         
        </div>

        <div class="row gy-4">
          <div class="col-lg-6">
            <h2><span>Inspiring</span> Growth. <span>Transparent</span> Connections. <span>Trusted</span> Partnerships.</h2>
            <img src="{{asset('images/about.jpg')}}" class="img-fluid rounded-4 mb-4" alt="">
            <p>CoLink is dedicated to uplifting the youth, serving as a guiding force in their journey towards personal and collective empowerment. Through mentorship, resources, and a commitment to positive change, we strive to elevate the aspirations and potential of the youth, fostering a brighter future for both individuals and their communities.</p>
            <p>At CoLink, we passionately champion the empowerment of youth, recognizing their potential as the driving force for positive change. Through innovative programs, mentorship, and a supportive ecosystem, we actively uplift the aspirations and dreams of young minds. Our mission is to be a catalyst for their success, creating a lasting impact that resonates far beyond individual achievements, ultimately contributing to the upliftment of society as a whole.</p>
          </div>
          <div class="col-lg-6">
            <div class="content ps-0 ps-lg-5">
              <h2>
                <span>CHEVRON:</span> HOW TO GIVE THE BEST VALUE?
              </h2>
              <ul>
                <li><i class="bi bi-check-circle-fill"></i> Contracting</li>
                <li><i class="bi bi-check-circle-fill"></i> Assessment</li>
                <li><i class="bi bi-check-circle-fill"></i> Designing</li>
                <li><i class="bi bi-check-circle-fill"></i> Intervention</li>
                <li><i class="bi bi-check-circle-fill"></i> Evaluation</li>
              </ul>
              <p>
                CoLink stands as a beacon of empowerment, committed to catalyzing positive change. With a focus on transparency, trust, and collective impact, we forge meaningful connections that uplift individuals and communities, fostering breakthroughs and shared elevation.
              </p>

              <div class="position-relative mt-4">
                <img src="{{asset('images/about-2.png')}}" class="img-fluid rounded-4" alt="">
               
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End About Us Section -->

    <!-- ======= Clients Section ======= -->
    <section id="clients" class="clients">
      <div class="container" data-aos="zoom-out">
<h2><b>Chosen by:</b></h2>
        <div class="clients-slider swiper">
          <div class="swiper-wrapper align-items-center">
            <div class="swiper-slide"><img src="{{asset('images/clients/1.jpg')}}" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{asset('images/clients/2.jpg')}}" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{asset('images/clients/3.jpg')}}" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{asset('images/clients/4.jpg')}}" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{asset('images/clients/5.png')}}" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{asset('images/clients/6.jpg')}}" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{asset('images/clients/7.png')}}" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{asset('images/clients/8.jpg')}}" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{asset('images/clients/9.jpg')}}" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{asset('images/clients/10.png')}}" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{asset('images/clients/11.jpg')}}" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="{{asset('images/clients/12.jpg')}}" class="img-fluid" alt=""></div>
          </div>
        </div>

      </div>
    </section><!-- End Clients Section -->

    <!-- ======= Stats Counter Section ======= -->
    <section id="stats-counter" class="stats-counter">
      <div class="container" data-aos="fade-up">

        <div class="row gy-4 align-items-center">

          <div class="col-lg-6">
            <img src="{{asset('images/suga.png')}}" alt="" class="img-fluid">
          </div>

          <div class="col-lg-6">

            
            <div class="stats-item d-flex align-items-center">
              <span data-purecounter-start="0" data-purecounter-end="1891" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong>Uplifted Youth</strong> Elevate the future with our 1890 Uplifted Youth initiative—a commitment to empower and inspire the next generation through comprehensive programs, mentorship, and opportunities for personal and collective growth.</p>
            </div><!-- End Stats Item -->


            <div class="stats-item d-flex align-items-center">
              <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong>Interventions</strong> Experience impactful change with our 15 Interventions—strategic initiatives designed to catalyze transformation, foster growth, and elevate the collective potential of individuals and organizations.</p>
            </div><!-- End Stats Item -->

            <div class="stats-item d-flex align-items-center">
              <span data-purecounter-start="0" data-purecounter-end="6" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong>Partners</strong>Cultivate success through our 6 Partnerships—a collaborative approach to achieving shared goals, driving innovation, and fostering sustainable growth with key allies and stakeholders.</p>
            </div><!-- End Stats Item -->

          </div>

        </div>

      </div>
    </section><!-- End Stats Counter Section -->

    <!-- ======= Call To Action Section ======= -->
    <section id="call-to-action" class="call-to-action">
      <div class="container text-center" data-aos="zoom-out">
        <a href="https://drive.google.com/file/d/1sqPxPNaqcgcrYwICIzfQxglWb1xMCh8C/view?usp=drive_link" class="glightbox play-btn"></a>
        <h3>Who is behind CoLink?</h3>
        
      
      </div>
    </section><!-- End Call To Action Section -->





  </main><!-- End #main -->

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
            <h4>Useful Links</h4>
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