<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <livewire:page-settings />
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Statistik Kunjungan Link</h3>
                    
                    <div id="chart"></div>
                </div>
            </div>

            <livewire:link-manager />

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            
            // Ambil data dari PHP (LinkManager) yang dikirim ke View
            // Kita ambil data Link milik user yang sedang login
            @php
                $userLinks = Auth::user()->page->links()->where('is_header', false)->get();
                $titles = $userLinks->pluck('title')->toArray();
                $clicks = $userLinks->pluck('click_count')->toArray();
            @endphp

            var options = {
                series: [{
                    name: 'Jumlah Klik',
                    data: @json($clicks) // Data angka klik
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    fontFamily: 'Figtree, sans-serif',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true, // Bar ke samping biar nama link panjang muat
                    }
                },
                dataLabels: {
                    enabled: true
                },
                xaxis: {
                    categories: @json($titles), // Data nama link
                },
                colors: ['#4F46E5'], // Warna Indigo sesuai tema
                title: {
                    text: 'Link Terpopuler Anda',
                    align: 'center'
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        });
    </script>
</x-app-layout>