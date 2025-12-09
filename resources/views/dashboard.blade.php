<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    <livewire:page-settings />
                    
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="font-bold text-lg mb-4">Statistik Kunjungan Link</h3>
                            <div id="chart"></div>
                        </div>
                    </div>

                    <livewire:link-manager />

                </div>

                <div class="hidden lg:block sticky top-8">
                    
                    <div class="text-center mb-4">
                        <h3 class="font-bold text-gray-700">Live Preview</h3>
                        <p class="text-xs text-gray-500">Tampilan real-time halaman Anda</p>
                    </div>

                    <div class="relative mx-auto border-gray-900 dark:border-gray-900 bg-gray-900 border-[14px] rounded-[2.5rem] h-[600px] w-[300px] shadow-xl">
                        
                        <div class="w-[148px] h-[18px] bg-gray-900 top-0 rounded-b-[1rem] left-1/2 -translate-x-1/2 absolute z-10"></div>
                        
                        <div class="h-[32px] w-[3px] bg-gray-800 absolute -left-[17px] top-[72px] rounded-l-lg"></div>
                        <div class="h-[46px] w-[3px] bg-gray-800 absolute -left-[17px] top-[124px] rounded-l-lg"></div>
                        <div class="h-[64px] w-[3px] bg-gray-800 absolute -right-[17px] top-[142px] rounded-r-lg"></div>
                        
                        <div class="rounded-[2rem] overflow-hidden w-full h-full bg-white dark:bg-gray-800">
                            <iframe id="preview-frame" 
                                    src="{{ route('public.page', Auth::user()->page->slug) }}" 
                                    class="w-full h-full border-0"
                                    title="Live Preview">
                            </iframe>
                        </div>

                    </div>
                    
                    <div class="text-center mt-4">
                        <button onclick="document.getElementById('preview-frame').src += ''" class="text-xs text-indigo-500 hover:underline">
                            Refresh Preview
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            
            // 1. RENDER CHART
            @php
                $userLinks = Auth::user()->page->links()->where('is_header', false)->get();
                $titles = $userLinks->pluck('title')->toArray();
                $clicks = $userLinks->pluck('click_count')->toArray();
            @endphp

            var options = {
                series: [{ name: 'Jumlah Klik', data: @json($clicks) }],
                chart: { type: 'bar', height: 350, fontFamily: 'Figtree, sans-serif', toolbar: {show: false} },
                plotOptions: { bar: { borderRadius: 4, horizontal: true } },
                dataLabels: { enabled: true },
                xaxis: { categories: @json($titles) },
                colors: ['#4F46E5'],
                title: { text: 'Link Terpopuler', align: 'left', style: { fontSize: '14px' } }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();


            // 2. LOGIC LIVE PREVIEW REFRESH
            // Setiap kali Livewire memancarkan event 'contentUpdated', refresh iframe
            window.addEventListener('contentUpdated', event => {
                const iframe = document.getElementById('preview-frame');
                if(iframe) {
                    console.log('Refreshing Preview...');
                    // Teknik refresh iframe tanpa kedip putih berlebihan
                    iframe.src = iframe.src; 
                }
            });

        });
    </script>
</x-app-layout>