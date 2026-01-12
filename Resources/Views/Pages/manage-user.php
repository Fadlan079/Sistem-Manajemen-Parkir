<div class="max-w-7xl lg:ml-30 mx-auto px-6 py-6 space-y-6 bg-gradient-to-br from-gray-900 to-gray-800 text-text">

  <!-- Top Summary / KPI -->
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
    <div class="p-4 bg-gray-900/50 rounded-2xl shadow-xl flex flex-col items-center justify-center hover:scale-105 transition transform">
      <div class="text-sm text-muted mb-1">Total Users</div>
      <div class="text-2xl font-bold text-blue-400 glow"><?= $totalUsers ?? count($listUser) ?></div>
    </div>
    <div class="p-4 bg-gray-900/50 rounded-2xl shadow-xl flex flex-col items-center justify-center hover:scale-105 transition transform">
      <div class="text-sm text-muted mb-1">Admin</div>
      <div class="text-2xl font-bold text-indigo-400 glow"><?= $totalAdmin ?? 0 ?></div>
    </div>
    <div class="p-4 bg-gray-900/50 rounded-2xl shadow-xl flex flex-col items-center justify-center hover:scale-105 transition transform">
      <div class="text-sm text-muted mb-1">Petugas</div>
      <div class="text-2xl font-bold text-yellow-400 glow"><?= $totalPetugas ?? 0 ?></div>
    </div>
    <div class="p-4 bg-gray-900/50 rounded-2xl shadow-xl flex flex-col items-center justify-center hover:scale-105 transition transform">
      <div class="text-sm text-muted mb-1">User Aktif</div>
      <div class="text-2xl font-bold text-green-400 glow"><?= $activeUsers ?? 0 ?></div>
    </div>
  </div>

  <!-- Search + Filter -->
  <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
    <input type="text" placeholder="Cari user..." id="searchUser"
           class="w-full sm:w-1/2 px-4 py-2 rounded-lg bg-gray-900/30 text-text border border-gray-700 placeholder:text-muted focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
    
    <select id="filterRole" class="px-4 py-2 rounded-lg bg-gray-900/30 text-text border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
      <option value="">Semua Role</option>
      <option value="admin">Admin</option>
      <option value="petugas">Petugas</option>
    </select>

    <a href="?action=tambah-user" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-bg rounded-lg shadow-lg flex items-center gap-2">
      <i class="fa-solid fa-user-plus"></i> Tambah User
    </a>
  </div>

  <!-- User Table / Card Grid -->
  <div id="userContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
    <?php foreach($listUser as $user): ?>
    <?php
      $gender = $user['gender'] ?? '-';
      $genderLabel = $gender==='L'?'Laki-laki':($gender==='P'?'Perempuan':'-');
      $genderColor = $gender==='L'?'bg-blue-400/30 text-blue-300':($gender==='P'?'bg-pink-400/30 text-pink-300':'bg-gray-700 text-gray-400');

      $role = $user['role'] ?? '-';
      $roleMap = [
          'admin'=>['class'=>'bg-indigo-500 text-bg','label'=>'Admin'],
          'petugas'=>['class'=>'bg-yellow-500 text-bg','label'=>'Petugas']
      ];
      $roleColor = $roleMap[$role]['class'] ?? 'bg-gray-700 text-gray-400';
      $roleLabel = $roleMap[$role]['label'] ?? '-';
    ?>
    <div class="bg-gray-900/40 p-5 rounded-2xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1 relative">
      <div class="absolute top-3 right-3 flex gap-1">
        <span class="px-2 py-0.5 rounded text-xs font-semibold <?= $roleColor ?>"><?= $roleLabel ?></span>
        <span class="px-2 py-0.5 rounded text-xs font-semibold <?= $genderColor ?>"><?= $genderLabel ?></span>
      </div>
      <div class="flex items-center gap-4 mb-4">
        <div class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center text-lg font-bold text-text"><?= strtoupper($user['nama_lengkap'][0]) ?></div>
        <div>
          <h3 class="font-semibold text-lg"><?= htmlspecialchars($user['nama_lengkap']) ?></h3>
          <p class="text-sm text-muted"><?= htmlspecialchars($user['email']) ?></p>
        </div>
      </div>
      <div class="flex justify-between mb-4 text-sm text-muted">
        <div>Dibuat: <?= $user['created_at'] ? (new DateTime($user['created_at']))->format('d M Y') : '-' ?></div>
      </div>
      <div class="flex gap-2">
        <a href="?action=edit-user&id=<?= $user['id_user'] ?>" class="flex-1 py-2 bg-indigo-500 hover:bg-indigo-600 rounded-lg text-bg text-center transition">Edit</a>
        <a href="?action=delete-user&id=<?= $user['id_user'] ?>" onclick="return confirm('Yakin hapus?')" class="flex-1 py-2 bg-red-500 hover:bg-red-600 rounded-lg text-bg text-center transition">Hapus</a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

</div>

<script>
  // Simple live search filter
  const searchInput = document.getElementById('searchUser');
  const roleFilter = document.getElementById('filterRole');
  const userContainer = document.getElementById('userContainer');
  const cards = Array.from(userContainer.children);

  function filterUsers() {
    const query = searchInput.value.toLowerCase();
    const role = roleFilter.value;
    cards.forEach(card => {
      const name = card.querySelector('h3').innerText.toLowerCase();
      const email = card.querySelector('p').innerText.toLowerCase();
      const roleBadge = card.querySelector('span').innerText.toLowerCase();
      const matchesSearch = name.includes(query) || email.includes(query);
      const matchesRole = role === '' || roleBadge.includes(role);
      card.style.display = (matchesSearch && matchesRole) ? 'block' : 'none';
    });
  }

  searchInput.addEventListener('input', filterUsers);
  roleFilter.addEventListener('change', filterUsers);
</script>
