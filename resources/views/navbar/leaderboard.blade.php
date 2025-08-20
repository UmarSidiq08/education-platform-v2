<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leaderboard - Papan Peringkat</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes float {

      0%,
      100% {
        transform: translateX(-50%) translateY(0px);
      }

      50% {
        transform: translateX(-50%) translateY(-8px);
      }
    }

    .float {
      animation: float 2s ease-in-out infinite;
    }

    /* Background pastel gradient */
    .gradient-bg {
      background: linear-gradient(135deg, #eef2ff 0%, #c7d2fe 100%);
    }

    .glass {
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(12px);
    }

    .glass-white {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(12px);
    }

    /* Status badge pastel */
    .status-online {
      background: #86efac;
      color: #065f46;
    }

    .status-away {
      background: #fdba74;
      color: #7c2d12;
    }

    .status-offline {
      background: #cbd5e1;
      color: #334155;
    }

    /* Hover effect */
    .player-row:hover {
      background: rgba(191, 219, 254, 0.4);
      transform: translateX(6px);
    }
  </style>
</head>

<body class="gradient-bg min-h-screen pt-32 px-5 font-sans text-gray-800">
  <div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-8 text-white">
        <h1 class="text-5xl font-bold mb-2 drop-shadow-lg">🏆 Leaderboard</h1>
        <p class="text-lg opacity-90">Papan Peringkat Kompetisi Global</p>
    </div>
    <div class="text-center mb-8">
      <h1 class="text-5xl font-bold mb-2 drop-shadow-md text-indigo-600">🏆 Leaderboard</h1>
      <p class="text-lg text-gray-600">Papan Peringkat Kompetisi Global</p>
    </div>

    <!-- Filter Tabs -->
    <div class="flex justify-center gap-4 mb-8 flex-wrap">
      <button
        class="glass border border-white/20 text-gray-700 px-6 py-2 rounded-full hover:bg-white/40 transition-all tab-btn"
        data-period="weekly">Mingguan</button>
      <button
        class="glass border border-white/20 text-gray-700 px-6 py-2 rounded-full hover:bg-white/40 transition-all tab-btn"
        data-period="monthly">Bulanan</button>
      <button
        class="glass border border-white/20 text-gray-700 px-6 py-2 rounded-full hover:bg-white/40 transition-all tab-btn"
        data-period="yearly">Tahunan</button>
      <button
        class="glass border border-white/20 text-gray-700 px-6 py-2 rounded-full hover:bg-white/40 transition-all tab-btn"
        data-period="alltime">Sepanjang Masa</button>
    </div>

    <!-- Podium -->
    <div class="flex justify-center items-end gap-6 mb-10">
      <!-- 2nd Place -->
      <div class="text-center hover:-translate-y-2 transition-all">
        <div
          class="w-20 h-20 rounded-full bg-gradient-to-br from-slate-200 to-slate-400 flex items-center justify-center text-4xl mb-3 border-2 border-white/50 shadow-lg relative">
          🥈
        </div>
        <div class="font-bold mb-1">Sarah J.</div>
        <div class="text-xl font-bold text-indigo-600">2,847</div>
      </div>

      <!-- 1st Place -->
      <div class="text-center hover:-translate-y-2 transition-all relative">
        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 text-2xl float">👑</div>
        <div
          class="w-24 h-24 rounded-full bg-gradient-to-br from-yellow-300 to-yellow-500 flex items-center justify-center text-5xl mb-3 border-2 border-yellow-400 shadow-xl relative">
          🥇
        </div>
        <div class="font-bold mb-1">Ahmad R.</div>
        <div class="text-2xl font-bold text-indigo-700">3,256</div>
      </div>

      <!-- 3rd Place -->
      <div class="text-center hover:-translate-y-2 transition-all">
        <div
          class="w-20 h-20 rounded-full bg-gradient-to-br from-amber-300 to-amber-600 flex items-center justify-center text-4xl mb-3 border-2 border-white/50 shadow-lg relative">
          🥉
        </div>
        <div class="font-bold mb-1">Maria S.</div>
        <div class="text-xl font-bold text-indigo-600">2,634</div>
      </div>
    </div>

    <!-- Leaderboard Table -->
    <div class="glass-white rounded-2xl overflow-hidden shadow-2xl mb-6">
      <!-- Table Header -->
      <div class="bg-indigo-500 text-white p-4 grid grid-cols-5 gap-4 font-bold text-sm">
        <div class="text-center">Rank</div>
        <div>Player</div>
        <div class="text-center">Score</div>
        <div class="text-center hidden md:block">Achievements</div>
        <div class="text-center hidden md:block">Status</div>
      </div>

      <!-- Example Row -->
      <div
        class="player-row grid grid-cols-5 md:grid-cols-5 gap-4 p-4 border-b border-gray-100 transition-all items-center">
        <div class="text-center font-bold text-lg text-indigo-600">1</div>
        <div class="flex items-center gap-3">
          <div
            class="w-10 h-10 rounded-full bg-indigo-300 flex items-center justify-center text-white font-bold shadow-md">
            AR</div>
          <div>
            <div class="font-semibold">Ahmad Rizki</div>
            <div class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded-lg inline-block">Level 47</div>
          </div>
        </div>
        <div class="text-center font-bold text-indigo-600">3,256</div>
        <div class="text-center hidden md:block text-indigo-500 font-medium">18</div>
        <div class="text-center hidden md:block">
          <span class="status-online px-3 py-1 rounded-full text-xs font-bold uppercase">Online</span>
        </div>
      </div>

      <!-- Tambahin row lain sesuai data -->
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="glass border border-white/20 rounded-xl p-5 text-center hover:-translate-y-1 transition-all">
        <div class="text-3xl font-bold mb-2 text-indigo-600 stat-number">156</div>
        <div class="text-sm text-gray-700">Total Players</div>
      </div>
      <div class="glass border border-white/20 rounded-xl p-5 text-center hover:-translate-y-1 transition-all">
        <div class="text-3xl font-bold mb-2 text-indigo-600 stat-number">89</div>
        <div class="text-sm text-gray-700">Online Now</div>
      </div>
      <div class="glass border border-white/20 rounded-xl p-5 text-center hover:-translate-y-1 transition-all">
        <div class="text-3xl font-bold mb-2 text-indigo-600 stat-number">2,847</div>
        <div class="text-sm text-gray-700">Avg Score</div>
      </div>
      <div class="glass border border-white/20 rounded-xl p-5 text-center hover:-translate-y-1 transition-all">
        <div class="text-3xl font-bold mb-2 text-indigo-600 stat-number">12.5</div>
        <div class="text-sm text-gray-700">Avg Level</div>
      </div>
    </div>
  </div>

  <script>
    // Animate stats on load
    window.addEventListener('load', () => {
      document.querySelectorAll('.stat-number').forEach(stat => {
        const target = parseFloat(stat.textContent);
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
          current += increment;
          if (current >= target) {
            stat.textContent = target % 1 === 0 ? target : target.toFixed(1);
            clearInterval(timer);
          } else {
            stat.textContent = current % 1 === 0 ? Math.floor(current) : current.toFixed(1);
          }
        }, 30);
      });
    });
  </script>
  @include('layouts.app')
</body>

</html>
