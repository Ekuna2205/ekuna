<?php
include 'db.php';
$msg = "";

// CONTACT FORM
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

        if ($stmt->execute()) {
            $msg = "✅ Message saved!";
        } else {
            $msg = "❌ Error!";
        }
    } else {
        $msg = "⚠ Name, email, message оруулна уу.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekuna | Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <a href="add_project.php">Add Project</a>
<a href="projects.php">Project List</a>
<a href="messages.php">Messages</a>
<a href="dashboard.php">Dashboard</a>
    <style>
        :root{
            --bg:#0b1120;
            --bg2:#111827;
            --card:#172033;
            --text:#ffffff;
            --muted:#cbd5e1;
            --main:#38bdf8;
            --main2:#22d3ee;
            --border:rgba(255,255,255,.08);
            --shadow:0 10px 30px rgba(0,0,0,.35);
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
            scroll-behavior:smooth;
        }

        body{
            background:
                radial-gradient(circle at top left, rgba(56,189,248,.15), transparent 28%),
                radial-gradient(circle at top right, rgba(34,211,238,.12), transparent 25%),
                linear-gradient(135deg, #0b1120, #0f172a 40%, #111827);
            color:var(--text);
            overflow-x:hidden;
        }

        a{
            text-decoration:none;
            color:inherit;
        }

        img{
            max-width:100%;
            display:block;
        }

        header{
            position:fixed;
            top:0;
            left:0;
            width:100%;
            z-index:1000;
            padding:18px 8%;
            display:flex;
            justify-content:space-between;
            align-items:center;
            background:rgba(11,17,32,.7);
            backdrop-filter:blur(12px);
            border-bottom:1px solid var(--border);
        }

        .logo{
            font-size:28px;
            font-weight:800;
            letter-spacing:.5px;
        }

        .logo span{
            color:var(--main);
        }

        nav{
            display:flex;
            gap:26px;
            flex-wrap:wrap;
        }

        nav a{
            color:#e5eefc;
            font-size:15px;
            font-weight:500;
            position:relative;
            transition:.3s;
        }

        nav a:hover{
            color:var(--main);
        }

        nav a::after{
            content:"";
            position:absolute;
            left:0;
            bottom:-6px;
            width:0;
            height:2px;
            background:var(--main);
            transition:.3s;
        }

        nav a:hover::after{
            width:100%;
        }

        section{
            padding:110px 8% 70px;
        }

        .hero{
            min-height:100vh;
            display:grid;
            grid-template-columns:1.1fr .9fr;
            align-items:center;
            gap:40px;
        }

        .tag{
            display:inline-block;
            padding:8px 16px;
            border:1px solid rgba(56,189,248,.25);
            background:rgba(56,189,248,.08);
            color:var(--main);
            border-radius:999px;
            font-size:14px;
            margin-bottom:18px;
            animation:fadeUp .8s ease;
        }

        .hero h1{
            font-size:58px;
            line-height:1.1;
            margin-bottom:16px;
            animation:fadeUp .9s ease;
        }

        .hero h1 span{
            color:var(--main);
            text-shadow:0 0 18px rgba(56,189,248,.35);
        }

        .hero h3{
            font-size:24px;
            color:#e2e8f0;
            font-weight:500;
            margin-bottom:18px;
            animation:fadeUp 1s ease;
        }

        .hero p{
            font-size:16px;
            color:var(--muted);
            max-width:620px;
            line-height:1.9;
            margin-bottom:30px;
            animation:fadeUp 1.1s ease;
        }

        .btn-group{
            display:flex;
            gap:14px;
            flex-wrap:wrap;
            animation:fadeUp 1.2s ease;
        }

        .btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:14px 26px;
            border-radius:12px;
            font-size:15px;
            font-weight:600;
            transition:.3s ease;
            border:1px solid transparent;
            cursor:pointer;
        }

        .btn-primary{
            background:linear-gradient(135deg, var(--main), var(--main2));
            color:#08111f;
            box-shadow:0 10px 25px rgba(34,211,238,.25);
        }

        .btn-primary:hover{
            transform:translateY(-3px);
            box-shadow:0 14px 30px rgba(34,211,238,.35);
        }

        .btn-outline{
            border:1px solid rgba(255,255,255,.14);
            background:rgba(255,255,255,.03);
            color:#fff;
        }

        .btn-outline:hover{
            border-color:var(--main);
            color:var(--main);
            transform:translateY(-3px);
        }

        .hero-image-wrap{
            display:flex;
            justify-content:center;
            align-items:center;
            animation:floatY 4s ease-in-out infinite;
        }

        .hero-card{
            width:360px;
            height:360px;
            border-radius:28px;
            padding:14px;
            background:linear-gradient(145deg, rgba(56,189,248,.26), rgba(34,211,238,.08), rgba(255,255,255,.03));
            box-shadow:var(--shadow);
            border:1px solid rgba(255,255,255,.08);
        }

        .hero-card-inner{
            width:100%;
            height:100%;
            border-radius:22px;
            overflow:hidden;
            background:#0f172a;
            display:flex;
            align-items:center;
            justify-content:center;
            position:relative;
        }

        .hero-card-inner img{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .hero-badge{
            position:absolute;
            bottom:16px;
            left:16px;
            padding:10px 14px;
            border-radius:14px;
            background:rgba(15,23,42,.78);
            backdrop-filter:blur(10px);
            border:1px solid rgba(255,255,255,.08);
            font-size:13px;
            color:#e2e8f0;
        }

        .section-title{
            text-align:center;
            margin-bottom:50px;
        }

        .section-title h2{
            font-size:38px;
            margin-bottom:10px;
        }

        .section-title h2 span{
            color:var(--main);
        }

        .section-title p{
            color:var(--muted);
            max-width:680px;
            margin:0 auto;
            line-height:1.8;
            font-size:15px;
        }

        .about{
            background:rgba(255,255,255,.025);
            border-top:1px solid rgba(255,255,255,.04);
            border-bottom:1px solid rgba(255,255,255,.04);
        }

        .about-grid{
            display:grid;
            grid-template-columns:1fr 1.2fr;
            gap:34px;
            align-items:center;
        }

        .about-image{
            background:linear-gradient(180deg, rgba(56,189,248,.14), rgba(255,255,255,.02));
            border:1px solid var(--border);
            border-radius:26px;
            overflow:hidden;
            min-height:430px;
            box-shadow:var(--shadow);
        }

        .about-image img{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .about-content h3{
            font-size:28px;
            margin-bottom:16px;
        }

        .about-content p{
            color:var(--muted);
            line-height:1.95;
            margin-bottom:16px;
            font-size:15px;
        }

        .stats{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:16px;
            margin-top:28px;
        }

        .stat{
            background:rgba(255,255,255,.03);
            border:1px solid var(--border);
            border-radius:18px;
            padding:22px 18px;
            text-align:center;
        }

        .stat h4{
            font-size:28px;
            color:var(--main);
            margin-bottom:6px;
        }

        .stat p{
            margin:0;
            font-size:13px;
            color:#dbeafe;
        }

        .skills-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:20px;
        }

        .skill-card{
            background:linear-gradient(180deg, rgba(255,255,255,.04), rgba(255,255,255,.02));
            border:1px solid var(--border);
            border-radius:22px;
            padding:26px 22px;
            transition:.35s ease;
            box-shadow:var(--shadow);
        }

        .skill-card:hover{
            transform:translateY(-8px);
            border-color:rgba(56,189,248,.35);
        }

        .skill-card .icon{
            width:54px;
            height:54px;
            border-radius:14px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:24px;
            background:rgba(56,189,248,.12);
            margin-bottom:16px;
        }

        .skill-card h3{
            font-size:20px;
            margin-bottom:10px;
        }

        .skill-card p{
            color:var(--muted);
            font-size:14px;
            line-height:1.8;
        }

        .projects{
            background:rgba(255,255,255,.025);
        }

        .project-grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:22px;
        }

        .project-card{
            background:#111827;
            border:1px solid var(--border);
            border-radius:24px;
            overflow:hidden;
            transition:.35s ease;
            box-shadow:var(--shadow);
        }

        .project-card:hover{
            transform:translateY(-10px);
            border-color:rgba(56,189,248,.35);
        }

        .project-image{
            height:220px;
            overflow:hidden;
            position:relative;
        }

        .project-image img{
            width:100%;
            height:100%;
            object-fit:cover;
            transition:.45s ease;
        }

        .project-card:hover .project-image img{
            transform:scale(1.08);
        }

        .project-body{
            padding:22px;
        }

        .project-body h3{
            font-size:21px;
            margin-bottom:10px;
        }

        .project-body p{
            color:var(--muted);
            line-height:1.8;
            font-size:14px;
            margin-bottom:18px;
        }

        .project-tags{
            display:flex;
            flex-wrap:wrap;
            gap:10px;
        }

        .project-tags span{
            font-size:12px;
            padding:7px 12px;
            border-radius:999px;
            background:rgba(56,189,248,.08);
            color:var(--main);
            border:1px solid rgba(56,189,248,.16);
        }

        .empty-projects{
            grid-column:1 / -1;
            text-align:center;
            padding:40px 20px;
            background:rgba(255,255,255,.03);
            border:1px dashed rgba(255,255,255,.12);
            border-radius:20px;
            color:var(--muted);
        }

        .contact-wrap{
            max-width:900px;
            margin:0 auto;
            display:grid;
            grid-template-columns:.9fr 1.1fr;
            gap:24px;
        }

        .contact-info,
        .contact-form{
            background:rgba(255,255,255,.03);
            border:1px solid var(--border);
            border-radius:24px;
            padding:28px;
            box-shadow:var(--shadow);
        }

        .contact-info h3,
        .contact-form h3{
            font-size:24px;
            margin-bottom:14px;
        }

        .contact-info p{
            color:var(--muted);
            line-height:1.9;
            font-size:14px;
            margin-bottom:22px;
        }

        .contact-item{
            padding:14px 0;
            border-bottom:1px solid rgba(255,255,255,.06);
            font-size:14px;
            color:#e2e8f0;
        }

        .contact-item:last-child{
            border-bottom:none;
        }

        .message-box{
            margin-bottom:16px;
            padding:14px 16px;
            border-radius:14px;
            font-size:14px;
            background:rgba(56,189,248,.08);
            border:1px solid rgba(56,189,248,.2);
            color:#eaf8ff;
        }

        form{
            width:100%;
        }

        .row{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:14px;
        }

        .input-group{
            margin-bottom:14px;
        }

        input,
        textarea{
            width:100%;
            padding:14px 16px;
            border-radius:14px;
            background:#0f172a;
            border:1px solid rgba(255,255,255,.08);
            color:#fff;
            font-size:14px;
            transition:.25s;
        }

        input::placeholder,
        textarea::placeholder{
            color:#94a3b8;
        }

        input:focus,
        textarea:focus{
            border-color:rgba(56,189,248,.45);
            box-shadow:0 0 0 4px rgba(56,189,248,.08);
        }

        textarea{
            min-height:160px;
            resize:vertical;
        }

        footer{
            padding:24px 8%;
            border-top:1px solid rgba(255,255,255,.06);
            color:#94a3b8;
            text-align:center;
            font-size:14px;
            background:rgba(255,255,255,.02);
        }

        @keyframes fadeUp{
            from{
                opacity:0;
                transform:translateY(25px);
            }
            to{
                opacity:1;
                transform:translateY(0);
            }
        }

        @keyframes floatY{
            0%,100%{ transform:translateY(0); }
            50%{ transform:translateY(-10px); }
        }

        @media (max-width: 1100px){
            .hero,
            .about-grid,
            .contact-wrap{
                grid-template-columns:1fr;
            }

            .hero{
                text-align:center;
            }

            .btn-group{
                justify-content:center;
            }

            .hero p{
                margin-left:auto;
                margin-right:auto;
            }

            .hero-image-wrap{
                order:-1;
            }

            .skills-grid{
                grid-template-columns:repeat(2,1fr);
            }

            .project-grid{
                grid-template-columns:repeat(2,1fr);
            }
        }

        @media (max-width: 760px){
            header{
                padding:16px 5%;
                align-items:flex-start;
                gap:10px;
                flex-direction:column;
            }

            section{
                padding:110px 5% 60px;
            }

            .hero h1{
                font-size:42px;
            }

            .hero h3{
                font-size:20px;
            }

            .section-title h2{
                font-size:31px;
            }

            .row,
            .stats,
            .skills-grid,
            .project-grid{
                grid-template-columns:1fr;
            }

            .hero-card{
                width:100%;
                max-width:340px;
                height:340px;
            }

            nav{
                gap:16px;
            }
        }
    </style>
</head>
<body>

<header>
    <a href="#" class="logo">Ekuna<span>.</span></a>
    <nav>
<a href="#home">Home</a>
<a href="#projects">Projects</a>

<?php if(isset($_SESSION["admin"])) { ?>
    <a href="add_project.php">Add Project</a>
    <a href="projects.php">Manage</a>
    <a href="messages.php">Messages</a>
    <a href="logout.php">Logout</a>
<?php } else { ?>
    <a href="login.php">Login</a>
<?php } ?>

</nav>
</header>

<section class="hero" id="home">
    <div class="hero-content">
        <div class="tag">Welcome to my portfolio</div>
        <h1>Hello, I'm <span>Ekuna</span></h1>
        <h3>Web Developer & System Builder</h3>
        <p>
            I create clean, modern, and database-powered websites using HTML, CSS, PHP, and MySQL.
            I enjoy building real projects like portfolio websites, admin dashboards, and service management systems.
        </p>

        <div class="btn-group">
            <a href="#projects" class="btn btn-primary">View Projects</a>
            <a href="#contact" class="btn btn-outline">Contact Me</a>
        </div>
    </div>

    <div class="hero-image-wrap">
        <div class="hero-card">
            <div class="hero-card-inner">
                <img src="https://via.placeholder.com/600x700.png?text=Your+Photo" alt="Profile Photo">
                <div class="hero-badge">Available for web projects</div>
            </div>
        </div>
    </div>
</section>

<section class="about" id="about">
    <div class="section-title">
        <h2>About <span>Me</span></h2>
        <p>
            A short introduction about my skills, experience, and the type of work I like to create.
        </p>
    </div>

    <div class="about-grid">
        <div class="about-image">
            <img src="https://via.placeholder.com/700x900.png?text=About+Image" alt="About Me">
        </div>

        <div class="about-content">
            <h3>I build websites that look modern and work smoothly.</h3>
            <p>
                I am interested in frontend design, backend logic, and database-based systems. I enjoy turning ideas into full websites that are clean, responsive, and easy to use.
            </p>
            <p>
                My goal is to create professional-looking projects that are not only visually attractive, but also practical and functional in real use.
            </p>

            <div class="stats">
                <div class="stat">
                    <h4>3+</h4>
                    <p>Projects Built</p>
                </div>
                <div class="stat">
                    <h4>100%</h4>
                    <p>Responsive Design</p>
                </div>
                <div class="stat">
                    <h4>24/7</h4>
                    <p>Learning Mode</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="skills">
    <div class="section-title">
        <h2>My <span>Skills</span></h2>
        <p>
            These are the main technologies and strengths I use when building modern web projects.
        </p>
    </div>

    <div class="skills-grid">
        <div class="skill-card">
            <div class="icon">💻</div>
            <h3>HTML & CSS</h3>
            <p>I build clean layouts, responsive pages, portfolio sites, and modern landing page interfaces.</p>
        </div>

        <div class="skill-card">
            <div class="icon">⚙️</div>
            <h3>PHP</h3>
            <p>I create dynamic pages, form handling, admin panels, and backend logic for small systems.</p>
        </div>

        <div class="skill-card">
            <div class="icon">🗄️</div>
            <h3>MySQL Database</h3>
            <p>I connect forms, projects, and admin pages to MySQL using phpMyAdmin and PHP.</p>
        </div>

        <div class="skill-card">
            <div class="icon">🎨</div>
            <h3>UI Design</h3>
            <p>I focus on clean colors, spacing, hover effects, and a modern visual style that feels professional.</p>
        </div>
    </div>
</section>

<section class="projects" id="projects">
    <div class="section-title">
        <h2>Latest <span>Projects</span></h2>
        <p>
            These projects are loaded from the database.
        </p>
    </div>

    <div class="project-grid">
        <?php
        $projectResult = $conn->query("SELECT * FROM projects ORDER BY id DESC LIMIT 6");

        if ($projectResult && $projectResult->num_rows > 0) {
            while ($row = $projectResult->fetch_assoc()) {
        ?>
            <div class="project-card">
                <div class="project-image">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Project Image">
                </div>
                <div class="project-body">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <div class="project-tags">
                        <span><?php echo htmlspecialchars($row['tech']); ?></span>
                    </div>
                </div>
            </div>
        <?php
            }
        } else {
            echo '<div class="empty-projects">Одоогоор project алга байна. <a href="add_project.php" style="color:#38bdf8;">Add Project</a> дээр дарж нэмээрэй.</div>';
        }
        ?>
    </div>
</section>

<section id="contact">
    <div class="section-title">
        <h2>Contact <span>Me</span></h2>
        <p>
            Send me a message through the form below. It will be saved to the database.
        </p>
    </div>

    <div class="contact-wrap">
        <div class="contact-info">
            <h3>Let's work together</h3>
            <p>
                If you need a portfolio website, a PHP form system, or a simple admin dashboard, you can leave a message here.
            </p>

            <div class="contact-item"><strong>Email:</strong> Eeba29777@gmail.com</div>
            <div class="contact-item"><strong>Phone:</strong> +976 9811 4351</div>
            <div class="contact-item"><strong>Location:</strong> Ulaanbaatar, Mongolia</div>
        </div>

        <div class="contact-form">
            <h3>Send Message</h3>

            <?php if (!empty($msg)) : ?>
                <div class="message-box"><?php echo htmlspecialchars($msg); ?></div>
            <?php endif; ?>

            <form method="POST" action="#contact">
                <div class="row">
                    <div class="input-group">
                        <input type="text" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Your Email" required>
                    </div>
                </div>

                <div class="row">
                    <div class="input-group">
                        <input type="text" name="phone" placeholder="Phone Number">
                    </div>
                    <div class="input-group">
                        <input type="text" name="subject" placeholder="Subject">
                    </div>
                </div>

                <div class="input-group">
                    <textarea name="message" placeholder="Write your message..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </div>
</section>

<footer>
    © 2026 Ekuna Portfolio. All rights reserved.
</footer>

</body>
</html>