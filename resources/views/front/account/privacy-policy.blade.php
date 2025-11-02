@extends('front.layout.app')

@section('title', 'Privacy Policy')

@section('main')
    <section class="py-5 bg-light mt-5">
        <div class="container">
            <div class="bg-white p-5 rounded-4 shadow-sm border">
                <h1 class="fw-bold mb-3 text-center text-primary">Privacy Policy</h1>
                <p class="text-muted text-center mb-5">Last updated: {{ now()->format('F d, Y') }}</p>

                <p class="lead text-dark">Your privacy is important to us. This Privacy Policy explains how we collect, use,
                    and protect your information when you use our platform.</p>

                <hr class="my-4">

                <div class="mt-4">
                    <h4 class="fw-semibold text-primary">1. Information We Collect</h4>
                    <p>We may collect personal details such as your name, email address, phone number, and job preferences
                        when you register or use our services.</p>

                    <h4 class="fw-semibold text-primary mt-4">2. How We Use Your Information</h4>
                    <p>We use the collected information to provide job search services, improve our platform, communicate
                        with you, and ensure better user experience.</p>

                    <h4 class="fw-semibold text-primary mt-4">3. Data Security</h4>
                    <p>We use appropriate technical and organizational measures to safeguard your data from unauthorized
                        access, alteration, or disclosure.</p>

                    <h4 class="fw-semibold text-primary mt-4">4. Cookies</h4>
                    <p>We use cookies to improve functionality and analyze user interactions. You can manage cookies through
                        your browser settings.</p>

                    <h4 class="fw-semibold text-primary mt-4">5. Changes to this Policy</h4>
                    <p>We may update this policy periodically. The latest version will always be available on this page.</p>

                    <h4 class="fw-semibold text-primary mt-4">6. Contact Us</h4>
                    <p>If you have any questions about this Privacy Policy, please contact us at
                        <a href="mailto:bamaniamohit2@gmail.com" class="text-decoration-none fw-semibold text-dark">
                            bamaniamohit2@gmail.com
                        </a>.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection