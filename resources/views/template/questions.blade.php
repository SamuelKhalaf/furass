@extends('template.layout.master')
@section('body')
    <div class="container mt-5 mb-5" style="padding-top: 80px;">
        <div class="main-container">
            <div class="header">
                <h1><i class="fas fa-question-circle"></i> {{ __('template.faq.title') }}</h1>
                <p>{{ __('template.faq.subtitle') }}</p>
            </div>

            <div class="container py-5">
                <!-- Students Section -->
                <div class="faq-section">
                    <button class="section-header" type="button" data-bs-toggle="collapse" data-bs-target="#students-section" aria-expanded="false">
                        <span><i class="fas fa-user-graduate"></i> {{ __('template.faq.students.title') }}</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </button>
                    <div class="collapse" id="students-section">
                        <div class="section-content">
                            @foreach(__('template.faq.students.questions') as $index => $item)
                                <div class="question-item">
                                    <div class="question">{{ $index + 1 }}. {{ $item['q'] }}</div>
                                    <div class="answer">{{ $item['a'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- Parents Section -->
                <div class="faq-section">
                    <button class="section-header" type="button" data-bs-toggle="collapse" data-bs-target="#parents-section" aria-expanded="false">
                        <span><i class="fas fa-users"></i> {{ __('template.faq.parents.title') }}</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </button>
                    <div class="collapse" id="parents-section">
                        <div class="section-content">
                            @foreach(__('template.faq.parents.questions') as $index => $item)
                                <div class="question-item">
                                    <div class="question">{{ $index + 1 }}. {{ $item['q'] }}</div>
                                    <div class="answer">{{ $item['a'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- School Leaders Section -->
                <div class="faq-section">
                    <button class="section-header" type="button" data-bs-toggle="collapse" data-bs-target="#schools-section" aria-expanded="false">
                        <span><i class="fas fa-school"></i> {{ __('template.faq.schools.title') }}</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </button>
                    <div class="collapse" id="schools-section">
                        <div class="section-content">
                            @foreach(__('template.faq.schools.questions') as $index => $item)
                                <div class="question-item">
                                    <div class="question">{{ $index + 1 }}. {{ $item['q'] }}</div>
                                    <div class="answer">{{ $item['a'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- Partner Companies Section -->
                <div class="faq-section">
                    <button class="section-header" type="button" data-bs-toggle="collapse" data-bs-target="#partners-section" aria-expanded="false">
                        <span><i class="fas fa-building"></i> {{ __('template.faq.partners.title') }}</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </button>
                    <div class="collapse" id="partners-section">
                        <div class="section-content">
                            @foreach(__('template.faq.partners.questions') as $index => $item)
                                <div class="question-item">
                                    <div class="question">{{ $index + 1 }}. {{ $item['q'] }}</div>
                                    <div class="answer">{{ $item['a'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- Career Consultants Section -->
                <div class="faq-section">
                    <button class="section-header" type="button" data-bs-toggle="collapse" data-bs-target="#consultants-section" aria-expanded="false">
                        <span><i class="fas fa-user-tie"></i> {{ __('template.faq.consultants.title') }}</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </button>
                    <div class="collapse" id="consultants-section">
                        <div class="section-content">
                            @foreach(__('template.faq.consultants.questions') as $index => $item)
                                <div class="question-item">
                                    <div class="question">{{ $index + 1 }}. {{ $item['q'] }}</div>
                                    <div class="answer">{{ $item['a'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- General Questions Section -->
                <div class="faq-section">
                    <button class="section-header" type="button" data-bs-toggle="collapse" data-bs-target="#general-section" aria-expanded="false">
                        <span><i class="fas fa-clipboard-list"></i> {{ __('template.faq.general.title') }}</span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </button>
                    <div class="collapse" id="general-section">
                        <div class="section-content">
                            @foreach(__('template.faq.general.questions') as $index => $item)
                                <div class="question-item">
                                    <div class="question">{{ $index + 1 }}. {{ $item['q'] }}</div>
                                    <div class="answer">{{ $item['a'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="contact-section">
                    <h3><i class="fas fa-envelope"></i> {{ __('template.faq.contact_title') }}</h3>
                    <p>{{ __('template.faq.contact_desc') }}</p>
                    <a href="{{route('template.contact')}}" class="btn-contact">
                        <i class="fas fa-paper-plane"></i> {{ __('template.faq.contact_btn') }}
                    </a>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add smooth scrolling animation when sections are opened
        document.querySelectorAll('.section-header').forEach(header => {
            const icon = header.querySelector('.toggle-icon');
            const targetId = header.getAttribute('data-bs-target');
            const target = document.querySelector(targetId);

            header.addEventListener('click', function () {
                // Delay scroll and icon toggle to match Bootstrap animation
                setTimeout(() => {
                    const isExpanded = header.getAttribute('aria-expanded') === 'true';

                    // Rotate icon when expanded
                    if (isExpanded) {
                        icon.classList.add('rotate');
                        header.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    } else {
                        icon.classList.remove('rotate');
                    }
                }, 350);
            });
        });


        // Add entrance animation for FAQ sections
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all FAQ sections
        document.querySelectorAll('.faq-section').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(section);
        });
    </script>
@endsection
