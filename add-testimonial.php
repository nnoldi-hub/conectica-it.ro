<?php
require_once 'includes/init.php';

$success_message = '';
$error_message = '';

// Handle form submission
if ($_POST) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $testimonial = trim($_POST['testimonial'] ?? '');
    $rating = intval($_POST['rating'] ?? 5);
    $project_details = trim($_POST['project_details'] ?? '');
    $consent = isset($_POST['consent']);
    
    // Validation
    if (empty($name) || empty($email) || empty($testimonial)) {
        $error_message = 'Numele, emailul și testimonialul sunt obligatorii!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Adresa de email nu este validă!';
    } elseif (strlen($testimonial) < 50) {
        $error_message = 'Testimonialul trebuie să aibă cel puțin 50 de caractere!';
    } elseif (!$consent) {
        $error_message = 'Trebuie să fii de acord cu publicarea testimonialului!';
    } else {
        try {
            // Generate unique token for approval
            $approval_token = bin2hex(random_bytes(32));
            
            $stmt = $pdo->prepare("INSERT INTO testimonials (
                client_name, client_email, client_company, client_position, 
                testimonial, rating, project_details, approval_token, 
                status, created_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");
            
            if ($stmt->execute([
                $name, $email, $company, $position, 
                $testimonial, $rating, $project_details, $approval_token
            ])) {
                $success_message = 'Mulțumesc pentru testimonial! Va fi revizuit și publicat în curând.';
                
                // Clear form data on success
                $_POST = [];
            } else {
                $error_message = 'Eroare la salvarea testimonialului. Te rog încearcă din nou!';
            }
        } catch (PDOException $e) {
            $error_message = 'Eroare la baza de date. Te rog încearcă din nou mai târziu!';
            error_log("Testimonial submission error: " . $e->getMessage());
        }
    }
}

// SEO and page info
$page_title = "Adaugă Testimonial - Conectica IT";
$page_description = "Împărtășește-ți experiența de colaborare cu Conectica IT. Testimonialul tău ajută alți clienți să ia decizia potrivită.";
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="robots" content="noindex, nofollow">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .testimonial-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .testimonial-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .card-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .card-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0;
        }
        
        .form-section {
            padding: 40px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-control, .form-select {
            border: 2px solid rgba(52, 152, 219, 0.2);
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        .rating-group {
            display: flex;
            gap: 5px;
            align-items: center;
        }
        
        .star-rating {
            display: flex;
            gap: 2px;
        }
        
        .star {
            font-size: 1.5rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .star.active {
            color: #f39c12;
        }
        
        .star:hover {
            color: #f39c12;
        }
        
        .consent-section {
            background: rgba(52, 152, 219, 0.05);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            border: none;
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn-submit:hover {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(39, 174, 96, 0.3);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-success {
            background: rgba(39, 174, 96, 0.1);
            color: #27ae60;
            border-left: 4px solid #27ae60;
        }
        
        .alert-danger {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
            border-left: 4px solid #e74c3c;
        }
        
        .back-link {
            position: absolute;
            top: 20px;
            left: 20px;
            color: white;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .back-link:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }
        
        .form-text {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-top: 5px;
        }
        
        @media (max-width: 768px) {
            .testimonial-container {
                padding: 10px;
            }
            
            .form-section {
                padding: 20px;
            }
            
            .card-header {
                padding: 20px;
            }
            
            .card-header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <a href="index.php" class="back-link">
        <i class="fas fa-arrow-left"></i> Înapoi la Site
    </a>
    
    <div class="testimonial-container">
        <div class="testimonial-card">
            <div class="card-header">
                <h1><i class="fas fa-quote-left"></i> Adaugă Testimonial</h1>
                <p>Împărtășește-ți experiența de colaborare cu noi</p>
            </div>
            
            <div class="form-section">
                <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
                <?php endif; ?>
                
                <form method="POST" id="testimonialForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">
                                    <i class="fas fa-user"></i>
                                    Numele tău *
                                </label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" 
                                       placeholder="Ex: Ion Popescu" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope"></i>
                                    Email *
                                </label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" 
                                       placeholder="ion@example.com" required>
                                <div class="form-text">Emailul nu va fi afișat public</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company">
                                    <i class="fas fa-building"></i>
                                    Compania
                                </label>
                                <input type="text" class="form-control" id="company" name="company" 
                                       value="<?php echo htmlspecialchars($_POST['company'] ?? ''); ?>" 
                                       placeholder="Ex: ABC Solutions SRL">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="position">
                                    <i class="fas fa-briefcase"></i>
                                    Poziția
                                </label>
                                <input type="text" class="form-control" id="position" name="position" 
                                       value="<?php echo htmlspecialchars($_POST['position'] ?? ''); ?>" 
                                       placeholder="Ex: Manager, Fondator, CTO">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="rating">
                            <i class="fas fa-star"></i>
                            Evaluarea colaborării
                        </label>
                        <div class="rating-group">
                            <div class="star-rating" id="starRating">
                                <span class="star" data-rating="1">★</span>
                                <span class="star" data-rating="2">★</span>
                                <span class="star" data-rating="3">★</span>
                                <span class="star" data-rating="4">★</span>
                                <span class="star" data-rating="5">★</span>
                            </div>
                            <span id="ratingText" class="ms-2">Excelent</span>
                        </div>
                        <input type="hidden" id="rating" name="rating" value="5">
                    </div>
                    
                    <div class="form-group">
                        <label for="project_details">
                            <i class="fas fa-project-diagram"></i>
                            Detalii despre proiect (opțional)
                        </label>
                        <input type="text" class="form-control" id="project_details" name="project_details" 
                               value="<?php echo htmlspecialchars($_POST['project_details'] ?? ''); ?>" 
                               placeholder="Ex: Website e-commerce, Aplicație web custom, etc.">
                    </div>
                    
                    <div class="form-group">
                        <label for="testimonial">
                            <i class="fas fa-quote-right"></i>
                            Testimonialul tău *
                        </label>
                        <textarea class="form-control" id="testimonial" name="testimonial" rows="6" 
                                  placeholder="Descrie experiența ta de colaborare cu noi. Ce ți-a plăcut cel mai mult? Cum a fost comunicarea? Ai recomanda serviciile noastre?" 
                                  required><?php echo htmlspecialchars($_POST['testimonial'] ?? ''); ?></textarea>
                        <div class="form-text">Minimum 50 de caractere. Sé sincer și specific!</div>
                        <div id="charCount" class="form-text">0 caractere</div>
                    </div>
                    
                    <div class="consent-section">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="consent" name="consent" required>
                            <label class="form-check-label" for="consent">
                                <strong>Sunt de acord</strong> ca testimonialul meu să fie publicat pe website-ul Conectica IT. 
                                Înțeleg că numele, compania și poziția pot fi afișate public pentru a oferi credibilitate testimonialului.
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-paper-plane"></i>
                        Trimite Testimonialul
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Star rating functionality
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating');
        const ratingText = document.getElementById('ratingText');
        
        const ratingTexts = {
            1: 'Foarte slab',
            2: 'Slab', 
            3: 'Acceptabil',
            4: 'Bun',
            5: 'Excelent'
        };
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.dataset.rating);
                ratingInput.value = rating;
                ratingText.textContent = ratingTexts[rating];
                
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });
            
            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.dataset.rating);
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.style.color = '#f39c12';
                    } else {
                        s.style.color = '#ddd';
                    }
                });
            });
        });
        
        document.querySelector('.star-rating').addEventListener('mouseleave', function() {
            const currentRating = parseInt(ratingInput.value);
            stars.forEach((s, index) => {
                if (index < currentRating) {
                    s.style.color = '#f39c12';
                } else {
                    s.style.color = '#ddd';
                }
            });
        });
        
        // Initialize rating display
        const currentRating = parseInt(ratingInput.value);
        stars.forEach((s, index) => {
            if (index < currentRating) {
                s.classList.add('active');
            }
        });
        
        // Character counter
        const testimonialTextarea = document.getElementById('testimonial');
        const charCount = document.getElementById('charCount');
        
        testimonialTextarea.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count + ' caractere';
            
            if (count < 50) {
                charCount.style.color = '#e74c3c';
            } else {
                charCount.style.color = '#27ae60';
            }
        });
        
        // Initial character count
        charCount.textContent = testimonialTextarea.value.length + ' caractere';
        
        // Form validation
        document.getElementById('testimonialForm').addEventListener('submit', function(e) {
            const testimonial = document.getElementById('testimonial').value;
            const consent = document.getElementById('consent').checked;
            
            if (testimonial.length < 50) {
                e.preventDefault();
                alert('Testimonialul trebuie să aibă cel puțin 50 de caractere!');
                return;
            }
            
            if (!consent) {
                e.preventDefault();
                alert('Trebuie să fii de acord cu publicarea testimonialului!');
                return;
            }
        });
    </script>
</body>
</html>
