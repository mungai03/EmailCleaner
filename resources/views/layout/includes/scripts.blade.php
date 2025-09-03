 <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('contributionData', () => ({
                tooltipText: '',
                months: [{
                        name: 'Jan',
                        index: 0,
                        colspan: 4.2
                    },
                    {
                        name: 'Feb',
                        index: 1,
                        colspan: 4.2
                    },
                    {
                        name: 'Mar',
                        index: 2,
                        colspan: 4.2
                    },
                    {
                        name: 'Apr',
                        index: 3,
                        colspan: 4.2
                    },
                    {
                        name: 'May',
                        index: 4,
                        colspan: 4.2
                    },
                    {
                        name: 'Jun',
                        index: 5,
                        colspan: 4.2
                    },
                    {
                        name: 'Jul',
                        index: 6,
                        colspan: 4.2
                    },
                    {
                        name: 'Aug',
                        index: 7,
                        colspan: 4.2
                    },
                    {
                        name: 'Sep',
                        index: 8,
                        colspan: 4.2
                    },
                    {
                        name: 'Oct',
                        index: 9,
                        colspan: 4.2
                    },
                    {
                        name: 'Nov',
                        index: 10,
                        colspan: 4.2
                    },
                    {
                        name: 'Dec',
                        index: 11,
                        colspan: 4.2
                    }
                ],
                pattern: [
                    23, 24, 25, 26, 27, 29, 35, 36, 42, 44, 48, 58, 59, 60, 61, 62, 64, 70, 71, 77,
                    79, 80, 81, 82, 83, 92,
                    93, 94, 95, 96, 97, 98, 99, 105, 106, 112, 114, 115, 116, 117, 118, 127, 128,
                    129, 130, 131, 132, 133,
                    141, 142, 143, 144, 145, 146, 147, 150, 158, 166, 169, 170, 171, 172, 173, 174,
                    175, 184, 185,
                    186, 187, 188, 190, 193, 196, 197, 200, 203, 205, 207, 208, 209, 228, 235, 240,
                    241, 242, 243, 244, 249, 256, 275,
                    276, 277, 278, 279, 282, 287, 289, 294, 296, 301, 303, 308, 310, 315, 317, 318,
                    319, 320, 321, 325, 328, 332, 335, 340, 341
                ],
                getCellClass(weekIndex, dayIndex) {
                    const index = (weekIndex * 7) + dayIndex + 1;
                    return this.pattern.includes(index) ? 'bg-green-500' : 'bg-gray-700';
                },
                showTooltip(weekIndex, dayIndex, event) {
                    const date = new Date(2025, 0, 1);
                    date.setDate(date.getDate() + (weekIndex * 7) + dayIndex);
                    const formattedDate = date.toLocaleDateString('en-US', {
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric'
                    });
                    const index = (weekIndex * 7) + dayIndex + 1;
                    const contributions = this.pattern.includes(index) ?
                        Math.floor(Math.random() * 15) + 10 :
                        Math.floor(Math.random() * 10) + 5;
                    this.tooltipText = `${contributions} contributions on ${formattedDate}`;
                    const tooltip = this.$refs.tooltip;
                    tooltip.style.display = 'block';
                    tooltip.style.left = `${event.pageX + 10}px`;
                    tooltip.style.top = `${event.pageY + 10}px`;
                },
                hideTooltip() {
                    this.$refs.tooltip.style.display = 'none';
                }
            }));

            Alpine.data('progressBars', () => ({
                frontend: 0,
                backend: 0,
                devops: 0,
                mobile: 0,
                animateProgress(bar) {
                    const targetValues = {
                        frontend: 90,
                        backend: 85,
                        devops: 75,
                        mobile: 65
                    };
                    const target = targetValues[bar];
                    let start = 0;
                    const duration = 2500;
                    const increment = target / (duration / 16);
                    const update = () => {
                        start += increment;
                        if (start >= target) {
                            this[bar] = target;
                        } else {
                            this[bar] = Math.round(start);
                            requestAnimationFrame(update);
                        }
                    };
                    requestAnimationFrame(update);
                }
            }));

            Alpine.data('contactForm', () => ({
                form: {
                    name: '',
                    email: '',
                    message: ''
                },
                errors: {
                    name: '',
                    email: '',
                    message: ''
                },
                isSubmitting: false,
                success: false,
                error: '',
                validateForm() {
                    this.errors = {
                        name: '',
                        email: '',
                        message: ''
                    };
                    let isValid = true;

                    if (!this.form.name.trim()) {
                        this.errors.name = 'Name is required';
                        isValid = false;
                    }
                    if (!this.form.email.trim()) {
                        this.errors.email = 'Email is required';
                        isValid = false;
                    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email)) {
                        this.errors.email = 'Invalid email format';
                        isValid = false;
                    }
                    if (!this.form.message.trim()) {
                        this.errors.message = 'Message is required';
                        isValid = false;
                    }

                    return isValid;
                },
                async submitForm() {
                    if (!this.validateForm()) return;
                    this.isSubmitting = true;
                    this.success = false;
                    this.error = '';

                    try {
                        // Simulate API call
                        await new Promise(resolve => setTimeout(resolve, 1000));
                        console.log('Form submitted:', this.form);
                        this.success = true;
                        this.form = {
                            name: '',
                            email: '',
                            message: ''
                        };
                    } catch (err) {
                        this.error = 'Failed to send message. Please try again later.';
                    } finally {
                        this.isSubmitting = false;
                    }
                }
            }));

            Alpine.data('testimonials', () => ({
                testimonials: [{
                        name: 'Sarah Mitchell',
                        avatar: '{{ asset("src/img/male2.jpg") }}',
                        role: 'CEO, TechTrend',
                        quote: 'Johns expertise in React and Node.js transformed our apps performance. His attention to detail is unmatched!',
                        rating: 5
                    },
                    {
                        name: 'Michael Chen',
                        avatar: '{{ asset("src/img/male2.jpg") }}',
                        role: 'Product Manager, InnovateCo',
                        quote: 'Working with John was a breeze. He delivered clean, efficient code ahead of schedule.',
                        rating: 4
                    },
                    {
                        name: 'Emily Davis',
                        avatar: '{{ asset("src/img/male2.jpg") }}',
                        role: 'Founder, StartUpX',
                        quote: 'Johns creative solutions and dedication made our project a success. Highly recommend!',
                        rating: 5
                    },
                    {
                        name: 'David Johnson',
                        avatar: '{{ asset("src/img/male2.jpg") }}',
                        role: 'CTO, WebCore Solutions',
                        quote: 'John brought fresh ideas and robust architecture to our development team. Hes a true professional.',
                        rating: 5
                    },
                    {
                        name: 'Anna Lee',
                        avatar: '{{ asset("src/img/male2.jpg") }}',
                        role: 'Design Lead, Creativa',
                        quote: 'His collaboration with the design team was seamless. The final UI exceeded expectations!',
                        rating: 4
                    },
                    {
                        name: 'Vivian Gomez',
                        avatar: '{{ asset("src/img/male2.jpg") }}',
                        role: 'Marketing Director, BrandReach',
                        quote: 'From code quality to communication, John delivers top-tier results every time.',
                        rating: 5
                    }
                ],
            }));

            Alpine.data('blogPosts', () => ({
                posts: [{
                        title: 'Mastering React Hooks: A Deep Dive',
                        excerpt: 'Explore the power of React Hooks to manage state and side effects in functional components, with practical examples and best practices.',
                        image: '{{ asset("src/img/project1.jpg") }}',
                        url: 'blog-detail.html',
                        date: 'May 10, 2025',
                        tags: ['React', 'JavaScript', 'Frontend']
                    },
                    {
                        title: 'Scaling Node.js Apps with Docker',
                        excerpt: 'Learn how to containerize Node.js applications using Docker for seamless deployment and scalability in production environments.',
                        image: '{{ asset("src/img/project2.jpg") }}',
                        url: 'blog-detail.html',
                        date: 'April 25, 2025',
                        tags: ['Node.js', 'Docker', 'DevOps']
                    },
                    {
                        title: 'Why TailwindCSS Changed My Workflow',
                        excerpt: 'Discover how TailwindCSS streamlines frontend development with utility-first styling, boosting productivity and maintainability.',
                        image: '{{ asset("src/img/project3.jpg") }}',
                        url: 'blog-detail.html',
                        date: 'April 15, 2025',
                        tags: ['TailwindCSS', 'CSS', 'Frontend']
                    }
                ]
            }));
        });

        document.addEventListener('DOMContentLoaded', () => {
            // Typing effect
            const texts = {
                1: 'DevOS v4.2.0',
                2: 'ThinkPad X1 Carbon',
                3: '5.15.0-dev',
                4: '45 days, 17 hours',
                5: 'JavaScript, Python, Go',
                6: 'VSCode / Neovim',
                7: 'React, Next.js, TailwindCSS'
            };
            const elements = document.querySelectorAll('[data-typing]');
            let currentIndex = 0;

            function typeText(element, text, callback) {
                let i = 0;
                element.classList.add('typing');
                const interval = setInterval(() => {
                    if (i < text.length) {
                        element.textContent += text.charAt(i);
                        i++;
                    } else {
                        clearInterval(interval);
                        element.classList.remove('typing');
                        callback();
                    }
                }, 50);
            }

            function startTyping() {
                if (currentIndex < elements.length) {
                    const element = elements[currentIndex];
                    const text = texts[element.getAttribute('data-typing')];
                    typeText(element, text, () => {
                        currentIndex++;
                        startTyping();
                    });
                }
            }
            startTyping();

            // GLightbox placeholder
            if (typeof GLightbox !== 'undefined') {
                const lightbox = GLightbox({
                    touchNavigation: true,
                    loop: true,
                    autoplayVideos: true,
                    zoomable: true,
                    draggable: true,
                    selector: '.glightbox'
                });
            }

            // Marquee
            try {
                const marquee = document.getElementById('marquee');
                if (marquee && marquee.innerHTML !== undefined) {
                    const marqueeContent = marquee.innerHTML;
                    marquee.innerHTML += marqueeContent;
                    const marqueeItems = marquee.children;
                    let totalWidth = 0;

                    for (let item of marqueeItems) {
                        totalWidth += item.offsetWidth + 32; // Include gap-8 (32px)
                    }
                    marquee.style.width = `${totalWidth}px`;
                    // Add hover stop functionality
                    marquee.addEventListener('mouseenter', () => {
                        marquee.style.animationPlayState = 'paused';
                    });
                    marquee.addEventListener('mouseleave', () => {
                        marquee.style.animationPlayState = 'running';
                    });
                }
            } catch (error) {
                console.log('Marquee initialization skipped:', error.message);
            }

            // Back to top and smooth scroll
            const backToTopButton = document.getElementById('back-to-top');
            if (backToTopButton) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 300) {
                        backToTopButton.style.display = 'block';
                        backToTopButton.classList.remove('opacity-0', 'invisible');
                        backToTopButton.classList.add('opacity-100', 'visible');
                    } else {
                        backToTopButton.classList.remove('opacity-100', 'visible');
                        backToTopButton.classList.add('opacity-0', 'invisible');
                        setTimeout(() => {
                            if (window.scrollY <= 300) {
                                backToTopButton.style.display = 'none';
                            }
                        }, 300);
                    }
                    checkCurrentSection();
                });
                backToTopButton.addEventListener('click', () => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                    setActiveLink('home');
                });
            }

            // add active link
            const navLinks = document.querySelectorAll('a[data-type="smooth"]');
            const sections = document.querySelectorAll('section[id]');

            const removeActiveClasses = () => {
                navLinks.forEach(link => link.classList.remove('active'));
            };
            const setActiveLink = (targetId) => {
                removeActiveClasses();
                const activeLink = Array.from(navLinks).find(link => link.getAttribute('href') ===
                    `#${targetId}`);
                if (activeLink) activeLink.classList.add('active');
            };
            const checkCurrentSection = () => {
                if (sections.length === 0) return;
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 80; // Adjust for header height
                    const sectionHeight = section.clientHeight;
                    if (window.pageYOffset >= sectionTop && window.pageYOffset < sectionTop +
                        sectionHeight) {
                        current = section.getAttribute('id');
                    }
                });
                if (current) {
                    setActiveLink(current);
                } else if (sections.length > 0 && window.pageYOffset < sections[0].offsetTop - 80) {
                    setActiveLink('home');
                }
            };
            navLinks.forEach(anchor => {
                anchor.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetId = anchor.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        const yOffset = -70; // Offset for fixed header
                        const y = targetElement.getBoundingClientRect().top + window.pageYOffset +
                            yOffset;
                        window.scrollTo({
                            top: y,
                            behavior: 'smooth'
                        });
                        setActiveLink(targetId);
                    }
                });
            });
            const initializeActiveLink = () => {
                const hash = window.location.hash.substring(1);
                if (hash && document.getElementById(hash)) {
                    setActiveLink(hash);
                    const targetElement = document.getElementById(hash);
                    const yOffset = -70;
                    const y = targetElement.getBoundingClientRect().top + window.pageYOffset + yOffset;
                    window.scrollTo({
                        top: y,
                        behavior: 'instant'
                    });
                } else {
                    checkCurrentSection();
                }
            };

            initializeActiveLink();
            window.addEventListener('hashchange', initializeActiveLink);
        });
    </script>
