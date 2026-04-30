const ADMIN_USER = "admin";
const ADMIN_PASS = "123456";

function loginAdmin() {
    const user = document.getElementById("username").value;
    const pass = document.getElementById("password").value;

    if (user === ADMIN_USER && pass === ADMIN_PASS) {
        localStorage.setItem("adminLogin", "true");
        showAdmin();
    } else {
        document.getElementById("loginError").innerText = "Username эсвэл password буруу байна!";
    }
}

function showAdmin() {
    document.getElementById("loginBox").style.display = "none";
    document.getElementById("adminPanel").style.display = "block";
    loadAdminData();
    renderProjects();
}

function logoutAdmin() {
    localStorage.removeItem("adminLogin");
    location.reload();
}

function saveHero() {
    const heroData = {
        name: document.getElementById("adminName").value,
        title: document.getElementById("adminTitle").value,
        desc: document.getElementById("adminDesc").value
    };

    localStorage.setItem("heroData", JSON.stringify(heroData));
    alert("Амжилттай хадгаллаа!");
}

function loadAdminData() {
    const data = JSON.parse(localStorage.getItem("heroData"));

    if (data) {
        document.getElementById("adminName").value = data.name || "";
        document.getElementById("adminTitle").value = data.title || "";
        document.getElementById("adminDesc").value = data.desc || "";
    }
}

function addProject() {
    const title = document.getElementById("projectTitle").value;
    const desc = document.getElementById("projectDesc").value;
    const tech = document.getElementById("projectTech").value;

    if (!title || !desc) {
        alert("Төслийн нэр болон тайлбар оруул!");
        return;
    }

    const projects = JSON.parse(localStorage.getItem("projects")) || [];

    projects.push({
        id: Date.now(),
        title,
        desc,
        tech
    });

    localStorage.setItem("projects", JSON.stringify(projects));

    document.getElementById("projectTitle").value = "";
    document.getElementById("projectDesc").value = "";
    document.getElementById("projectTech").value = "";

    renderProjects();
}

function renderProjects() {
    const list = document.getElementById("projectList");
    if (!list) return;

    const projects = JSON.parse(localStorage.getItem("projects")) || [];

    list.innerHTML = "";

    projects.forEach(project => {
        list.innerHTML += `
      <div class="project-admin-item">
        <h3>${project.title}</h3>
        <p>${project.desc}</p>
        <small>${project.tech}</small>
        <br>
        <button onclick="deleteProject(${project.id})">Устгах</button>
      </div>
    `;
    });
}

function deleteProject(id) {
    let projects = JSON.parse(localStorage.getItem("projects")) || [];
    projects = projects.filter(p => p.id !== id);
    localStorage.setItem("projects", JSON.stringify(projects));
    renderProjects();
}

if (localStorage.getItem("adminLogin") === "true") {
    const loginBox = document.getElementById("loginBox");
    const adminPanel = document.getElementById("adminPanel");

    if (loginBox && adminPanel) {
        showAdmin();
    }
}