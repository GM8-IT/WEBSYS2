<x-app-layout>

    <div class="py-10 px-6">

        <div class="max-w-7xl mx-auto space-y-8">

            <div class="flex items-end justify-between">
                <div>
                    <h1 class="text-4xl font-bold tracking-tight text-white">
                        Welcome Back 👋
                    </h1>
                    <p class="text-white/60 mt-2">
                        Real-time analytics overview
                    </p>
                </div>

                <button class="px-5 py-2 rounded-2xl bg-blue-500/20 border border-blue-400/30
                text-blue-300 backdrop-blur-xl hover:bg-blue-500/30 transition">
                    + New Report
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div class="rounded-3xl border border-white/10 bg-white/5
                    backdrop-blur-xl shadow-2xl p-6
                    hover:scale-105 transition duration-300">

                    <p class="text-white/60 text-sm">Total Sales</p>
                    <h2 class="text-3xl font-bold text-white mt-2">
                     ₱{{ collect($data ?? [])->sum() }}
                    </h2>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl shadow-2xl p-6 hover:scale-105 transition">
                    <p class="text-white/60 text-sm">Active Orders</p>
                    <h2 class="text-3xl font-bold text-blue-400 mt-2">245</h2>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl shadow-2xl p-6 hover:scale-105 transition">
                    <p class="text-white/60 text-sm">Returned Items</p>
                    <h2 class="text-3xl font-bold text-blue-400 mt-2">38</h2>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl shadow-2xl p-6 hover:scale-105 transition">
                    <p class="text-white/60 text-sm">Growth</p>
                    <h2 class="text-3xl font-bold text-blue-400 mt-2">+18%</h2>
                </div>

            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl shadow-2xl p-8">

                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-white">
                            Sales Performance
                        </h2>
                        <p class="text-white/50 text-sm">
                            Monthly breakdown (live database)
                        </p>
                    </div>

                    <div class="px-4 py-2 rounded-2xl bg-blue-500/20 text-blue-300 border border-blue-400/30">
                        Live Data
                    </div>
                </div>

                <div class="h-[420px]">
                    <canvas id="salesChart"></canvas>
                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labels = @json($labels ?? []); 
        const data = @json($data ?? []);

        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sales',
                    data: data,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.15)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: '#fff'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: 'rgba(255,255,255,0.6)' },
                        grid: { color: 'rgba(255,255,255,0.05)' }
                    },
                    y: {
                        ticks: { color: 'rgba(255,255,255,0.6)' },
                        grid: { color: 'rgba(255,255,255,0.05)' }
                    }
                }
            }
        });
    </script>

</x-app-layout>