const supabaseClient = window.supabase.createClient(
  "https://vubbkhcrvrihmztjmifl.supabase.co",
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InZ1YmJraGNydnJpaG16dGptaWZsIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzczMDEzNjAsImV4cCI6MjA5Mjg3NzM2MH0.d7CgYNAToZwMxK9EiHkFbp76d1mlgK2i7PFYtIGqMEY"
);

// ---------- AUTH ----------
async function checkAuth() {
  const { data: { session } } = await supabaseClient.auth.getSession();
  if (!session) window.location.href = "login.html";
}

async function logout() {
  await supabaseClient.auth.signOut();
  window.location.href = "login.html";
}

// ---------- PROJECTS ----------
async function loadProjects() {
  const { data } = await supabaseClient.from("projects").select("*");
  const list = document.getElementById("projectList");
  if (!list) return;
  list.innerHTML = (data || []).map(p => `
    <div class="admin-card">
      <div class="admin-card-text">
        <b>${p.title}</b>
        <p>${p.description || ''}</p>
      </div>
      <button class="admin-btn danger" onclick="deleteProject(${p.id})">Устгах</button>
    </div>
  `).join('') || '<p style="color:var(--text-dim);font-size:.9rem">Төсөл байхгүй байна</p>';
}

async function addProject() {
  const title = document.getElementById("projectTitle").value.trim();
  const description = document.getElementById("projectDesc").value.trim();
  const url = document.getElementById("projectUrl") ? document.getElementById("projectUrl").value.trim() : '';
  if (!title) return;
  await supabaseClient.from("projects").insert([{ title, description, url }]);
  document.getElementById("projectTitle").value = '';
  document.getElementById("projectDesc").value = '';
  if (document.getElementById("projectUrl")) document.getElementById("projectUrl").value = '';
  loadProjects();
}

async function deleteProject(id) {
  if (!confirm('Устгах уу?')) return;
  await supabaseClient.from("projects").delete().eq("id", id);
  loadProjects();
}

// ---------- SKILLS ----------
async function loadSkills() {
  const { data } = await supabaseClient.from("skills").select("*").order('sort_order');
  const list = document.getElementById("skillsList");
  if (!list) return;
  list.innerHTML = (data || []).map(s => `
    <div class="admin-card">
      <div class="admin-card-text">
        <b>${s.skill_name}</b>
        <span style="color:var(--text-dim);font-size:.8rem;margin-left:8px">#${s.sort_order}</span>
      </div>
      <button class="admin-btn danger" onclick="deleteSkill(${s.id})">X</button>
    </div>
  `).join('') || '<p style="color:var(--text-dim);font-size:.9rem">Чадвар байхгүй байна</p>';
}

async function addSkill() {
  const skill = document.getElementById("skillName").value.trim();
  const order = document.getElementById("skillOrder").value || 1;
  if (!skill) return;
  await supabaseClient.from("skills").insert([{ skill_name: skill, sort_order: order }]);
  document.getElementById("skillName").value = '';
  loadSkills();
}

async function deleteSkill(id) {
  await supabaseClient.from("skills").delete().eq("id", id);
  loadSkills();
}

// ---------- CONTACT ----------
async function loadContact() {
  const { data } = await supabaseClient.from("contact_info").select("*").eq('id', 1).single();
  if (data) {
    if (document.getElementById("email")) document.getElementById("email").value = data.email || '';
    if (document.getElementById("phone")) document.getElementById("phone").value = data.phone || '';
    if (document.getElementById("address")) document.getElementById("address").value = data.address || '';
  }
}

async function saveContact() {
  const email = document.getElementById("email").value;
  const phone = document.getElementById("phone").value;
  const address = document.getElementById("address").value;
  const { error } = await supabaseClient.from("contact_info").upsert([{ id: 1, email, phone, address }]);
  if (error) alert('Алдаа: ' + error.message);
  else {
    const btn = document.getElementById('saveBtn');
    btn.textContent = '✓ Хадгалагдлаа!';
    setTimeout(() => btn.textContent = 'Хадгалах', 2000);
  }
}