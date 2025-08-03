<?php
/**
 * Template Name: Contact
 *
 * @package Photographer_Pro
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="main-content">
        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
            <?php if (get_field('contact_subtitle')) : ?>
                <p class="page-subtitle"><?php echo esc_html(get_field('contact_subtitle')); ?></p>
            <?php endif; ?>
        </header>

        <div class="contact-content">
            <div class="contact-info">
                <h2>Get In Touch</h2>
                <p>I'd love to hear from you! Whether you're interested in booking a session or just want to say hello, feel free to reach out.</p>
                
                <div class="contact-details">
                    <div class="contact-item">
                        <div class="contact-icon">📧</div>
                        <div class="contact-text">
                            <h3>Email</h3>
                            <p><?php echo get_field('contact_email') ?: 'hello@photographer.com'; ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">📞</div>
                        <div class="contact-text">
                            <h3>Phone</h3>
                            <p><?php echo get_field('contact_phone') ?: '+1 (555) 123-4567'; ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">📍</div>
                        <div class="contact-text">
                            <h3>Location</h3>
                            <p><?php echo get_field('contact_address') ?: '123 Photography St, City, State 12345'; ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">⏰</div>
                        <div class="contact-text">
                            <h3>Hours</h3>
                            <p><?php echo get_field('contact_hours') ?: 'Monday - Friday: 9AM - 6PM<br>Saturday: 10AM - 4PM<br>Sunday: By appointment'; ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="social-links">
                    <h3>Follow Me</h3>
                    <div class="social-icons">
                        <?php if (get_field('social_instagram')) : ?>
                            <a href="<?php echo esc_url(get_field('social_instagram')); ?>" target="_blank" rel="noopener" class="social-icon">📷 Instagram</a>
                        <?php endif; ?>
                        <?php if (get_field('social_facebook')) : ?>
                            <a href="<?php echo esc_url(get_field('social_facebook')); ?>" target="_blank" rel="noopener" class="social-icon">📘 Facebook</a>
                        <?php endif; ?>
                        <?php if (get_field('social_twitter')) : ?>
                            <a href="<?php echo esc_url(get_field('social_twitter')); ?>" target="_blank" rel="noopener" class="social-icon">🐦 Twitter</a>
                        <?php endif; ?>
                        <?php if (get_field('social_pinterest')) : ?>
                            <a href="<?php echo esc_url(get_field('social_pinterest')); ?>" target="_blank" rel="noopener" class="social-icon">📌 Pinterest</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="contact-form-container">
                <h2>Send Me a Message</h2>
                <form class="contact-form" method="post" action="">
                    <?php wp_nonce_field('contact_form_nonce', 'contact_nonce'); ?>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    
                    <div class="form-group">
                        <label for="service">Service Interested In</label>
                        <select id="service" name="service">
                            <option value="">Select a service</option>
                            <option value="wedding">Wedding Photography</option>
                            <option value="portrait">Portrait Session</option>
                            <option value="event">Event Photography</option>
                            <option value="landscape">Landscape Photography</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="date">Preferred Date</label>
                        <input type="date" id="date" name="date">
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" rows="5" required placeholder="Tell me about your project or what you're looking for..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<style>
/* Contact Page Styles */
.contact-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    margin-top: 3rem;
}

.contact-info h2,
.contact-form-container h2 {
    margin-bottom: 1.5rem;
    color: #1a1a1a;
}

.contact-info p {
    margin-bottom: 2rem;
    color: #666;
    line-height: 1.8;
}

.contact-details {
    margin-bottom: 2rem;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.contact-item:hover {
    transform: translateY(-2px);
}

.contact-icon {
    font-size: 1.5rem;
    margin-right: 1rem;
    margin-top: 0.25rem;
}

.contact-text h3 {
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
    color: #1a1a1a;
}

.contact-text p {
    margin: 0;
    color: #666;
}

.social-links {
    margin-top: 2rem;
}

.social-links h3 {
    margin-bottom: 1rem;
    color: #1a1a1a;
}

.social-icons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.social-icon {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: #007acc;
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-size: 0.9rem;
    transition: background 0.3s ease;
}

.social-icon:hover {
    background: #005a9e;
    color: white;
}

/* Contact Form Styles */
.contact-form-container {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.contact-form {
    max-width: 100%;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #1a1a1a;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 12px;
    border: 2px solid #e1e1e1;
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
    font-family: inherit;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #007acc;
}

.form-group textarea {
    resize: vertical;
    min-height: 120px;
}

.contact-form .btn {
    width: 100%;
    padding: 15px;
    font-size: 1.1rem;
    background: #007acc;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.contact-form .btn:hover {
    background: #005a9e;
}

/* Success/Error Messages */
.form-message {
    padding: 1rem;
    border-radius: 6px;
    margin-bottom: 1rem;
}

.form-message.success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.form-message.error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Responsive Design */
@media (max-width: 768px) {
    .contact-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .social-icons {
        justify-content: center;
    }
    
    .contact-form-container {
        padding: 1.5rem;
    }
}

@media (max-width: 480px) {
    .contact-item {
        flex-direction: column;
        text-align: center;
    }
    
    .contact-icon {
        margin-right: 0;
        margin-bottom: 0.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('.contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            formData.append('action', 'handle_contact_form');
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Sending...';
            submitBtn.disabled = true;
            
            // Send form data via AJAX
            fetch(ajaxurl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Thank you! Your message has been sent successfully.', 'success');
                    contactForm.reset();
                } else {
                    showMessage('Sorry, there was an error sending your message. Please try again.', 'error');
                }
            })
            .catch(error => {
                showMessage('Sorry, there was an error sending your message. Please try again.', 'error');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    }
    
    function showMessage(message, type) {
        // Remove existing messages
        const existingMessage = document.querySelector('.form-message');
        if (existingMessage) {
            existingMessage.remove();
        }
        
        // Create new message
        const messageDiv = document.createElement('div');
        messageDiv.className = `form-message ${type}`;
        messageDiv.textContent = message;
        
        // Insert before form
        contactForm.insertBefore(messageDiv, contactForm.firstChild);
        
        // Remove message after 5 seconds
        setTimeout(() => {
            messageDiv.remove();
        }, 5000);
    }
});
</script>

<?php get_footer(); ?>