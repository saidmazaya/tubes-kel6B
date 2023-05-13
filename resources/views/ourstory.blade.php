@extends('layout.home')

@section('title', 'Our Story')

@section('content')
<section id="about" class="about mt-5">
    <div class="container">

        <div class="section-title">
            <h2>Our Story</h2>
            <h3>Every idea needs a&nbsp;<span>Premium</span></h3>
        </div>

        <div class="row content">
            <div class="col-lg-6">
                <p>
                    The best ideas can change who we are. Medium is where those ideas take shape, take off, and
                    spark powerful conversations. We’re an open platform where over 100 million readers come to
                    find insightful and dynamic thinking. Here, expert and undiscovered voices alike dive into
                    the heart of any topic and bring new ideas to the surface. Our purpose is to spread these
                    ideas and deepen understanding of the world.
                </p>
                <ul>
                    <li><i class="ri-check-double-line"></i> A living network of curious minds.</li>
                    <li><i class="ri-check-double-line"></i> Over 100 million readers and growing.</li>
                    <li><i class="ri-check-double-line"></i> Create the space for your thinking to take off.
                    </li>
                </ul>
            </div>
            <div class="col-lg-6 pt-4 pt-lg-0">
                <p>

                    We’re creating a new model for digital publishing. One that supports nuance, complexity, and
                    vital storytelling without giving in to the incentives of advertising. It’s an environment
                    that’s open to everyone but promotes substance and authenticity. And it’s where deeper
                    connections forged between readers and writers can lead to discovery and growth. Together
                    with millions of collaborators, we’re building a trusted and vibrant ecosystem fueled by
                    important ideas and the people who think about them.
                </p>
                <a href="write" class="btn-learn-more">Write on Premium</a>
            </div>
        </div>

    </div>
</section><!-- End About Section -->
@endsection
@section('cssnav', 'header-inner-pages')