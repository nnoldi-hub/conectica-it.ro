<?php
/**
 * Social Media Integration Functions
 * Manages social media settings and display components
 */

// Prevent direct access
if (!defined('CONFIG_LOADED')) {
    http_response_code(403);
    exit('Direct access not allowed');
}

/**
 * Get social media settings from database
 */
function getSocialMediaSettings($pdo) {
    $settings = [
        'facebook' => '',
        'instagram' => '',
        'linkedin' => '',
        'youtube' => ''
    ];
    
    try {
        $stmt = $pdo->prepare("SELECT setting_key, setting_value FROM site_settings WHERE setting_key LIKE 'social_%'");
        $stmt->execute();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $key = str_replace('social_', '', $row['setting_key']);
            $settings[$key] = $row['setting_value'];
        }
    } catch (PDOException $e) {
        error_log("Error loading social media settings: " . $e->getMessage());
    }
    
    return $settings;
}

/**
 * Generate social media icons HTML
 */
function generateSocialMediaIcons($settings, $class = 'social-icons') {
    $icons = [];
    
    $platforms = [
        'facebook' => ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook'],
        'instagram' => ['icon' => 'fab fa-instagram', 'name' => 'Instagram'],
        'linkedin' => ['icon' => 'fab fa-linkedin-in', 'name' => 'LinkedIn'],
        'youtube' => ['icon' => 'fab fa-youtube', 'name' => 'YouTube']
    ];
    
    foreach ($platforms as $platform => $data) {
        if (!empty($settings[$platform])) {
            $url = htmlspecialchars($settings[$platform]);
            $icon = $data['icon'];
            $name = $data['name'];
            
            $icons[] = "<a href=\"$url\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"social-icon social-$platform\" title=\"$name\">
                          <i class=\"$icon\"></i>
                        </a>";
        }
    }
    
    if (empty($icons)) {
        return '';
    }
    
    return "<div class=\"$class\">" . implode("\n", $icons) . "</div>";
}

/**
 * Generate structured data for social media
 */
function generateSocialMediaStructuredData($settings, $companyName = 'Conectica IT') {
    $socialUrls = array_filter($settings);
    
    if (empty($socialUrls)) {
        return '';
    }
    
    $structuredData = [
        "@context" => "https://schema.org",
        "@type" => "Organization",
        "name" => $companyName,
        "sameAs" => array_values($socialUrls)
    ];
    
    return '<script type="application/ld+json">' . json_encode($structuredData, JSON_UNESCAPED_SLASHES) . '</script>';
}

/**
 * Get default social media CSS
 */
function getSocialMediaCSS() {
    return '
<style>
.social-icons {
    display: flex;
    gap: 15px;
    align-items: center;
}

.social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 16px;
}

.social-icon:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.social-facebook {
    background: #1877f2;
}

.social-instagram {
    background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);
}

.social-linkedin {
    background: #0077b5;
}

.social-youtube {
    background: #ff0000;
}

.social-facebook:hover {
    background: #166fe5;
    color: white;
}

.social-instagram:hover {
    background: linear-gradient(45deg, #e8832d 0%,#d65a36 25%,#d01d3d 50%,#c21760 75%,#b01082 100%);
    color: white;
}

.social-linkedin:hover {
    background: #005582;
    color: white;
}

.social-youtube:hover {
    background: #cc0000;
    color: white;
}

/* Footer specific styles */
.footer-social .social-icons {
    justify-content: center;
    margin: 20px 0;
}

.footer-social .social-icon {
    width: 45px;
    height: 45px;
    font-size: 18px;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .social-icons {
        gap: 10px;
    }
    
    .social-icon {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }
    
    .footer-social .social-icon {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }
}
</style>';
}
?>
