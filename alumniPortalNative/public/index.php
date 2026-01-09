<?php
// Bootstrap
require_once __DIR__.'/../app/helpers/csrf.php';
require_once __DIR__.'/../app/helpers/auth.php';
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$base = basename(dirname(__DIR__)); // alumni-portal
if(strpos($uri, $base.'/public')!==false){ $uri = substr($uri, strpos($uri, $base.'/public') + strlen($base.'/public')); $uri = trim($uri,'/'); }
if($uri==='') $uri='/';


// Routes
switch($uri){
    case '/':
    case 'home':
    require_once __DIR__.'/../app/controllers/PublicController.php';
    public_home(); break;
    case 'search':
        require_once __DIR__.'/../app/controllers/PublicController.php';
        public_search(); break;
    case 'login':
        require_once __DIR__.'/../app/controllers/AuthController.php';
        if($_SERVER['REQUEST_METHOD']==='POST' && input('action')==='do_login') do_login();
        else show_login();
        break;

    case 'register':
        require_once __DIR__.'/../app/controllers/AuthController.php';
        if($_SERVER['REQUEST_METHOD']==='POST' && input('action')==='do_register') do_register(); else show_register();
        break;
    case 'logout':
        require_once __DIR__.'/../app/controllers/AuthController.php';
        do_logout(); break;
    case 'alumni/profile':
        require_once __DIR__.'/../app/controllers/AlumniController.php';
        alumni_profile(); break;
    case 'alumni/profile/edit':
        require_once __DIR__.'/../app/controllers/AlumniController.php';
        alumni_profile_edit(); break;
    case 'alumni/profile/update':
        require_once __DIR__.'/../app/controllers/AlumniController.php';
        if($_SERVER['REQUEST_METHOD']==='POST') alumni_profile_update(); else redirect('alumni/profile');
        break;
    case 'admin':
        require_once __DIR__.'/../app/controllers/AdminController.php';
        admin_dashboard(); break;
    case 'admin/pending':
        require_once __DIR__.'/../app/controllers/AdminController.php';
        admin_pending(); break;
    case 'admin/approve':
        require_once __DIR__.'/../app/controllers/AdminController.php';
        admin_approve(); break;
    case 'admin/reject':
        require_once __DIR__.'/../app/controllers/AdminController.php';
        admin_reject(); break;
    case 'admin/alumni':
        require_once __DIR__.'/../app/controllers/AdminController.php';
        admin_alumni_index(); break;
    // detail publik
    case 'alumni/detail':
        require_once __DIR__.'/../app/controllers/PublicController.php';
        public_alumni_detail(); break;

    // admin edit alumni (lihat bagian Admin Controller)
    case 'admin/alumni/edit':
        require_once __DIR__.'/../app/controllers/AdminController.php';
        admin_alumni_edit(); break;

    case 'admin/alumni/update':
        require_once __DIR__.'/../app/controllers/AdminController.php';
        if($_SERVER['REQUEST_METHOD']==='POST') admin_alumni_update(); else redirect('admin/alumni');
    break;

    case 'admin/alumni/delete':
        require_once __DIR__.'/../app/controllers/AdminController.php';
        admin_alumni_delete(); 
        break;

    default:
        http_response_code(404); echo '<div style="padding:2rem;font-family:ui-sans-serif;"><h1>404</h1><p>Halaman tidak ditemukan.</p></div>'; break;
}

