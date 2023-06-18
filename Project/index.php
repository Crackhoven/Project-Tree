<?php
session_start();
require_once 'components/db_connect.php';

// if session is not set this will redirect to login page
if (isset($_SESSION['user'])) {
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Tree | Home</title>
    <?php require_once 'components/head.php'; ?>
    <link rel="stylesheet" href="Istvan/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css" rel="stylesheet"/>
    <script src="https://kit.fontawesome.com/f675374a3f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
      .navbar{
            background: linear-gradient(to right, #d2fbd0,#71AF6B);
            /* light: #D2FBD0 middle: #71AF6B dark: #0D5F07 */
        }

        .navbar-brand {
            font-family: 'Hammersmith One', sans-serif!important;
            letter-spacing: .2rem!important;
            font-size: 2rem !important;
            text-decoration: none!important;
        }

        .nav-item   {
            font-family: 'Plus Jakarta Sans', sans-serif!important;
            padding-right: 3rem!important;
            font-weight: 600!important;
        }
    </style>
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow fixed-top">
        <div class="container-fluid p-2">
            <a class="navbar-brand ps-5" href="home.php">
                <img src="img/tree.png" alt="" width="30" height="30" class="d-inline-block align-text-top">
                mentor tree
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="search.php">Find a Mentor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
      <!-- Hero -->
      <section class="hero bg-cover">
          <div class="overlay"></div>
          <div class="container text-light text-center">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-light typewrite">Our goal is to find your <span id="text"></span></h1>
                    <br>
                     <!-- search box -->
                  <div class="search-container">
                    <form action="search.php" method="GET" class="search-bar">
                      <input type="text" placeholder="Search" name="search" value="">
                        <button type="submit" href="search.php?"><img src="Istvan/img/32.ico" alt=""></button>
                    </form>
                  </div>
                  <br>
                  <br>
                    <div class="">
                        <button class="btn-main login-btn m-2"><a class="text-dark skill" href="search.php?search=computer+science">Computer Science</a></button>
                        <button class="btn-main login-btn m-2"><a class="text-dark skill"href="search.php?search=javascript">JavaScript</a></button>
                        <button class="btn-main login-btn m-2"><a class="text-dark skill"href="search.php?search=php">PHP</a></button>
                        <button class="btn-main login-btn m-2"><a class="text-dark skill"href="search.php?search=machine+learning">Machine Learning</a></button>
                        <button class="btn-main login-btn m-2"><a class="text-dark skill"href="search.php?search=data+science">Data Science</a></button>
                        <button class="btn-main login-btn m-2"><a class="text-dark skill"href="search.php?search=analytics">Analytics</a></button>
                        <button class="btn-main login-btn m-2"><a class="text-dark skill"href="search.php?search=cyber+security">Cyber Security</a></button>
                    </div>
                   <!--  <div class="login-btn">
                    <a href="#" class="btn-main">Login</a>
                </div> -->
                </div>
            </div>
          </div>
      </section>

      

      <!-- about -->
      <section id="info" class="p-5">
          <div class="container">
              <div class="row">
                  <div class="col-12 about text-center">
                  <h1>About Us</h1>
                  <p>Mentorship is underrated. While the majority of leaders, CEOs and professionals think mentoring is crucial to success, only an estimated 37% of mentoring believers are currently working with a mentor.
                  Why is that? Good mentors are hard to find, getting them to commit is even harder. Mentorships are often handwavy, HR-matched or forced, making them less effective.</p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-4">
                  <div class="service">
                      <div class="service-img">
                          <img src="Istvan/img/10.jpg" alt="student" class="img-fluid p-3">
                          <div class="icon"><i class="bi bi-compass"></i></div>
                      </div>
                      <div class="p-5">
                        <h4>Find your mentor:</h4>
                            <p>Find your mentor, who will give you professional help and guidance.</p>
                        </div>
                  </div>
              </div>
              <div class="col-md-4">
                <div class="service">
                    <div class="service-img">
                        <img src="Istvan/img/8.jpg" alt="student" class="img-fluid p-3">
                        <div class="icon"><i class="bi bi-compass"></i></div>
                    </div>
                    <div class="p-5">
                    <h4>Find your student:</h4>
                        <p>A lot of students struggle with smaller bigger things Don't keep them waiting!!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service">
                    <div class="service-img">
                        <img src="Istvan/img/9.jpg" alt="student" class="img-fluid p-3">
                        <div class="icon"><i class="bi bi-compass"></i></div>
                    </div>
                    <div class="p-5">
                        <h4>Find your path:</h4>
                            <p>If you're a mentor looking for a disciple or a student looking for a teacher, you'll find your new path here.</p>
                        </div>
                </div>
            </div>
          </div>
        </div>
      </section>

      <!-- break2 -->
      <section class="break2 text-light">
        <div class="overlay"></div>
          <div class="container">
            <div class="row align-items-center justify-content-between">
              <div class="col-md p-5 break-text">
                <p class="lead">
               <strong><i>"Only the stupid know everything, the rest of us learn for life"</i></strong> 
                </p>
                <p>Albert Einstein</p>
              </div>
            </div>
          </div>
        </section>
      </section>

      <!-- reviews -->
      <section class="text-center testemonial p-5"> 
        <div class="overlay"></div>
        <div class="container">
          <div class="row">
            <div class="col-12 section-intro text-center">
              <h1>Our reviews</h1>
              <p>"just a few comments from students who have found their mentors with us"</p>
            </div>
          </div>
          <div class="row gx-4 gy-4 text-start">
            <div class="col-md-4">
              <div class="review p-4 bg-light">
                <div class="person">
                  <img src="Istvan/img/15.jpg" class="img-fluid" alt="">
                  <div class="text ms-3">
                    <h6 class="mb-0">Eva Doe</h6>
                  </div>
                </div>
                <p class="pt-4">"In just a few weeks, I feel a LOT more confident navigating the React world. Chris has been an excellent mentor."</p>
                <div class="star">
                  <i class="fa-solid fa-star" data-rating="1"></i>
                  <i class="fa-solid fa-star" data-rating="2"></i>
                  <i class="fa-solid fa-star" data-rating="3"></i>
                  <i class="fa-solid fa-star" data-rating="4"></i>
                  <i class="fa-solid fa-star" data-rating="5"></i>
              </div>
            </div>
          </div>
      
          <div class="col-md-4">
    <div class="review p-4 bg-light">
      <div class="person">
        <img src="Istvan/img/14.jpg" class="img-fluid" alt="">
        <div class="text ms-3">
          <h6 class="mb-0">Nathe White</h6>
        </div>
      </div>
      <p class="pt-4">"Siavash is the best mentor I could ask for! I'm completely new to product management, and he shared with me a many useful advices and lots of material (videos, articles, books). When I started some new projects, he came up with brilliant ideas to master them and to make my work more efficient and creative. Other than that, Siavash is the greatest person whom I always enjoy talking to!"</p>
      <div class="star">
        <i class="fa-solid fa-star" data-rating="1"></i>
        <i class="fa-solid fa-star" data-rating="2"></i>
        <i class="fa-solid fa-star" data-rating="3"></i>
        <i class="fa-solid fa-star" data-rating="4"></i>
        <i class="fa-solid fa-star" data-rating="5"></i>
    </div>
  </div>
</div>
      <div class="col-md-4">
        <div class="review p-4 bg-light">
          <div class="person">
            <img src="Istvan/img/27.jpg" class="img-fluid" alt="">
            <div class="text ms-3">
              <h6 class="mb-0">Sarah Willson</h6>
            </div>
          </div>
          <p class="pt-4">"Anna really helped me a lot. Thank you very much. Her mentoring was very structured, she could answer all my questions and inspired me a lot. I can already see that this has made me even more successful with my agency."</p>
          <div class="star">
            <i class="fa-solid fa-star" data-rating="1"></i>
            <i class="fa-solid fa-star" data-rating="2"></i>
            <i class="fa-solid fa-star" data-rating="3"></i>
            <i class="fa-solid fa-star" data-rating="4"></i>
            <i class="fa-solid fa-star" data-rating="5"></i>
        </div>
      </div>
    </div>
        </div>
      </section>

          <!-- break -->
          <section class="break text-light">
            <div class="overlay"></div>
              <div class="container">
                <div class="row">
                <div class="col-md">
                
              </div>
                  <div class="col-md p-5 break-text">
                    <p class="lead">
                      <strong><i>"Learning is the most powerful weapon you can use to change the world"</i></strong>
                    </p>
                    <p>Nelson Mandela</p>
                  </div>
                </div>
              </div>
            </section>
          </section>

      <!-- question -->
      <section id="questions" class="p-5 question">
        <div class="container question-backg">
            <h1 class="text-center mb-4">Frequently Asked Questions</h1>
            <div class="accordion accordion-flush">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q1">What can I expect?</button>
                    </h2>
                    <div id="q1" class="accordion-collapse collapse" data-bs-parent="#questions">
                        <div class="accordion-body">
                        Mentors will do their best to get you where you want to be. They are vetted and continuously evaluated based on their performances, with the goal to only have the best mentors available to you.
                        However, mentors are professionals in the industry, offering their free time to help you reach your goals. We do not like setting constraints on interaction, so expect the best possible care and reply rate possible for a fully working human, but do not expect replies in minutes and 24/7 hands-on care.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q2">How can I get in touch with a mentor?</button>
                    </h2>
                    <div id="q2" class="accordion-collapse collapse" data-bs-parent="#questions">
                        <div class="accordion-body">
                        We offer two main ways to get in touch with a mentor, the regular long-term mentorship through application, and by booking a session.
                        The long-term mentorship is best for you if you want to work towards a long-term goal. To sign up for a mentor longterm, visit their profile and fill out an application through the "Apply" button.
                        Sessions are best if you need a quick, casual way to get in touch with a mentor. There is no application required. To book a suitable session, visit the Sessions page.
                        </div>
                    </div>
                </div>
    
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q3">My mentor hasn't responded to my application in X days, what should I do?</button>
                    </h2>
                    <div id="q3" class="accordion-collapse collapse" data-bs-parent="#questions">
                        <div class="accordion-body">
                        We urge mentors to reply in 5 days or less, but sometimes life gets in the way. We will notify your mentor on your behalf multiple times, but if you haven't gotten any feedback after 10 days, it's usually time to move on.
                        We are making a constant effort to filter out inactive members of our community, but it's not always possible to be perfectly accurate with that.
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="bg-cover text-white contact">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-12 section-intro text-center">
            <h1>Get in touch</h1>
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 mx-auto">
            <form action="#" class="row g-4">
              <div class="form-group col-md-6">
                <input type="text" class="form-control rounded" placeholder="Full name">
              </div>
              <div class="form-group col-md-6">
                <input type="email" class="form-control rounded" placeholder="Email adddress">
              </div>
              <div class="form-group col-md-12">
                <input type="text" class="form-control rounded" placeholder="Subject">
              </div>
              <div class="form-group col-md-12">
                <textarea name="" id="" cols="30" rows="4" class="form-control rounded" placeholder="Message"></textarea>
              </div>
              <div class="text-center">
              <button class="btn  btn-light" type="submit">Send Message</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </section>


     <!-- footer -->
     <footer class="footer">
       <div class="footer-container">
         <div class="footer-row">
           <div class="footer-col">
             <h4>PLATFORM</h4>
             <ul>
               <li><a href="">Browse Mentors</a></li>
               <li><a href="">Book Session</a></li>
               <li><a href="">Becom a Mentor</a></li>
               <li><a href="">Mentor Group</a></li>
             </ul>
           </div>
           <div class="footer-col">
            <h4>RESOURCES</h4>
            <ul>
              <li><a href="">Newsletter</a></li>
              <li><a href="">Perks</a></li>
              <li><a href="">Blog</a></li>
              <li><a href="">Testimonials</a></li>
            </ul>
          </div>
          <div class="footer-col">
            <h4>SUPPORT</h4>
            <ul>
              <li><a href="">FAQ</a></li>
              <li><a href="">Contact</a></li>
            </ul>
          </div>
          <div class="footer-col">
            <h4>Follow Us</h4>
            <div class="social-links">
              <a href=""><i class="bi bi-twitter icon"></i></a>
              <a href=""><i class="bi bi-google icon"></i></a>
              <a href=""><i class="bi bi-instagram icon"></i></a>
              <a href=""><i class="bi bi-facebook icon"></i></a>
            </div>
          </div>
         </div>
       </div>
       <div>
         <br>
        <p class="text-light text-center">© Copyright: 2022</p>
      </div>
     </footer>     
        

      <!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

     <!-- typewrite -->
<script src="Istvan/js/typewrite.js"></script>

     <!-- map -->
<script src="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js"></script>

    <script>
      mapboxgl.accessToken =
        'pk.eyJ1IjoiYnRyYXZlcnN5IiwiYSI6ImNrbmh0dXF1NzBtbnMyb3MzcTBpaG10eXcifQ.h5ZyYCglnMdOLAGGiL1Auw'
      var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [16.38564118711051,48.20188140317048],
        zoom: 11,
      })
    </script>
</body>
</html>