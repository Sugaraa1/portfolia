
const supabase = window.supabase.createClient(
  "https://vubbkhcrvrihmztjmifl.supabase.co",
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InZ1YmJraGNydnJpaG16dGptaWZsIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzczMDEzNjAsImV4cCI6MjA5Mjg3NzM2MH0.d7CgYNAToZwMxK9EiHkFbp76d1mlgK2i7PFYtIGqMEY"
);

// ---------- AUTH ----------
async function checkAuth() {
  const { data: { session } } = await supabase.auth.getSession();
  if (!session) window.location.href = "login.html";
}

async function logout() {
  await supabase.auth.signOut();
  window.location.href = "login.html";
}

// ---------- PROJECTS ----------
async function loadProjects() {
  const { data } = await supabase.from("projects").select("*");

  document.getElementById("projectList").innerHTML = (data || [])
    .map(p => `
      <div class="card">
        <b>${p.title}</b>
        <p>${p.description || ""}</p>
        <button onclick="deleteProject(${p.id})">Delete</button>
      </div>
    `).join("");
}

async function addProject() {
  const title = document.getElementById("projectTitle").value;
  const description = document.getElementById("projectDesc").value;

  await supabase.from("projects").insert([{ title, description }]);
  loadProjects();
}

async function deleteProject(id) {
  await supabase.from("projects").delete().eq("id", id);
  loadProjects();
}

// ---------- SKILLS ----------
async function loadSkills() {
  const { data } = await supabase.from("skills").select("*");

  document.getElementById("skillsList").innerHTML = (data || [])
    .map(s => `
      <div class="card">
        ${s.skill_name}
        <button onclick="deleteSkill(${s.id})">X</button>
      </div>
    `).join("");
}

async function addSkill() {
  const skill = document.getElementById("skillName").value;
  const order = document.getElementById("skillOrder").value;

  await supabase.from("skills").insert([
    { skill_name: skill, sort_order: order }
  ]);

  loadSkills();
}

async function deleteSkill(id) {
  await supabase.from("skills").delete().eq("id", id);
  loadSkills();
}

// ---------- CONTACT (UPSERT илүү зөв) ----------
async function saveContact() {
  const email = document.getElementById("email").value;
  const phone = document.getElementById("phone").value;
  const address = document.getElementById("address").value;

  await supabase.from("contact_info").upsert([
    { id: 1, email, phone, address }
  ]);

  alert("Saved!");
}