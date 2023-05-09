@extends('layout.home')
@section('title', 'Home')

@section('content')
<div class="jumbotron ">
    <h1 class="display-10">Stay Curious</h1>
    <p class="lead">Discover stories, thinking, and expertise from writers on any topic.</p>
 
    <a class="btn btn-dark btn-lg" href="#" role="button" style="border-radius: 50px ">Start Reading</a>
</div>
<hr class="my-5">

<div class="trending-container auto">
    <h3>Trending on Premium</h3>
    <ul class="article-list trending">
      <li class="trending-item">
        <div class="article-details">
          <h6><a href="#">The Disney-DeSantis Battle Has Crossed a Terrifying Line</a></h6>
          <p class="author">Joe Duncan</p>
          <p class="date">Apr 22</p>
          <p class="read-time">5 min read</p>
        </div>
      </li>
      <li class="trending-item">
        <div class="article-details">
          <h6><a href="#">Why I Keep Failing Candidates During Google Interviews...</a></h6>
          <p class="author">Alexander Nguyen</p>
          <p class="date">Apr 13</p>
          <p class="read-time">4 min read</p>
        </div>
      </li>
      <li class="trending-item">
        <div class="article-details">
          <h6><a href="#">Exit Liquidity</a></h6>
          <p class="author">Arthur Hayes</p>
          <p class="date">Apr 21</p>
          <p class="read-time">27 min read</p>
        </div>
      </li>
      <li class="trending-item">
        <div class="article-details">
          <h6><a href="#">My first layoff was the best thing that could happen to my career</a></h6>
          <p class="author">Felicia Wu</p>
          <p class="date">Apr 25</p>
          <p class="read-time">7 min read</p>
        </div>
      </li>
      <li class="trending-item">
        <div class="article-details">
          <h6><a href="#">How AI is Evolving</a></h6>
          <p class="author">Cassie Kozyrkov</p>
          <p class="date">Apr 27</p>
          <p class="read-time">3 min read</p>
        </div>
      </li>
      <li class="trending-item">
        <div class="article-details">
          <h6><a href="#">I Hope Frank Ocean is Okay</a></h6>
          <p class="author">Akilah Hughes</p>
          <p class="date">Apr 19</p>
          <p class="read-time">7 min read</p>
        </div>
      </li>
    </ul>
  </div>
  
  <hr class="my-5">
  
  <div class="container">
    <div class="article-list">
        <div class="article-item">
          <h3><a href="#">What we’re reading: Declutter your brain</a></h3>
          <p class="author-date">Medium Staff - Apr 28 - 3 min read</p>
          <p>Medium</p>
        </div>
        <div class="article-item">
          <h3><a href="#">“Just Get a Babysitter” — And Other Unhelpful Tips for Overwhelmed Parents</a></h3>
          <p class="author-date">Kerala Taylor - Apr 4 - 7 min read - Parenting</p>
        </div>
        <div class="article-item">
          <h3><a href="#">This Tool Could Be Key to Preventing the Next Pandemic</a></h3>
          <p class="author-date">Dr. Tom Frieden - Apr 22 - 3 min read - Public Health</p>
        </div>
      </div>
      <div class="discover-container">
        <h5>Discover more of what matters to you</h5>
        <div class="topics">
          <a href="#">Programming</a>
          <a href="#">Data Science</a>
          <a href="#">Technology</a>
          <a href="#">Self Improvement</a>
          <a href="#">Writing</a>
          <a href="#">Machine Learning</a>
  
        </div>
      </div>
   
    </div>
@endsection