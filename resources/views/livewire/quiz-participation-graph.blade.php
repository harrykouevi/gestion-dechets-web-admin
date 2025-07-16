<div>
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">📈 Évolution des participations aux quizzes</h6>
            <select  wire:model.lazy="filter" class="form-select w-auto">
                <option value="2">7 derniers jours</option>
                <option value="10">30 derniers jours</option>
                <option value="20">3 derniers mois</option>
            </select>
        </div>
        <div class="card-body">
            <canvas id="participationChart" height="100"></canvas>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('livewire:init', function () {
                    const ctx = document.getElementById('participationChart').getContext('2d');

                    window.participationChart = new Chart(ctx, {
                        type: 'line',
                        data: @js($chartData),
                        options: {
                            responsive: true,
                            scales: {
                                x: { title: { display: true, text: 'Date' } },
                                y: { beginAtZero: true, title: { display: true, text: 'Tentatives' } }
                            }
                        }
                    });
                });




                Livewire.on('updateChart', (data) => {
                    window.participationChart.data = data[0];
                    window.participationChart.update();
                });
            </script>
        @endpush
    </div>

</div>
