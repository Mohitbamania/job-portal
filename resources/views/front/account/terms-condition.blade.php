@extends('front.layout.app')

@section('title', 'Terms and Conditions')

@section('main')
    <section class="py-5 bg-light mt-5">
        <div class="container">
            <div class="bg-white p-5 rounded-4 shadow-sm border">
                <h1 class="fw-bold mb-3 text-center text-primary">Terms and Conditions</h1>
                <p class="text-muted text-center mb-5">Last updated: {{ now()->format('F d, Y') }}</p>

                <p class="lead text-dark">Welcome to <strong>CareerVibe</strong>. By using our platform, you agree to the
                    following terms and conditions. Please read them carefully.</p>

                <hr class="my-4">

                <div class="mt-4">
                    <h4 class="fw-semibold text-primary">1. Acceptance of Terms</h4>
                    <p>By registering or using our services, you agree to be bound by these Terms and Conditions and our
                        Privacy Policy.</p>

                    <h4 class="fw-semibold text-primary mt-4">2. User Responsibilities</h4>
                    <p>You are responsible for maintaining the confidentiality of your account information and for all
                        activities under your account.</p>

                    <h4 class="fw-semibold text-primary mt-4">3. Prohibited Activities</h4>
                    <p>Users must not misuse the platform by transmitting spam, harmful content, or attempting to disrupt
                        the service.</p>

                    <h4 class="fw-semibold text-primary mt-4">4. Job Listings and Applications</h4>
                    <p>We act only as a platform connecting employers and candidates. We do not guarantee job offers,
                        interview calls, or employment.</p>

                    <h4 class="fw-semibold text-primary mt-4">5. Limitation of Liability</h4>
                    <p>CareerVibe will not be liable for any indirect, incidental, or consequential damages arising from the
                        use of our services.</p>

                    <h4 class="fw-semibold text-primary mt-4">6. Modifications</h4>
                    <p>We may modify these Terms at any time. Continued use of the platform after changes means you accept
                        the revised terms.</p>

                    <h4 class="fw-semibold text-primary mt-4">7. Contact Us</h4>
                    <p>For any concerns regarding these Terms, please contact us at
                        <a href="mailto:bamaniamohit2@gmail.com" class="text-decoration-none fw-semibold text-dark">
                            bamaniamohit2@gmail.com
                        </a>.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection