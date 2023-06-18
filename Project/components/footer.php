<style>
    .footer{
      background-color: #24262b;
      padding: 40px 0;
  }

  .footer-row{
      display: flex;
      flex-wrap: wrap;
  }

  .footer-container{
      max-width: 1170px;
      margin: auto;
  }

  ul{
      list-style: none;
  }

  .footer-col{
      width: 25%;
      padding: 0 15px;
  }

  .footer-col h4{
      font-size: 18px;
      color: #ffffff;
      text-transform: capitalize;
      margin-bottom: 30px;
      font-weight: 500;
      position: relative;
      
  }

  .footer-col h4::befor{
      content: '';
      position: absolute;
      left: 0;
      bottom: -10px;
      background: red;
      height: 2px;
      box-sizing: border-box;
      width: 50px;
  }
  .footer-col ul li:not(:last-child){
      margin-bottom:10px;
  }
  .footer-col ul li a{
      font-size: 16px;
      text-transform: capitalize;
      color: #ffffff;
      font-weight: 300;
      color: #bbbbbb;
      display: block;
      transition: all 0.3s ease;
  }

  .footer-col ul li a:hover{
      color: #ffffff;
      padding-left: 8px;
  }

  .footer-col .social-links a{
     display: inline-block;
     height: 40px;
     width: 40px;
     background-color: rgba(255, 255, 255, 0.2); 
     margin: 0 10px 10px 0;
     text-align: center;
     line-height: 40px;
     border-radius: 50px;
     color: #ffffff;
     transition: all 0.5s ease;
  }

  .footer-col .social-links a:hover{
    color: #24262b;
    background-color: #ffffff;
  }

  @media(max-width: 767px){
      .footer-col{
          width: 50%;
          margin-bottom: 30px;
      }
  }

  @media(max-width: 574px){
    .footer-col{
        width: 100%;
    }
}
</style>
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
     </footer