@extends('template.layout.master')
@section('body')
<div class="container mt-5 mb-5 " style="padding-top: 80px;">
    <div class="main-container">
        <div class="header">
            <h1><i class="fas fa-question-circle"></i> Frequently Asked Questions</h1>
            <p>Find answers to common questions about Furass programs</p>
        </div>

        <div class="container py-5">
            <!-- Students Section -->
            <div class="faq-section">
                <button class="section-header" type="button" data-bs-toggle="collapse" data-bs-target="#students-section" aria-expanded="false">
                    <span><i class="fas fa-user-graduate"></i> For Students</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </button>
                <div class="collapse" id="students-section">
                    <div class="section-content">
                        <div class="question-item">
                            <div class="question">1. Can I register individually?</div>
                            <div class="answer">Currently, registration is only available through schools via official partnerships. If you're interested as an individual, feel free to contact us and we'll keep your information for future updates when individual registration becomes available.</div>
                        </div>
                        <div class="question-item">
                            <div class="question">2. Will I receive a certificate?</div>
                            <div class="answer">Yes, students receive a certificate for each completed program. Community service certificates are granted only for specific trips that involve volunteering or social contribution activities.</div>
                        </div>
                        <div class="question-item">
                            <div class="question">3. Do I visit only one field of study?</div>
                            <div class="answer">No, you will have the opportunity to explore multiple career fields depending on your grade level and chosen program, helping you make informed academic and career decisions.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Parents Section -->
            <div class="faq-section">
                <button class="section-header" type="button" data-bs-toggle="collapse" data-bs-target="#parents-section" aria-expanded="false">
                    <span><i class="fas fa-users"></i> For Parents</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </button>
                <div class="collapse" id="parents-section">
                    <div class="section-content">
                        <div class="question-item">
                            <div class="question">1. How do you ensure student safety during trips?</div>
                            <div class="answer">Each trip is supervised by a Furass advisor along with a school supervisor. We follow strict safety procedures and provide clear transportation and organizational plans.</div>
                        </div>
                        <div class="question-item">
                            <div class="question">2. What are the benefits of these programs for my child?</div>
                            <div class="answer">Furass programs are carefully designed by experts to enhance students' self-awareness, provide real-world exposure, develop essential life skills, and offer career-focused assessments to support their decisions.</div>
                        </div>
                        <div class="question-item">
                            <div class="question">3. Can we track our child's progress?</div>
                            <div class="answer">Yes, professional reports are issued after each stage, and copies can be shared with parents upon request.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- School Leaders Section -->
            <div class="faq-section">
                <button class="section-header" type="button" data-bs-toggle="collapse" data-bs-target="#schools-section" aria-expanded="false">
                    <span><i class="fas fa-school"></i> For School Leaders and Coordinators</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </button>
                <div class="collapse" id="schools-section">
                    <div class="section-content">
                        <div class="question-item">
                            <div class="question">1. How can our school join?</div>
                            <div class="answer">You can contact us via our website or email to sign a partnership agreement that includes a set number of students per grade level, distributed across the three programs.</div>
                        </div>
                        <div class="question-item">
                            <div class="question">2. Can the program schedule be customized to fit the school calendar?</div>
                            <div class="answer">Yes, we fully coordinate with your school to align the sessions and trips with your academic schedule.</div>
                        </div>
                        <div class="question-item">
                            <div class="question">3. Will the school receive regular progress reports?</div>
                            <div class="answer">Absolutely. We provide both individual and group evaluation reports, as well as access to an online monitoring dashboard for the school.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Partner Companies Section -->
            <div class="faq-section">
                <button class="section-header" type="button" data-bs-toggle="collapse" data-bs-target="#partners-section" aria-expanded="false">
                    <span><i class="fas fa-building"></i> For Partner Companies and Institutions</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </button>
                <div class="collapse" id="partners-section">
                    <div class="section-content">
                        <div class="question-item">
                            <div class="question">1. What is the benefit of hosting Furass students?</div>
                            <div class="answer">It's a meaningful contribution to building the next generation. It also enhances your corporate social responsibility role and positions your company as an inspiring and attractive workplace.</div>
                        </div>
                        <div class="question-item">
                            <div class="question">2. Can the visit be customized to suit our work environment?</div>
                            <div class="answer">Yes, we collaborate with you to design an experience that reflects your operations and provides students with a realistic and professional perspective.</div>
                        </div>
                        <div class="question-item">
                            <div class="question">3. Does the partnership include media exposure?</div>
                            <div class="answer">Yes, we highlight our partners on our website, digital materials, and during visits—based on what is agreed in the partnership.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Career Consultants Section -->
            <div class="faq-section">
                <button class="section-header" type="button" data-bs-toggle="collapse" data-bs-target="#consultants-section" aria-expanded="false">
                    <span><i class="fas fa-user-tie"></i> For Career Consultants</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </button>
                <div class="collapse" id="consultants-section">
                    <div class="section-content">
                        <div class="question-item">
                            <div class="question">1. Can I work as a consultant within Furass programs?</div>
                            <div class="answer">We welcome qualified career consultants who meet our clear selection criteria, including experience and professional certifications.</div>
                        </div>
                        <div class="question-item">
                            <div class="question">2. Will I receive ready-made assessment tools?</div>
                            <div class="answer">Yes, we provide validated assessment tools and digital reports, along with training on how to use them effectively before engaging with students.</div>
                        </div>
                        <div class="question-item">
                            <div class="question">3. What types of sessions are offered?</div>
                            <div class="answer">Sessions include individual consultations, assessment result analysis, decision-making support, interview preparation, and resume building.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- General Questions Section -->
            <div class="faq-section">
                <button class="section-header" type="button" data-bs-toggle="collapse" data-bs-target="#general-section" aria-expanded="false">
                    <span><i class="fas fa-clipboard-list"></i> General Questions</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </button>
                <div class="collapse" id="general-section">
                    <div class="section-content">
                        <div class="question-item">
                            <div class="question">1. Are the programs accredited?</div>
                            <div class="answer">Our programs are developed by experts in academic and career guidance. They are based on global best practices and educational frameworks widely used in reputable systems.</div>
                        </div>
                        <div class="question-item">
                            <div class="question">2. Is student data protected?</div>
                            <div class="answer">Yes, all student data is stored securely within a protected digital system and is not used for any commercial or external purposes.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="contact-section">
                <h3><i class="fas fa-envelope"></i> Still Have Questions?</h3>
                <p>Can't find the answer you're looking for? Feel free to reach out to our team.</p>
                <a href="{{route('template.contact')}}" class="btn-contact">
                    <i class="fas fa-paper-plane"></i> Contact Us
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
