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
<a href="{{ url('/') }}" class="logo d-flex align-items-center">
   
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
    <li><a href="{{ url('/contract_form') }}">Get Involved</a></li>
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
        <!-- ======= Testimonials Section ======= -->
        <section id="testimonials" class="testimonials">
            <div class="container" data-aos="fade-up">
      
              <div class="section-header">
                <h2>Appreciation</h2>
                <p>Client testimonies overflow with appreciation for Colink's outstanding dedication, expertise, and impactful contributions to successful project outcomes.</p>
              </div>
      
              <div class="slides-3 swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">
      
                  <div class="swiper-slide">
                    <div class="testimonial-wrap">
                      <div class="testimonial-item">
                        <div class="d-flex align-items-center">
                          <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img flex-shrink-0" alt="">
                          <div>
                            <h3>Elijah</h3>
                            <h4>PYCC Talaga</h4>
                            <div class="stars">
                              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                          </div>
                        </div>
                        <p>
                          <i class="bi bi-quote quote-icon-left"></i>
                          CoLink's youth teambuilding was more than just activities; it was an adventure of self-discovery. The facilitators made the experience unforgettable, guiding us through challenges that brought out the best in each of us. Our team spirit is now through the roof, and I'm taking away valuable lessons that go beyond the workshop.
                          <i class="bi bi-quote quote-icon-right"></i>
                        </p>
                      </div>
                    </div>
                  </div><!-- End testimonial item -->
      
                  <div class="swiper-slide">
                    <div class="testimonial-wrap">
                      <div class="testimonial-item">
                        <div class="d-flex align-items-center">
                          <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img flex-shrink-0" alt="">
                          <div>
                            <h3>Zoe</h3>
                            <h4>Oslob LNK</h4>
                            <div class="stars">
                              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                          </div>
                        </div>
                        <p>
                          <i class="bi bi-quote quote-icon-left"></i>
                          Teambuilding with CoLink was a game-changer! The activities were not only engaging but also relevant to our lives. The facilitators were like mentors, making the whole experience relatable. Our group dynamics have evolved positively, and I feel more equipped to navigate teamwork and challenges. Big shoutout to CoLink!
                          <i class="bi bi-quote quote-icon-right"></i>
                        </p>
                      </div>
                    </div>
                  </div><!-- End testimonial item -->
      
                  <div class="swiper-slide">
                    <div class="testimonial-wrap">
                      <div class="testimonial-item">
                        <div class="d-flex align-items-center">
                          <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img flex-shrink-0" alt="">
                          <div>
                            <h3>Nathan</h3>
                            <h4>SK Sambag Uno</h4>
                            <div class="stars">
                              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                          </div>
                        </div>
                        <p>
                          <i class="bi bi-quote quote-icon-left"></i>
                          CoLink's youth teambuilding was a breath of fresh air. The activities were dynamic, and the facilitators brought a perfect blend of enthusiasm and expertise. It wasn't just about teamwork; it was about unlocking our potential. The skills I gained are already making a difference in my academic and personal life. CoLink, you rock!
                          <i class="bi bi-quote quote-icon-right"></i>
                        </p>
                      </div>
                    </div>
                  </div><!-- End testimonial item -->
      
                  <div class="swiper-slide">
                    <div class="testimonial-wrap">
                      <div class="testimonial-item">
                        <div class="d-flex align-items-center">
                          <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img flex-shrink-0" alt="">
                          <div>
                            <h3>Olivia</h3>
                            <h4>FSTLP</h4>
                            <div class="stars">
                              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                          </div>
                        </div>
                        <p>
                          <i class="bi bi-quote quote-icon-left"></i>
                          Teambuilding with CoLink turned my gap year into an epic journey. The activities were adventurous, pushing us to explore new horizons. The facilitators were supportive mentors, guiding us through challenges that translated into real-world skills. Thanks to CoLink, my gap year is filled with incredible memories and newfound confidence!
                          <i class="bi bi-quote quote-icon-right"></i>
                        </p>
                      </div>
                    </div>
                  </div><!-- End testimonial item -->
      
                  <div class="swiper-slide">
                    <div class="testimonial-wrap">
                      <div class="testimonial-item">
                        <div class="d-flex align-items-center">
                          <img src="assets/img/testimonials/testimonials-5.png" class="testimonial-img flex-shrink-0" alt="">
                          <div>
                            <h3>Mason</h3>
                            <h4>SHS Ateneo De Cebu</h4>
                            <div class="stars">
                              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                          </div>
                        </div>
                        <p>
                          <i class="bi bi-quote quote-icon-left"></i>
                          CoLink's youth teambuilding was a revelation. The activities were not just fun; they were strategically designed to enhance our teamwork and communication. The facilitators understood our generation, making the whole experience relatable. I've gained valuable insights and connections that are already benefiting my professional journey. CoLink, you exceeded my expectations!
                          <i class="bi bi-quote quote-icon-right"></i>
                        </p>
                      </div>
                    </div>
                  </div><!-- End testimonial item -->
      
                </div>
                <div class="swiper-pagination"></div>
              </div>
      
            </div>
          </section><!-- End Testimonials Section -->
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
            <h4>Useful Links</h4>
            <ul>
              <li><a href="index.html">Home</a></li>
              <li><a href="ourwork.html">Our Work</a></li>
              <li><a href="#">Services</a></li>
              <li><a href="terms.htlm">Terms of service</a></li>
              <li><a href="policy.html">Privacy policy</a></li>
            </ul>
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