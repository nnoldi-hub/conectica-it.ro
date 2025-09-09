<?php
require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../AuthSystem.php';

// Auth with bootstrap-provided PDO
$auth = new AuthSystem(isset($pdo) ? $pdo : null);
$auth->requireAuth();

$user = $auth->getCurrentUser();
$username = $user['username'] ?? $_SESSION['admin_username'] ?? 'admin';
$success_message = '';
$error_message = '';

// Handle form submissions
if ($_POST) {
    if (!$auth->validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $error_message = 'Token de securitate invalid!';
    } else {
        $action = $_POST['action'] ?? '';
        
        if ($action === 'update_profile') {
            // Update profile information
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $bio = trim($_POST['bio'] ?? '');
            
            // Validation
            if (empty($name) || empty($email)) {
                $error_message = 'Numele și emailul sunt obligatorii!';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_message = 'Adresa de email nu este validă!';
            } else {
                try {
                    $stmt = $pdo->prepare("UPDATE admins SET name = ?, email = ?, phone = ?, bio = ?, updated_at = NOW() WHERE username = ?");
                    if ($stmt->execute([$name, $email, $phone, $bio, $username])) {
                        // Refresh user data in session
                        $auth->refreshUserData();
                        $success_message = 'Profilul a fost actualizat cu succes!';
                    } else {
                        $error_message = 'Eroare la actualizarea profilului!';
                    }
                } catch (PDOException $e) {
                    $error_message = 'Eroare la baza de date: ' . $e->getMessage();
                }
            }
        } elseif ($action === 'change_password') {
            // Change password
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            // Validation
            if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                $error_message = 'Toate câmpurile pentru parolă sunt obligatorii!';
            } elseif ($new_password !== $confirm_password) {
                $error_message = 'Parola nouă și confirmarea nu coincid!';
            } elseif (strlen($new_password) < 6) {
                $error_message = 'Parola nouă trebuie să aibă cel puțin 6 caractere!';
            } else {
                // Verify current password against database
                try {
                    $stmt = $pdo->prepare("SELECT password_hash FROM admins WHERE username = ?");
                    $stmt->execute([$username]);
                    $user_data = $stmt->fetch();
                    
                    if (!$user_data || !password_verify($current_password, $user_data['password_hash'])) {
                        $error_message = 'Parola actuală nu este corectă!';
                    } else {
                        // Update password
                        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                        $stmt = $pdo->prepare("UPDATE admins SET password_hash = ?, updated_at = NOW() WHERE username = ?");
                        if ($stmt->execute([$password_hash, $username])) {
                            $success_message = 'Parola a fost schimbată cu succes!';
                        } else {
                            $error_message = 'Eroare la schimbarea parolei!';
                        }
                    }
                } catch (PDOException $e) {
                    $error_message = 'Eroare la baza de date: ' . $e->getMessage();
                }
            }
        } elseif ($action === 'upload_avatar') {
            // Debug upload information
            error_log("Avatar upload attempt - Username: " . $username);
            error_log("FILES data: " . print_r($_FILES, true));
            
            // Handle avatar upload
            if (isset($_FILES['avatar'])) {
                $upload_error = $_FILES['avatar']['error'];
                error_log("Upload error code: " . $upload_error);
                
                if ($upload_error !== UPLOAD_ERR_OK) {
                    switch ($upload_error) {
                        case UPLOAD_ERR_INI_SIZE:
                        case UPLOAD_ERR_FORM_SIZE:
                            $error_message = 'Fișierul este prea mare!';
                            break;
                        case UPLOAD_ERR_PARTIAL:
                            $error_message = 'Fișierul a fost încărcat doar parțial!';
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            $error_message = 'Nu a fost selectat niciun fișier!';
                            break;
                        default:
                            $error_message = 'Eroare la încărcarea fișierului! Cod: ' . $upload_error;
                    }
                    error_log("Upload error: " . $error_message);
                } else {
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    $max_size = 5 * 1024 * 1024; // 5MB
                    
                    $file = $_FILES['avatar'];
                    $file_type = $file['type'];
                    $file_size = $file['size'];
                    $file_tmp = $file['tmp_name'];
                    
                    if (!in_array($file_type, $allowed_types)) {
                        $error_message = 'Tipul de fișier nu este permis! Folosește JPG, PNG, GIF sau WebP.';
                    } elseif ($file_size > $max_size) {
                        $error_message = 'Fișierul este prea mare! Dimensiunea maximă este 5MB.';
                    } else {
                        // Create uploads directory if it doesn't exist
                        $upload_dir = '../../uploads/avatars/';
                        error_log("Upload directory: " . $upload_dir);
                        error_log("Directory exists: " . (is_dir($upload_dir) ? 'yes' : 'no'));
                        
                        if (!is_dir($upload_dir)) {
                            if (!mkdir($upload_dir, 0755, true)) {
                                $error_message = 'Nu s-a putut crea directorul pentru upload!';
                                error_log("Failed to create upload directory");
                            } else {
                                error_log("Upload directory created successfully");
                            }
                        }
                        
                        if (!isset($error_message)) {
                            // Generate unique filename
                            $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                            $filename = 'avatar_' . $username . '_' . time() . '.' . $file_extension;
                            $file_path = $upload_dir . $filename;
                            
                            error_log("Attempting to move file to: " . $file_path);
                            error_log("Source temp file: " . $file_tmp);
                            
                            if (move_uploaded_file($file_tmp, $file_path)) {
                                error_log("File uploaded successfully to: " . $file_path);
                        // Remove old avatar if exists
                        try {
                            $stmt = $pdo->prepare("SELECT avatar FROM admins WHERE username = ?");
                            $stmt->execute([$username]);
                            $old_avatar = $stmt->fetchColumn();
                            
                            if ($old_avatar && file_exists('../../' . $old_avatar)) {
                                unlink('../../' . $old_avatar);
                            }
                        } catch (Exception $e) {
                            // Ignore error if old avatar doesn't exist
                        }
                        
                        // Update database
                        $avatar_path = 'uploads/avatars/' . $filename;
                        error_log("Updating database with avatar path: " . $avatar_path);
                        
                        try {
                            $stmt = $pdo->prepare("UPDATE admins SET avatar = ?, updated_at = NOW() WHERE username = ?");
                            if ($stmt->execute([$avatar_path, $username])) {
                                error_log("Database updated successfully");
                                
                                // Refresh user data in session
                                $refresh_result = $auth->refreshUserData();
                                error_log("Session refresh result: " . ($refresh_result ? 'success' : 'failed'));
                                
                                $success_message = 'Poza de profil a fost actualizată cu succes!';
                            } else {
                                $error_message = 'Eroare la actualizarea pozei de profil în baza de date!';
                                error_log("Database update failed");
                                // Delete uploaded file if database update failed
                                if (file_exists($file_path)) {
                                    unlink($file_path);
                                }
                            }
                        } catch (PDOException $e) {
                            $error_message = 'Eroare la baza de date: ' . $e->getMessage();
                            // Delete uploaded file if database update failed
                            if (file_exists($file_path)) {
                                unlink($file_path);
                            }
                        }
                    } else {
                        $error_message = 'Eroare la încărcarea fișierului! Nu s-a putut muta în directorul de destinație.';
                    }
                        }
                    }
                }
            } else {
                $error_message = 'Nu a fost selectat niciun fișier pentru upload!';
            }
        }
    }
}

// Get current admin data from database
try {
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin_data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // If no data in database, use session data as fallback
    if (!$admin_data) {
        $admin_data = [
            'username' => $username,
            'name' => $user['name'] ?? '',
            'email' => $user['email'] ?? '',
            'phone' => $user['phone'] ?? '',
            'bio' => $user['bio'] ?? '',
            'avatar' => $user['avatar'] ?? '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
    }
} catch (PDOException $e) {
    $error_message = 'Eroare la încărcarea datelor: ' . $e->getMessage();
    $admin_data = [
        'username' => $username,
        'name' => $user['name'] ?? '',
        'email' => $user['email'] ?? '',
        'phone' => $user['phone'] ?? '',
        'bio' => $user['bio'] ?? '',
        'avatar' => $user['avatar'] ?? '',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
}

$csrf_token = $auth->generateCSRFToken();
?>

<div class="profile-management">
    <div class="page-header">
        <h2><i class="fas fa-user-cog"></i> Profilul Meu</h2>
        <p>Gestionează informațiile personale și setările contului</p>
    </div>

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

    <div class="profile-sections">
        <!-- Avatar Section -->
        <div class="profile-card avatar-section">
            <h3><i class="fas fa-image"></i> Poză de Profil</h3>
            
            <div class="avatar-display">
                <div class="avatar-container">
                    <?php if (!empty($admin_data['avatar']) && file_exists('../../' . $admin_data['avatar'])): ?>
                        <img src="../../<?php echo htmlspecialchars($admin_data['avatar']); ?>" 
                             alt="Avatar" class="current-avatar">
                    <?php else: ?>
                        <div class="avatar-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    <?php endif; ?>
                </div>
                
                <form method="POST" enctype="multipart/form-data" class="avatar-upload-form">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                    <input type="hidden" name="action" value="upload_avatar">
                    
                    <div class="file-input-wrapper">
                        <input type="file" name="avatar" id="avatar" accept="image/*" class="file-input">
                        <label for="avatar" class="file-label">
                            <i class="fas fa-camera"></i>
                            Alege Imagine
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i>
                        Încarcă
                    </button>
                </form>
            </div>
        </div>

        <!-- Profile Information -->
        <div class="profile-card info-section">
            <h3><i class="fas fa-info-circle"></i> Informații Personale</h3>
            
            <form method="POST" class="profile-form">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                <input type="hidden" name="action" value="update_profile">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">
                            <i class="fas fa-user"></i>
                            Nume Complet
                        </label>
                        <input type="text" id="name" name="name" 
                               value="<?php echo htmlspecialchars($admin_data['name'] ?? ''); ?>" 
                               placeholder="Numele tău complet" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Adresa Email
                        </label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo htmlspecialchars($admin_data['email'] ?? ''); ?>" 
                               placeholder="email@example.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">
                            <i class="fas fa-phone"></i>
                            Telefon
                        </label>
                        <input type="tel" id="phone" name="phone" 
                               value="<?php echo htmlspecialchars($admin_data['phone'] ?? ''); ?>" 
                               placeholder="+40 xxx xxx xxx">
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="bio">
                            <i class="fas fa-quote-left"></i>
                            Descriere Scurtă
                        </label>
                        <textarea id="bio" name="bio" rows="4" 
                                  placeholder="O scurtă descriere despre tine..."><?php echo htmlspecialchars($admin_data['bio'] ?? ''); ?></textarea>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Salvează Modificările
                    </button>
                </div>
            </form>
        </div>

        <!-- Password Change -->
        <div class="profile-card password-section">
            <h3><i class="fas fa-lock"></i> Schimbare Parolă</h3>
            
            <form method="POST" class="password-form">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                <input type="hidden" name="action" value="change_password">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="current_password">
                            <i class="fas fa-key"></i>
                            Parola Actuală
                        </label>
                        <input type="password" id="current_password" name="current_password" 
                               placeholder="Introdu parola actuală" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">
                            <i class="fas fa-lock"></i>
                            Parola Nouă
                        </label>
                        <input type="password" id="new_password" name="new_password" 
                               placeholder="Parola nouă (min. 6 caractere)" required>
                        <div class="password-strength" id="password-strength"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">
                            <i class="fas fa-lock"></i>
                            Confirmă Parola
                        </label>
                        <input type="password" id="confirm_password" name="confirm_password" 
                               placeholder="Confirmă parola nouă" required>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-shield-alt"></i>
                        Schimbă Parola
                    </button>
                </div>
            </form>
        </div>

        <!-- Account Information -->
        <div class="profile-card account-info">
            <h3><i class="fas fa-info"></i> Informații Cont</h3>
            
            <div class="info-grid">
                <div class="info-item">
                    <label>Username:</label>
                    <span><?php echo htmlspecialchars($admin_data['username'] ?? 'admin'); ?></span>
                </div>
                
                <div class="info-item">
                    <label>Creat la:</label>
                    <span><?php echo date('d.m.Y H:i', strtotime($admin_data['created_at'] ?? 'now')); ?></span>
                </div>
                
                <div class="info-item">
                    <label>Ultima actualizare:</label>
                    <span><?php echo date('d.m.Y H:i', strtotime($admin_data['updated_at'] ?? 'now')); ?></span>
                </div>
                
                <div class="info-item">
                    <label>IP-ul curent:</label>
                    <span><?php echo htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? 'unknown'); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-management {
    padding: 0;
}

.page-header {
    margin-bottom: 30px;
    text-align: center;
}

.page-header h2 {
    color: #2c3e50;
    margin-bottom: 10px;
    font-size: 2.2rem;
}

.page-header p {
    color: #7f8c8d;
    font-size: 1.1rem;
}

.profile-sections {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
    margin-bottom: 30px;
}

.profile-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.profile-card h3 {
    color: #2c3e50;
    margin-bottom: 20px;
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Avatar Section */
.avatar-section {
    grid-column: 1 / 2;
}

.avatar-display {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.avatar-container {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid #3498db;
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
}

.current-avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #3498db, #2980b9);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 3rem;
}

.avatar-upload-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
    align-items: center;
}

.file-input-wrapper {
    position: relative;
}

.file-input {
    opacity: 0;
    position: absolute;
    z-index: -1;
}

.file-label {
    display: inline-block;
    padding: 12px 20px;
    background: linear-gradient(135deg, #95a5a6, #7f8c8d);
    color: white;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 600;
}

.file-label:hover {
    background: linear-gradient(135deg, #7f8c8d, #95a5a6);
    transform: translateY(-2px);
}

/* Profile Information */
.info-section {
    grid-column: 2 / 3;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 25px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    color: #2c3e50;
    margin-bottom: 8px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-group input,
.form-group textarea {
    padding: 12px 15px;
    border: 2px solid rgba(52, 152, 219, 0.2);
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
}

/* Password Section */
.password-section {
    grid-column: 1 / -1;
}

.password-strength {
    height: 4px;
    background: #ecf0f1;
    border-radius: 2px;
    margin-top: 5px;
    overflow: hidden;
}

.password-strength.weak {
    background: linear-gradient(to right, #e74c3c 30%, #ecf0f1 30%);
}

.password-strength.medium {
    background: linear-gradient(to right, #f39c12 60%, #ecf0f1 60%);
}

.password-strength.strong {
    background: linear-gradient(to right, #27ae60 100%, #ecf0f1 100%);
}

/* Account Info */
.account-info {
    grid-column: 1 / -1;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background: rgba(52, 152, 219, 0.1);
    border-radius: 8px;
}

.info-item label {
    font-weight: 600;
    color: #2c3e50;
}

.info-item span {
    color: #3498db;
    font-weight: 500;
}

.form-actions {
    text-align: center;
}

.btn {
    padding: 12px 25px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 1rem;
}

.btn-primary {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2980b9, #3498db);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
}

.btn-warning {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #e67e22, #f39c12);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(243, 156, 18, 0.3);
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 500;
}

.alert-success {
    background: rgba(39, 174, 96, 0.1);
    color: #27ae60;
    border: 1px solid rgba(39, 174, 96, 0.3);
}

.alert-danger {
    background: rgba(231, 76, 60, 0.1);
    color: #e74c3c;
    border: 1px solid rgba(231, 76, 60, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .profile-sections {
        grid-template-columns: 1fr;
    }
    
    .profile-card {
        grid-column: 1 / -1 !important;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Password strength checker
document.getElementById('new_password').addEventListener('input', function() {
    const password = this.value;
    const strengthBar = document.getElementById('password-strength');
    
    if (password.length === 0) {
        strengthBar.className = 'password-strength';
        return;
    }
    
    let strength = 0;
    if (password.length >= 6) strength++;
    if (password.match(/[a-z]/)) strength++;
    if (password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^a-zA-Z0-9]/)) strength++;
    
    if (strength <= 2) {
        strengthBar.className = 'password-strength weak';
    } else if (strength <= 3) {
        strengthBar.className = 'password-strength medium';
    } else {
        strengthBar.className = 'password-strength strong';
    }
});

// Confirm password validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = this.value;
    
    if (confirmPassword && newPassword !== confirmPassword) {
        this.style.borderColor = '#e74c3c';
    } else {
        this.style.borderColor = '';
    }
});

// Avatar preview
document.getElementById('avatar').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const avatarContainer = document.querySelector('.avatar-container');
            avatarContainer.innerHTML = '<img src="' + e.target.result + '" alt="Preview" class="current-avatar">';
        };
        reader.readAsDataURL(file);
    }
});

// Form validation
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.style.borderColor = '#e74c3c';
                isValid = false;
            } else {
                field.style.borderColor = '';
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Te rog completează toate câmpurile obligatorii!');
        }
        
        // Additional validation for password form
        if (form.querySelector('[name="action"][value="change_password"]')) {
            const newPassword = form.querySelector('[name="new_password"]').value;
            const confirmPassword = form.querySelector('[name="confirm_password"]').value;
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Parola nouă și confirmarea nu coincid!');
                return;
            }
            
            if (newPassword.length < 6) {
                e.preventDefault();
                alert('Parola nouă trebuie să aibă cel puțin 6 caractere!');
                return;
            }
        }
    });
});
</script>
